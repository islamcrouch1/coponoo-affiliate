<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Onotes;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class OnotesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:onotes-read')->only('index', 'show');
        $this->middleware('permission:onotes-create')->only('create', 'store');
        $this->middleware('permission:onotes-update')->only('edit', 'update');
        $this->middleware('permission:onotes-delete')->only('destroy', 'trashed');
        $this->middleware('permission:onotes-restore')->only('restore');
    }


    public function add($lang, User $user, Order $order, Request $request)
    {
        $request->validate([

            'note' => "required|string",

        ]);



        $note = Onotes::create([

            'note' => $request['note'],
            'user_id' => $user->id,
            'order_id' => $order->id,

        ]);


        session()->flash('success', 'note created successfully');

        return redirect()->back();
    }
}
