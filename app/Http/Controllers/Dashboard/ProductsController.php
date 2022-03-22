<?php

namespace App\Http\Controllers\Dashboard;

use App\Aorder;
use App\Astock;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Color;
use App\Country;
use App\Notification;
use App\ProductImage;
use App\Size;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\NewNotification;
use App\Limit;
use App\Log;
use App\Slide;
use App\User;
use Carbon\Carbon;
use Exception;
use Intervention\Image\ImageManagerStatic as Image;

class ProductsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator|affiliate|vendor');

        $this->middleware('permission:products-read')->only('index', 'show');
        $this->middleware('permission:products-create')->only('create', 'store');
        $this->middleware('permission:products-update')->only('edit', 'update');
        $this->middleware('permission:products-delete|products-trash')->only('destroy', 'trashed');
        $this->middleware('permission:products-restore')->only('restore');
    }



    public function index()
    {
        $categories = Category::all();
        $countries = Country::all();

        if (isset(request()->category_id)) {
            $products = Product::whenSearch(request()->search)
                ->whereHas('categories', function ($query) {
                    $query->where('category_id', 'like', request()->category_id);
                })
                // whenCategory(request()->category_id)
                ->whenCountry(request()->country_id)
                ->whenStatus(request()->status)
                ->latest()
                ->paginate(100);
        } else {

            $products = Product::whenSearch(request()->search)
                ->whenCountry(request()->country_id)
                ->whenStatus(request()->status)
                ->latest()
                ->paginate(100);
        }



        return view('dashboard.products.index')->with('products', $products)->with('categories', $categories)->with('countries', $countries);
    }

    public function show($lang, Product $product)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.products.show', compact('categories', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $countries = Country::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('dashboard.products.create', compact('colors', 'categories', 'countries', 'sizes'));
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
            'SKU' => "required|string|unique:products",
            'images' => "required|array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            // 'min_price' => "required|string",
            // 'max_price' => "required|string",
            // 'stock' => "required|string",
            'categories' => "required|array",
            'status' => "required|string",
            'colors'  => "array|required",
            'sizes'  => "array|required",
            'fixed_price'  => "required|numeric",
            'user_id' => "required|string",

        ]);


        if (User::find($request['user_id']) != NULL) {

            $vendor = User::find($request['user_id']);

            if (!$vendor->hasRole('vendor')) {
                if (app()->getLocale() == 'ar') {
                    session()->flash('success', 'رقم التاجر المدخل غير صحيح');
                } else {
                    session()->flash('success', 'The vendor number entered is incorrect');
                }
                return redirect()->route('products.index', app()->getLocale());
            }
        } else {
            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'رقم التاجر المدخل غير صحيح');
            } else {
                session()->flash('success', 'The vendor number entered is incorrect');
            }
            return redirect()->route('products.index', app()->getLocale());
        }


        $average = 0;
        $count = 0;


        foreach ($request['categories'] as $category) {

            $category = Category::find($category);
            $average += ceil($category->profit);
            $count++;
        }

        $average = ceil($average / $count);



        $price =  ceil($request['vendor_price'] *  ceil($average) / 100);





        $price = $price + ceil($request['fixed_price']);


        $price1 = $price;


        $price = ceil($price * setting('tax') / 100);



        $price = $price + $price1;



        $total_profit = $price;




        $price = $price + ceil($request['vendor_price']);





        $max_price = ceil($price * setting('max_price') / 100);

        $Product = Product::create([

            'user_id' => $request['user_id'],
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'SKU' => $request['SKU'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => ceil($request['vendor_price']),
            'min_price' => ceil($price),
            'max_price' => ceil($max_price),
            'fixed_price' => ceil($request['fixed_price']),
            'total_profit' => $total_profit,
            // 'stock' => $request['stock'],
            'category_id' => 0,
            'country_id' => $category->country->id,
            'status' => $request['status'],
            'price' => $price,
            'vendor_id' => Auth::id(),



        ]);

        $Product->categories()->attach($request['categories']);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {


                // resize(300, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->

                Image::make($file)->save(public_path('storage/images/products/' . $file->hashName()), 80);

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

        if ($request['limited'] == 'on') {

            if (Limit::where('product_id', $Product->id)->get()->count() == 0) {

                $limit = Limit::create([
                    'product_id' => $Product->id,

                ]);
            }
        }


        $description_ar = ' تم إضافة منتج ' . '  منتج رقم' . ' #' . $Product->id . ' - SKU ' . $Product->SKU;
        $description_en  = "product added " . " product ID " . ' #' . $Product->id . ' - SKU ' . $Product->SKU;

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'products',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);

        session()->flash('success', 'Product created successfully');
        return redirect()->route('products.stock.add', ['lang' => app()->getLocale(), 'product' => $Product->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAddStock($lang, $Product, Request $request)
    {
        $Product = Product::find($Product);
        return view('dashboard.products.stock_add ')->with('product', $Product);
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

                    // ->resize(300, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    // })

                    Image::make($request->image[$product_stock->id][0])->save(public_path('storage/images/products/' . $request->image[$product_stock->id][0]->hashName()), 60);

                    $product_stock->update([
                        'image' => $request->image[$product_stock->id][0]->hashName(),
                    ]);
                }
            }



            $product_stock->update([
                'stock' => $stock[$index],
            ]);
        }


        return redirect()->route('products.index', app()->getLocale());
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
        return view('dashboard.products.edit ')->with('Product', $Product)->with('categories', $categories)->with('countries', $countries);
    }

    public function addColor($lang, $Product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        $Product = Product::find($Product);
        return view('dashboard.products.add_color')->with('Product', $Product)->with('colors', $colors)->with('sizes', $sizes);
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

                return redirect()->route('products.index', app()->getLocale());
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

        return redirect()->route('products.index', app()->getLocale());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, Product $Product)
    {



        $request->validate([

            'name_ar' => "required|string",
            'name_en' => "required|string",
            'SKU' => "required|string|unique:products,SKU," . $Product->id,
            'images' => "array",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'vendor_price' => "required|string",
            // 'min_price' => "required|string",
            // 'max_price' => "required|string",
            // 'stock' => "required|string",
            'categories' => "required|array",
            'fixed_price'  => "required|numeric",



        ]);



        if ($files = $request->file('images')) {



            foreach ($Product->images as $image) {

                Storage::disk('public')->delete('/images/products/' . $image->url);
                $image->delete();
            }



            foreach ($files as $file) {

                Image::make($file)->save(public_path('storage/images/products/' . $file->hashName()), 80);

                ProductImage::create([

                    'product_id' => $Product->id,
                    'url' => $file->hashName(),
                ]);
            }
        }


        $average = 0;
        $count = 0;


        foreach ($request['categories'] as $category) {

            $category = Category::find($category);
            $average += ceil($category->profit);
            $count++;
        }

        $average = ceil($average / $count);


        $price =  ceil($request['vendor_price'] *  ceil($average) / 100);


        $price = $price + ceil($request['fixed_price']);

        $price1 = $price;


        $price = ceil($price * setting('tax') / 100);

        $price = $price + $price1;



        $total_profit = $price;


        $price = $price + ceil($request['vendor_price']);



        $max_price = ceil($price * setting('max_price') / 100);



        $Product->update([

            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'SKU' => $request['SKU'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'vendor_price' => ceil($request['vendor_price']),
            'min_price' => ceil($price),
            'max_price' => ceil($max_price),
            // 'stock' => $request['stock'],
            'category_id' => 0,
            'country_id' => $category->country->id,
            'total_profit' => $total_profit,
            'status' => $request['status'],
            'price' => $price,
            'fixed_price' => ceil($request['fixed_price']),
            'vendor_id' => Auth::id(),

        ]);


        $Product->categories()->detach();
        $Product->categories()->attach($request['categories']);



        if ($Product->status == 'active') {




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة المنتج الخاص بك الى نشط";
            $title_en = 'Notification From Admin';
            $body_en  = "Your product status has been changed to Active";


            $notification1 = Notification::create([
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $Product->updated_at,
                'status' => 0,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }


        if ($Product->status == 'rejected') {




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة المنتج الخاص بك الى مرفوض";
            $title_en = 'Notification From Admin';
            $body_en  = "Your product status has been changed to Rejected";


            $notification1 = Notification::create([
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $Product->updated_at,
                'status' => 0,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }


        if ($request['limited'] == 'on') {

            if (Limit::where('product_id', $Product->id)->get()->count() == 0) {

                $limit = Limit::create([
                    'product_id' => $Product->id,

                ]);
            }
        } else {

            if (Limit::where('product_id', $Product->id)->get()->count() != 0) {

                $limit = Limit::where('product_id', $Product->id)->first();
                $limit->delete();
            }
        }



        session()->flash('success', 'Product updated successfully');
        return redirect()->route('products.index', app()->getLocale());
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

            if (auth()->user()->hasPermission('products-delete')) {



                foreach ($Product->images as $image) {

                    Storage::disk('public')->delete('/images/products/' . $image->url);
                    $image->delete();
                }

                $Product->forceDelete();


                session()->flash('success', 'Product Deleted successfully');
                return redirect()->route('products.trashed', app()->getLocale());
            } else {

                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('products.trashed', app()->getLocale());
            }
        } else {



            if (auth()->user()->hasPermission('products-trash')) {


                if ($Product->orders->count() > '0') {
                    session()->flash('success', 'you can not delete this product because it is related with some users orders');
                    return redirect()->route('products.index', app()->getLocale());
                }

                $Product->delete();

                session()->flash('success', 'Product trashed successfully');
                return redirect()->route('products.index', app()->getLocale());
            } else {

                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('products.index', app()->getLocale());
            }
        }
    }


    public function trashed()
    {
        $categories = Category::all();
        $countries = Country::all();
        $products = Product::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->paginate(100);
        return view('dashboard.products.index')->with('products', $products)->with('categories', $categories)->with('countries', $countries);
    }

    public function restore($lang, $Product)
    {
        $categories = Category::all();

        $Product = Product::withTrashed()->where('id', $Product)->first()->restore();

        session()->flash('success', 'Product restored successfully');
        return redirect()->route('products.index', app()->getLocale());
    }


    public function affiliateProducts($lang)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $slides1 = Slide::where('slide_id', 1)->get();
        $slides2 = Slide::where('slide_id', 2)->get();
        $slides3 = Slide::where('slide_id', 3)->get();


        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();


        $products = Product::where('country_id', $scountry->id)
            ->whereHas('stocks', function ($query) {
                $query->where('stock', '!=', '0');
            })
            ->where('status', "active")
            ->whenSearch(request()->search)
            ->latest()
            ->paginate(20);


        return view('dashboard.aff-prod.index', compact('categories', 'products', 'slides1', 'slides2', 'slides3'));
    }


    public function affiliateProduct($lang, Product $product)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.aff-prod.product', compact('categories', 'product'));
    }

    public function myStockShow($lang, Product $product)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.aff-prod.mystock_product', compact('categories', 'product'));
    }


    public function myStockOrder($lang, Request $request, Product $product)
    {

        $user = Auth::user();


        $request->validate([
            'quantity' => 'required|array',
            'payment' => 'required|string',
        ]);

        $vendor_price = $request->price;

        $count = 0;
        $check_quantity = 0;
        $quantity_count = 0;

        foreach ($request->quantity as $quantity1) {

            $quantity_count += $quantity1;
        }

        $total_price = $quantity_count * $product->min_price;



        foreach ($product->stocks as $key => $stock) {

            if ($request->quantity[$key] > $stock->stock) {
                $count = $count + 1;
            }
            if ($request->quantity[$key] <= 0) {
                $check_quantity += 1;
            }
        }



        if ($count > 0) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'تم تحديث الكميات المتاحة لهذا المنتج .. يرجى مراجعة الكميات المطلوبة ومحاولة عمل الطلب مرة أخرى');
            } else {

                session()->flash('success', 'The quantities available for this product have been updated.. Please review the required quantities and try to make the order again');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }

        if ($check_quantity == $key + 1) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'يرجى إضافة كميات الى طلبك لكي يمكنك من اتمام الطلب');
            } else {

                session()->flash('success', 'Please add quantities to your order so that you can complete the order');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }


        if ($vendor_price != $product->vendor_price) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'تم تحديث سعر هذا المنتج .. يرجى مراجعة السعر الحالي للمنتج');
            } else {

                session()->flash('success', 'The price of this product has been updated.. Please check the current price of the product');
            }


            return redirect()->route('mystock.add', ['lang' => app()->getLocale(), 'product' => $product->id]);
        }




        $order = Aorder::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'country_id' => Auth::user()->country->id,
            'total_price' => $total_price,
            'product_id' => $product->id,
            'status' => 'pending'
        ]);


        foreach ($product->stocks as $key => $stock) {

            $stock = Astock::create([
                'product_id' => $product->id,
                'color_id' => $stock->color_id,
                'aorder_id' => $order->id,
                'size_id' => $stock->size_id,
                'image' => $stock->image == NULL ? NULL : $stock->image,
                'stock' => $request->quantity[$key],
            ]);
        }

        return redirect()->route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $user->id]);
    }





    public function myStockorders($lang, $user)
    {
        $orders = Aorder::where('user_id', $user)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $user = User::find($user);

        return view('dashboard.orders.mystock_orders')->with('orders', $orders)->with('user', $user);
        // return view('dashboard.orders.mystock_orders' , compact($orders , $user));


    }


    public function stockRemove($lang, Stock $stock, Product $product)
    {

        $stock->delete();
        session()->flash('success', 'Color deleted successfully');
        return redirect()->route('products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]);
    }

    public function myStockordersAdmin($lang, Request $request)
    {


        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $orders = Aorder::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        return view('dashboard.all_orders.stock_orders')->with('orders', $orders);
    }



    public function myStockCancel($lang, Aorder $order)
    {

        if ($order->status == 'pending') {

            $order->update([
                'status' => 'canceled'
            ]);
        }

        return redirect()->back();
    }


    public function myStockProduct($lang, Product $product, Aorder $order)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', 'null')
            ->get();

        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $product->categories()->first()->id)
            ->get();


        return view('dashboard.aff-prod.sproduct', compact('categories', 'product', 'order'));
    }

    public function myStockProducts($lang)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail(Auth()->user()->country_id);

        $user = Auth::user();


        $orders = Aorder::where('user_id', $user->id)
            ->latest()
            ->paginate(100);



        return view('dashboard.aff-prod.mystock_products', compact('orders', 'user'));
    }


    public function myStockordersChange($lang, Request $request, Aorder $order)
    {



        $request->validate([

            'status' => "required|string|max:255",

        ]);

        $product = $order->product;
        $astocks = $product->astocks->where('order_id', $order->id)->values();





        if ($order->status == 'pending' && $request->status == 'confirmed') {
            $order->update([
                'status' => 'confirmed'
            ]);


            foreach ($product->stocks as $key => $stock) {
                $stock->update([
                    'stock' => $stock->stock - $astocks[$key]->stock
                ]);
            }
        }

        if ($order->status == 'pending' && $request->status == 'rejected') {
            $order->update([
                'status' => 'rejected'
            ]);
        }


        switch ($order->status) {
            case "pending":
                $status_en = "pending";
                $status_ar = "معلق";
                break;
            case "confirmed":
                $status_en = "confirmed";
                $status_ar = "مؤكد";
                break;
            case "rejected":
                $status_en = "rejected";
                $status_ar = "مرفوض";
                break;
            case "canceled":
                $status_en = "canceled";
                $status_ar = "ملغي";
                break;
            default:
                break;
        }




        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $status_en;


        $notification1 = Notification::create([
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $order->updated_at,
            'status' => 0,
            'url' =>  route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('mystock.orders', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $order->user->id, 'notification' => $notification1->id]),

        ];


        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }


        return redirect()->route('stock.orders', app()->getLocale());
    }


    public function affiliateProductsCat($lang, $category)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);
        $scategory = Category::find($category);


        $slides1 = Slide::where('slide_id', 1)->get();
        $slides2 = Slide::where('slide_id', 2)->get();
        $slides3 = Slide::where('slide_id', 3)->get();


        $cat = $scategory->id;


        $products = Product::
            // where('category_id', $scategory->id)
            whereHas('categories', function ($query) use ($cat) {
                $query->where('category_id', 'like', $cat);
            })
            ->where('status', "active")
            ->whenSearch(request()->search)
            ->paginate(20);




        $categories = Category::with('products')
            ->where('country_id', $scountry->id)
            ->where('parent', $scategory->id)
            ->get();



        return view('dashboard.aff-prod.index', compact('categories', 'products', 'scategory', 'slides1', 'slides2', 'slides3'));
    } //end of products

    public function updateStatusAll($lang, Request $request)
    {




        $request->validate([

            'status' => "required|string|max:255",
            'checkAll' => "required|array",

        ]);




        foreach ($request->checkAll as $product) {


            $Product = Product::find($product);



            $Product->update([
                'status' => $request->status,
                'vendor_id' => Auth::id(),

            ]);



            if ($Product->status == 'active') {




                $title_ar = 'اشعار من الإدارة';
                $body_ar = "تم تغيير حالة المنتج الخاص بك الى نشط";
                $title_en = 'Notification From Admin';
                $body_en  = "Your product status has been changed to Active";


                $notification1 = Notification::create([
                    'user_id' => $Product->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $Product->updated_at,
                    'status' => 0,
                    'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [
                    'notification_id' => $notification1->id,
                    'user_id' => $Product->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }


            if ($Product->status == 'rejected') {




                $title_ar = 'اشعار من الإدارة';
                $body_ar = "تم تغيير حالة المنتج الخاص بك الى مرفوض";
                $title_en = 'Notification From Admin';
                $body_en  = "Your product status has been changed to Rejected";


                $notification1 = Notification::create([
                    'user_id' => $Product->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $Product->updated_at,
                    'status' => 0,
                    'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [
                    'notification_id' => $notification1->id,
                    'user_id' => $Product->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        }



        session()->flash('success', 'Products updated successfully');
        return redirect()->route('products.index', app()->getLocale());
    }

    public function updateStatus($lang, Request $request, Product $Product)
    {



        $request->validate([

            'status' => "required|string|max:255",

        ]);





        $Product->update([
            'status' => $request->status,
            'vendor_id' => Auth::id(),

        ]);





        if ($Product->status == 'active') {




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة المنتج الخاص بك الى نشط";
            $title_en = 'Notification From Admin';
            $body_en  = "Your product status has been changed to Active";


            $notification1 = Notification::create([
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $Product->updated_at,
                'status' => 0,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }


        if ($Product->status == 'rejected') {




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة المنتج الخاص بك الى مرفوض";
            $title_en = 'Notification From Admin';
            $body_en  = "Your product status has been changed to Rejected";


            $notification1 = Notification::create([
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $Product->updated_at,
                'status' => 0,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $Product->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('vendor-products.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $Product->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }




        session()->flash('success', 'Product updated successfully');
        return redirect()->route('products.index', app()->getLocale());
    }
}
