<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Address;
use App\User;

class AddressesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:addresses-read')->only('index', 'show');
        $this->middleware('permission:addresses-create')->only('create', 'store');
        $this->middleware('permission:addresses-update')->only('edit', 'update');
        $this->middleware('permission:addresses-delete')->only('destroy', 'trashed');
        $this->middleware('permission:addresses-restore')->only('restore');
    }


    public function index(Request $request)
    {

        $user = User::find($request->user);

        $addresses = Address::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::find($request->user);


        return view('dashboard.addresses.create')->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $user = User::find($request->user);


        $request->validate([

            'province' => "required|string",
            'city' => "required|string",
            'district' => "required|string",
            'street' => "required|string",
            'building' => "required|string",
            'phone' => "required|string",
            'notes' => "required|string",



        ]);


        $address = address::create([
            'province' => $request['province'],
            'city' => $request['city'],
            'district' => $request['district'],
            'building' => $request['building'],
            'street' => $request['street'],
            'phone' => $request['phone'],
            'notes' => $request['notes'],
            'user_id' => $user->id,
            'country_id' => $user->country->id,


        ]);


        session()->flash('success', 'address created successfully');


        $addresses = address::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
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
    public function edit($lang, $address, Request $request)
    {
        $user = User::find($request->user);
        $address = address::find($address);
        return view('dashboard.addresses.edit ')->with('address', $address)->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, address $address)
    {

        $user = User::find($request->user);


        $request->validate([

            'province' => "required|string",
            'city' => "required|string",
            'district' => "required|string",
            'street' => "required|string",
            'building' => "required|string",
            'phone' => "required|string",
            'notes' => "required|string",

        ]);



        $address->update([
            'province' => $request['province'],
            'city' => $request['city'],
            'district' => $request['district'],
            'building' => $request['building'],
            'street' => $request['street'],
            'phone' => $request['phone'],
            'notes' => $request['notes'],
            'user_id' => $user->id,
            'country_id' => $user->country->id,

        ]);







        session()->flash('success', 'address updated successfully');



        $addresses = address::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $address, Request $request)
    {


        $user = User::find($request->user);

        $address = address::withTrashed()->where('id', $address)->first();

        if ($address->trashed()) {

            if (auth()->user()->hasPermission('addresses-delete')) {
                $address->forceDelete();

                session()->flash('success', 'address Deleted successfully');

                $addresses = address::onlyTrashed()
                    ->where('user_id', $user->id)
                    ->whenSearch(request()->search)
                    ->paginate(100);
                return view('dashboard.addresses.index', ['addresses' => $addresses])->with('user', $user);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $addresses = address::onlyTrashed()
                    ->where('user_id', $user->id)
                    ->whenSearch(request()->search)
                    ->paginate(100);
                return view('dashboard.addresses.index', ['addresses' => $addresses])->with('user', $user);
            }
        } else {

            if (auth()->user()->hasPermission('addresses-trash')) {
                $address->delete();

                session()->flash('success', 'address trashed successfully');

                $addresses = address::where('user_id', $user->id)
                    ->whenSearch(request()->search)
                    ->paginate(100);

                return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $addresses = address::where('user_id', $user->id)
                    ->whenSearch(request()->search)
                    ->paginate(100);

                return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
            }
        }
    }


    public function trashed(Request $request)
    {

        $user = User::find($request->user);


        $addresses = address::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);

        $addresses = address::onlyTrashed()
            ->where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.addresses.index', ['addresses' => $addresses])->with('user', $user);
    }

    public function restore($lang, $address, Request $request)
    {

        $user = User::find($request->user);
        $address = address::withTrashed()->where('id', $address)->first()->restore();

        session()->flash('success', 'address restored successfully');


        $addresses = address::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.addresses.index')->with('addresses', $addresses)->with('user', $user);
    }
}
