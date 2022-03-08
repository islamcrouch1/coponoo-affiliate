<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\Color;
use App\Country;
use App\Events\NewNotification;
use App\Exports\Product1Export;
use App\Imports\ProductImport;
use App\Notification;
use App\ProductImage;
use App\Size;
use App\Stock;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;

class VendorProductsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:vendor');
    }



    public function index()
    {
        $categories = Category::all();
        $countries = Country::all();
        $products = Product::where('user_id', Auth::id())
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->paginate(100);

        return view('dashboard.vendor-products.index')->with('products', $products)->with('categories', $categories)->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $colors = Color::all();
        $sizes = Size::all();
        $categories = Category::all();
        $countries = Country::all();
        return view('dashboard.vendor-products.create', compact('colors', 'categories', 'countries', 'sizes'));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([

            'name_ar' => "required|string",
            'name_en' => "required|string",
            'SKU' => "nullable",
            'images' => "required|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            // 'stock' => "required|string",
            'category_id' => "required",
            'colors'  => "array|required",
            'sizes'  => "array|required",

        ]);



        $category = Category::find($request['category_id']);

        $price =  ceil($request['vendor_price'] *  $category->profit / 100);


        $price = $price + $request['fixed_price'];

        $price1 = $price;


        $price = ceil($price * setting('tax') / 100);

        $price = $price + $price1;



        $total_profit = $price;


        $price = $price + $request['vendor_price'];



        $max_price = ceil($price * 150 / 100);

        $Product = Product::create([

            'user_id' => Auth::id(),
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'SKU' => $request['SKU'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => $request['vendor_price'],
            'min_price' => $price,
            'max_price' => $max_price,
            'total_profit' => $total_profit,
            // 'stock' => $request['stock'],
            'category_id' => $request['category_id'],
            'country_id' => $category->country->id,
            'status' => 'pending',
            'price' => $price,

        ]);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {

                Image::make($file)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/products/' . $file->hashName()), 60);

                ProductImage::create([

                    'product_id' => $Product->id,
                    'url' => $file->hashName(),
                ]);
            }
        }


        foreach ($request->colors as $color) {

            foreach ($request->sizes as $size) {


                $stock = Stock::create([

                    'color_id' => $color,
                    'size_id' => $size,
                    'product_id' => $Product->id,
                    'stock' => 0,

                ]);
            }
        }


        $user = Auth::user();


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();



        foreach ($users as $user1) {


            $title_ar = 'تم اضافة منتج';
            $body_ar = 'تم اضافة منتج جديد من  : ' . $user->name;
            $title_en = 'There is a new product';
            $body_en  = 'A new product has been added from : ' . $user->name;

            $notification1 = Notification::create([
                'user_id' => $user1->id,
                'user_name'  => $user->name,
                'user_image' => asset('storage/images/users/' . $user->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $request->updated_at,
                'status' => 0,
                'url' =>  route('products.index', ['lang' => app()->getLocale()]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $user1->id,
                'user_name'  => $user->name,
                'user_image' => asset('storage/images/users/' . $user->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('products.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user1->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }




        session()->flash('success', 'Product created successfully');
        return redirect()->route('products.vendor.stock.add', ['lang' => app()->getLocale(), 'product' => $Product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function showAddStock($lang, $Product, Request $request)
    {
        $Product = Product::find($Product);
        return view('dashboard.vendor-products.stock_add ')->with('product', $Product);
    }


    public function addStock($lang, Request $request, Product $Product)
    {

        $request->validate([

            'stock' => "required|array",
            'image' => "nullable|array"


        ]);


        $stock = $request->stock;


        foreach ($Product->stocks as $index => $product_stock) {

            if ($request->has('image')) {

                if (array_key_exists($product_stock->id, $request->image)) {

                    Image::make($request->image[$product_stock->id][0])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/products/' . $request->image[$product_stock->id][0]->hashName()), 60);

                    $product_stock->update([
                        'image' => $request->image[$product_stock->id][0]->hashName(),
                    ]);
                }
            }



            $product_stock->update([
                'stock' => $stock[$index],
            ]);
        }



        return redirect()->route('vendor-products.index', app()->getLocale());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $Product)
    {
        $categories = Category::all();
        $countries = Country::all();
        $Product = Product::find($Product);
        return view('dashboard.vendor-products.edit ')->with('Product', $Product)->with('categories', $categories)->with('countries', $countries);
    }

    public function addColor($lang, $Product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        $Product = Product::find($Product);
        return view('dashboard.vendor-products.add_color')->with('Product', $Product)->with('colors', $colors)->with('sizes', $sizes);
    }

    public function storeColor($lang, Request $request, Product $Product)
    {

        $request->validate([

            'color' => "required|string",
            'size' => "required|string",
            'stock' => "required|numeric",

        ]);


        foreach ($Product->stocks as $stock) {
            if ($request->color == $stock->color->id && $request->size == $stock->size->id) {

                if (app()->getLocale() == 'ar') {
                    session()->flash('success', 'هذا العنصر موجود بالفعل في المنتج يرجى التعديل على المنتج لزيادة المخزون');
                } else {
                    session()->flash('success', 'This item is already in the product, please modify the product to increase the stock');
                }

                return redirect()->route('vendor-products.index', app()->getLocale());
            }
        }


        $stock = Stock::create([

            'color_id' => $request['color'],
            'size_id' => $request['size'],
            'product_id' => $Product->id,
            'stock' => $request['stock'],

        ]);




        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم اضافة المخزون الى المنتج بنجاح');
        } else {
            session()->flash('success', 'Inventory has been added to the product successfully');
        }
        return redirect()->route('vendor-products.index', app()->getLocale());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, $Product)
    {


        $Product = Product::find($Product);


        $request->validate([

            'name_ar' => "required|string",
            'name_en' => "required|string",
            'SKU' => "nullable",
            'images' => "array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            // 'stock' => "required|string",
            'category_id' => "required",


        ]);




        if ($files = $request->file('images')) {



            foreach ($Product->images as $image) {

                Storage::disk('public')->delete('/images/products/' . $image->url);
                $image->delete();
            }



            foreach ($files as $file) {

                Image::make($file)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/products/' . $file->hashName()), 60);

                ProductImage::create([

                    'product_id' => $Product->id,
                    'url' => $file->hashName(),
                ]);
            }
        }





        $category = Category::find($request['category_id']);


        $Product->update([


            'user_id' => Auth::id(),
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'SKU' => $request['SKU'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => $request['vendor_price'],
            // 'stock' => $request['stock'],
            'category_id' => $request['category_id'],
            'country_id' => $category->country->id,


        ]);




        session()->flash('success', 'Product updated successfully');
        return redirect()->route('vendor-products.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $Product)
    {

        $Product = Product::withTrashed()->where('id', $Product)->first();


        if ($Product->trashed()) {


            foreach ($Product->images as $image) {

                Storage::disk('public')->delete('/images/products/' . $image->url);
                $image->delete();
            }

            $Product->forceDelete();


            session()->flash('success', 'Product Deleted successfully');
            return redirect()->route('products.trashed', app()->getLocale());
        } else {



            if ($Product->orders->count() > '0') {
                session()->flash('success', 'you can not delete this product because it is related with some users orders');
                return redirect()->route('vendor-products.index', app()->getLocale());
            }

            $Product->delete();

            session()->flash('success', 'Product trashed successfully');
            return redirect()->route('vendor-products.index', app()->getLocale());
        }
    }



    public function import(Request $request)
    {
        $file = $request->file('file')->store('import');


        $import = new ProductImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }


        if (!session('status')) {

            if (app()->getLocale() == 'ar') {
                return back()->withStatus('تم رفع الملف بنجاح.');
            } else {
                return back()->withStatus('The file has been uploaded successfully.');
            }
        } else {
            return back();
        }
    }

    public function productsExport()
    {
        return Excel::download(new Product1Export, 'products.xlsx');
    }
}
