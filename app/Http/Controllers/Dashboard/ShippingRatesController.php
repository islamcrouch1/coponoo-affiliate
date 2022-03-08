<?php

namespace App\Http\Controllers\Dashboard;

use App\Country;
use App\Http\Controllers\Controller;
use App\ShippingRate;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class ShippingRatesController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator|affiliate');

        $this->middleware('permission:shipping_rates-read')->only('index', 'show');
        $this->middleware('permission:shipping_rates-create')->only('create', 'store');
        $this->middleware('permission:shipping_rates-update')->only('edit', 'update');
        $this->middleware('permission:shipping_rates-delete')->only('destroy', 'trashed');
        $this->middleware('permission:shipping_rates-restore')->only('restore');
    }

    public function index()
    {
        $shipping_rates = ShippingRate::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);

        return view('dashboard.shipping_rates.index')->with('shipping_rates', $shipping_rates);
    }


    public function affiliate()
    {
        $shipping_rates = ShippingRate::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->paginate(100);

        return view('dashboard.shipping_rates.affiliate')->with('shipping_rates', $shipping_rates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('dashboard.shipping_rates.create')->with('countries', $countries);
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

            'city_ar' => "required|string|max:255|unique:shipping_rates",
            'city_en' => "required|string|max:255|unique:shipping_rates",
            'cost' => "required|string",
            'country' => "required|string",

        ]);




        $shipping_rate = ShippingRate::create([

            'city_ar' => $request['city_ar'],
            'city_en' => $request['city_en'],
            'cost' => $request['cost'],
            'country_id' => $request['country'],


        ]);


        session()->flash('success', 'shipping_rate created successfully');

        return redirect()->route('shipping_rates.index', app()->getLocale());
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
    public function edit($lang, $shipping_rate)
    {
        $countries = Country::all();
        $shipping_rate = ShippingRate::find($shipping_rate);
        return view('dashboard.shipping_rates.edit ')->with('shipping_rate', $shipping_rate)->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, ShippingRate $shipping_rate)
    {

        $request->validate([

            'city_ar' => "required|string|max:255|unique:shipping_rates,city_ar," . $shipping_rate->id,
            'city_en' => "required|string|max:255|unique:shipping_rates,city_en," . $shipping_rate->id,
            'cost' => "required|string",
            'country' => "required|string",

        ]);


        $shipping_rate->update([
            'city_ar' => $request['city_ar'],
            'city_en' => $request['city_en'],
            'cost' => $request['cost'],
            'country_id' => $request['country'],

        ]);




        session()->flash('success', 'shipping_rate updated successfully');

        return redirect()->route('shipping_rates.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $shipping_rate)
    {

        $shipping_rate = ShippingRate::withTrashed()->where('id', $shipping_rate)->first();

        if ($shipping_rate->trashed()) {

            if (auth()->user()->hasPermission('shipping_rates-delete')) {
                $shipping_rate->forceDelete();

                session()->flash('success', 'shipping_rate Deleted successfully');
                return redirect()->route('shipping_rates.trashed', app()->getLocale());
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('shipping_rates.trashed', app()->getLocale());
            }
        } else {

            if (auth()->user()->hasPermission('shipping_rates-trash')) {
                $shipping_rate->delete();

                session()->flash('success', 'shipping_rate trashed successfully');
                return redirect()->route('shipping_rates.index', app()->getLocale());
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('shipping_rates.index', app()->getLocale());
            }
        }
    }


    public function trashed()
    {

        $shipping_rates = ShippingRate::onlyTrashed()->paginate(100);
        return view('dashboard.shipping_rates.index', ['shipping_rates' => $shipping_rates]);
    }

    public function restore($lang, $shipping_rate)
    {

        $shipping_rate = ShippingRate::withTrashed()->where('id', $shipping_rate)->first()->restore();

        session()->flash('success', 'shipping_rate restored successfully');

        return redirect()->route('shipping_rates.index', app()->getLocale());
    }
}
