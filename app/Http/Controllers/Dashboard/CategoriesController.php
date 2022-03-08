<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Country;

use Intervention\Image\ImageManagerStatic as Image;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:categories-read')->only('index', 'show');
        $this->middleware('permission:categories-create')->only('create', 'store');
        $this->middleware('permission:categories-update')->only('edit', 'update');
        $this->middleware('permission:categories-delete')->only('destroy', 'trashed');
        $this->middleware('permission:categories-restore')->only('restore');
    }


    public function index()
    {



        if (!request()->has('parent')) {

            request()->merge(['parent' => 'null']);
        }




        $categories = Category::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenParent(request()->parent)
            ->latest()
            ->paginate(100);



        $countries = Country::all();


        return view('dashboard.categories.index')->with('categories', $categories)->with('countries', $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $categories = Category::all();
        return view('dashboard.categories.create')->with('countries', $countries)->with('categories', $categories)->with('parent_cat', request()->parent);
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

            'name_ar' => "required|string|max:255|unique:categories",
            'name_en' => "required|string|max:255|unique:categories",
            'image' => "required|image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'country' => "required",
            'parent' => "required|string",
            'profit' => "required|numeric",



        ]);




        Image::make($request['image'])->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('storage/images/categories/' . $request['image']->hashName()), 60);

        $Category = Category::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'image' => $request['image']->hashName(),
            'country_id' => $request['country'],
            'parent' => $request['parent'],
            'profit' => $request['profit'],



        ]);



        session()->flash('success', 'Category created successfully');


        return redirect()->route('categories.index', ['parent' => $request->parent,  'lang' => app()->getLocale()]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $Category)
    {

        $countries = Country::all();
        $Category = Category::find($Category);
        $categories = Category::all();
        return view('dashboard.categories.edit ')->with('category', $Category)->with('countries', $countries)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, Category $Category)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:categories,name_ar," . $Category->id,
            'name_en' => "required|string|max:255|unique:categories,name_en," . $Category->id,
            'image' => "image",
            'description_ar' => "required|string",
            'description_en' => "required|string",
            'country' => "required",
            'parent' => "required|string",
            'profit' => "required|numeric",




        ]);

        if ($request->hasFile('image')) {

            Storage::disk('public')->delete('/images/categories/' . $Category->image);


            Image::make($request['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/categories/' . $request['image']->hashName()), 60);

            $Category->update([
                'image' => $request['image']->hashName(),
            ]);
        }





        foreach ($Category->products as $product) {


            $price =  ceil($product->vendor_price *  $request['profit'] / 100);


            $price = $price + ceil($product->fixed_price);

            $price1 = $price;


            $price = ceil($price * setting('tax') / 100);

            $price = $price + $price1;



            $total_profit = $price;


            $price = $price + ceil($product->vendor_price);



            $max_price = ceil($price * setting('max_price') / 100);



            $product->update([
                'min_price' => $price,
                'max_price' => $max_price,
                'total_profit' => $total_profit,
                'price' => $price,

            ]);
        }



        $Category->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'description_ar' => $request['description_ar'],
            'description_en' => $request['description_en'],
            'country_id' => $request['country'],
            'parent' => $request['parent'],
            'profit' => $request['profit'],



        ]);







        session()->flash('success', 'Category updated successfully');

        return redirect()->route('categories.index', ['parent' => $request->parent,  'lang' => app()->getLocale()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $Category, Request $request)
    {

        $Category = Category::withTrashed()->where('id', $Category)->first();

        if ($Category->trashed()) {

            if (auth()->user()->hasPermission('categories-delete')) {


                Storage::disk('public')->delete('/images/categories/' . $Category->image);
                $Category->forceDelete();


                session()->flash('success', 'Category Deleted successfully');
                $countries = Country::all();
                $categories = Category::onlyTrashed()
                    ->whenSearch(request()->search)
                    ->whenCountry(request()->country_id)
                    ->whenParent(request()->parent)
                    ->latest()
                    ->paginate(100);
                return view('dashboard.categories.index', ['categories' => $categories])->with('countries', $countries);
            } else {

                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $categories = Category::onlyTrashed()
                    ->whenSearch(request()->search)
                    ->whenCountry(request()->country_id)
                    ->whenParent(request()->parent)
                    ->latest()
                    ->paginate(100);
                return view('dashboard.categories.index', ['categories' => $categories])->with('countries', $countries);
            }
        } else {

            if (auth()->user()->hasPermission('categories-trash')) {

                $Category->delete();
                session()->flash('success', 'Category trashed successfully');
                return redirect()->route('categories.index', ['parent' => $request->parent,  'lang' => app()->getLocale()]);
            } else {

                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('categories.index', ['parent' => $request->parent,  'lang' => app()->getLocale()]);
            }
        }
    }


    public function trashed()
    {

        $countries = Country::all();
        $categories = Category::onlyTrashed()
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenParent(request()->parent)
            ->latest()
            ->paginate(100);
        return view('dashboard.categories.index', ['categories' => $categories])->with('countries', $countries);
    }

    public function restore($lang, $Category, Request $request)
    {

        $Category = Category::withTrashed()->where('id', $Category)->first()->restore();
        session()->flash('success', 'Category restored successfully');
        return redirect()->route('categories.index', ['parent' => $request->parent,  'lang' => app()->getLocale()]);
    }
}
