<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Country;


class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $countries = Country::whenSearch(request()->search)
        ->paginate(100);

        return view('dashboard.countries.index')->with('countries' , $countries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.countries.create');
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

            'name_ar' => "required|string|max:255|unique:countries",
            'name_en' => "required|string|max:255|unique:countries",
            'code' => "required|string",
            'currency' => "required|string",
            'image' => "required|image",

            ]);


            $country = Country::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'code' => $request['code'],
                'currency' => $request['currency'],
                'image' => $request['image']->store('images/countries', 'public'),

            ]);





            session()->flash('success' , 'Country created successfully');

            return redirect()->route('countries.index' , app()->getLocale());
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
    public function edit($lang , $country)
    {
        $country = Country::find($country);
        return view('dashboard.countries.edit ')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang ,Request $request, Country $country)
    {

        $request->validate([

            'name_ar' => "required|string|max:255|unique:countries,name_ar," .$country->id,
            'name_en' => "required|string|max:255|unique:countries,name_en," .$country->id,
            'code' => "string",
            'currency' => "string",
            'image' => "image",


            ]);

            if($request->hasFile('image')){

                \Storage::disk('public')->delete($country->image);
                $country->update([
                    'image' => $request['image']->store('images/countries', 'public'),
                ]);
            }

            $country->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'code' => $request['code'],
                'currency' => $request['currency'],

            ]);




            session()->flash('success' , 'Country updated successfully');

            return redirect()->route('countries.index' , app()->getLocale());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang , $country)
    {

        $country = Country::withTrashed()->where('id' , $country)->first();

        if($country->trashed()){

            if(auth()->user()->hasPermission('countries-delete')){
                $country->forceDelete();

                session()->flash('success' , 'Country Deleted successfully');

                $countries = Country::onlyTrashed()->paginate(100);
                return view('dashboard.countries.index' , ['countries' => $countries]);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $countries = Country::onlyTrashed()->paginate(100);
                return view('dashboard.countries.index' , ['countries' => $countries]);
            }



        }else{

            if(auth()->user()->hasPermission('countries-trash')){
                $country->delete();

                session()->flash('success' , 'Country trashed successfully');

                $countries = Country::whenSearch(request()->search)
                ->paginate(100);

                return view('dashboard.countries.index')->with('countries' , $countries);
            }else{
                session()->flash('success' , 'Sorry.. you do not have permission to make this action');

                $countries = Country::whenSearch(request()->search)
                ->paginate(100);

                return view('dashboard.countries.index')->with('countries' , $countries);
            }

        }


    }


    public function trashed()
    {

        $countries = Country::onlyTrashed()->paginate(100);
        return view('dashboard.countries.index' , ['countries' => $countries]);

    }

    public function restore( $lang , $country)
    {

        $country = Country::withTrashed()->where('id' , $country)->first()->restore();

        session()->flash('success' , 'Country restored successfully');

        $countries = Country::whenSearch(request()->search)
        ->paginate(5);

        return view('dashboard.countries.index')->with('countries' , $countries);
    }
}
