<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Size;


class SizesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:sizes-read')->only('index' , 'show');
        $this->middleware('permission:sizes-create')->only('create' , 'store');
        $this->middleware('permission:sizes-update')->only('edit' , 'update');
        $this->middleware('permission:sizes-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:sizes-restore')->only('restore');
    }

    public function index()
    {
        $sizes = Size::whenSearch(request()->search)
        ->paginate(100);

        return view('dashboard.sizes.index')->with('sizes' , $sizes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sizes.create');
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

            'size_ar' => "required|string|max:255|unique:sizes",
            'size_en' => "required|string|max:255|unique:sizes",


            ]);




            $size = Size::create([

                'size_ar' => $request['size_ar'],
                'size_en' => $request['size_en'],



            ]);


            session()->flash('success' , 'size created successfully');

            return redirect()->route('sizes.index' , app()->getLocale());
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
    public function edit($lang , $size)
    {
        $size = size::find($size);
        return view('dashboard.sizes.edit ')->with('size', $size);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, size $size)
    {

        $request->validate([

            'size_ar' => "required|string|max:255|unique:sizes,size_ar," .$size->id,
            'size_en' => "required|string|max:255|unique:sizes,size_en," .$size->id,


            ]);


            $size->update([
                'size_ar' => $request['size_ar'],
                'size_en' => $request['size_en'],


            ]);




            session()->flash('success' , 'size updated successfully');

            return redirect()->route('sizes.index' , app()->getLocale());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $size)
    {

        $size = Size::withTrashed()->where('id' , $size)->first();

        if($size->trashed()){

            if(auth()->user()->hasPermission('sizes-delete')){
                $size->forceDelete();

                session()->flash('success' , 'size Deleted successfully');
                return redirect()->route('sizes.trashed' , app()->getLocale());

            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('sizes.trashed' , app()->getLocale());

            }



        }else{

            if(auth()->user()->hasPermission('sizes-trash')){
                $size->delete();

                session()->flash('success' , 'size trashed successfully');
                return redirect()->route('sizes.index' , app()->getLocale());
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('sizes.index' , app()->getLocale());
            }

        }


    }


    public function trashed()
    {

        $sizes = Size::onlyTrashed()->paginate(100);
        return view('dashboard.sizes.index' , ['sizes' => $sizes]);

    }

    public function restore( $lang , $size)
    {

        $size = size::withTrashed()->where('id' , $size)->first()->restore();

        session()->flash('success' , 'size restored successfully');

        return redirect()->route('sizes.index' , app()->getLocale());
    }
}
