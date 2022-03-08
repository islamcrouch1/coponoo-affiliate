<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Country;
use App\Color;


class ColorsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:colors-read')->only('index' , 'show');
        $this->middleware('permission:colors-create')->only('create' , 'store');
        $this->middleware('permission:colors-update')->only('edit' , 'update');
        $this->middleware('permission:colors-delete')->only('destroy' , 'trashed');
        $this->middleware('permission:colors-restore')->only('restore');
    }

    public function index()
    {
        $colors = Color::whenSearch(request()->search)
        ->paginate(100);

        return view('dashboard.colors.index')->with('colors' , $colors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.colors.create');
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

            'color_ar' => "required|string|max:255|unique:colors",
            'color_en' => "required|string|max:255|unique:colors",
            'hex' => "required|string|max:255|unique:colors",


            ]);




            $color = Color::create([

                'color_ar' => $request['color_ar'],
                'color_en' => $request['color_en'],
                'hex' => $request['hex'],



            ]);


            session()->flash('success' , 'color created successfully');

            return redirect()->route('colors.index' , app()->getLocale());
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
    public function edit($lang , $color)
    {
        $color = Color::find($color);
        return view('dashboard.colors.edit ')->with('color', $color);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Color $color)
    {

        $request->validate([

            'color_ar' => "required|string|max:255|unique:colors,color_ar," .$color->id,
            'color_en' => "required|string|max:255|unique:colors,color_en," .$color->id,
            'hex' => "required|string|max:255|unique:colors,hex," .$color->id,



            ]);


            $color->update([
                'color_ar' => $request['color_ar'],
                'color_en' => $request['color_en'],
                'hex' => $request['hex'],


            ]);




            session()->flash('success' , 'color updated successfully');

            return redirect()->route('colors.index' , app()->getLocale());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $color)
    {

        $color = Color::withTrashed()->where('id' , $color)->first();

        if($color->trashed()){

            if(auth()->user()->hasPermission('colors-delete')){
                $color->forceDelete();

                session()->flash('success' , 'color Deleted successfully');
                return redirect()->route('colors.trashed' , app()->getLocale());

            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('colors.trashed' , app()->getLocale());

            }



        }else{

            if(auth()->user()->hasPermission('colors-trash')){
                $color->delete();

                session()->flash('success' , 'color trashed successfully');
                return redirect()->route('colors.index' , app()->getLocale());
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');
                return redirect()->route('colors.index' , app()->getLocale());
            }

        }


    }


    public function trashed()
    {

        $colors = Color::onlyTrashed()->paginate(100);
        return view('dashboard.colors.index' , ['colors' => $colors]);

    }

    public function restore( $lang , $color)
    {

        $color = Color::withTrashed()->where('id' , $color)->first()->restore();

        session()->flash('success' , 'color restored successfully');

        return redirect()->route('colors.index' , app()->getLocale());
    }
}
