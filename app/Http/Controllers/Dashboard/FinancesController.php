<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Vorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:finances-read')->only('index', 'show');
        $this->middleware('permission:finances-create')->only('create', 'store');
        $this->middleware('permission:finances-update')->only('edit', 'update');
        $this->middleware('permission:finances-delete')->only('destroy', 'trashed');
        $this->middleware('permission:finances-restore')->only('restore');
    }


    public function index(Request $request)
    {


        // if(!$request->has('from') || !$request->has('to') ){

        //     $request->merge(['from' => Carbon::now()->subDay(365)]);
        //     $request->merge(['to' => Carbon::now()]);

        // }


        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }





        $orders_pending = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'pending')->get();
        $orders_confirmed = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'confirmed')->get();
        $orders_onway = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'on the way')->get();
        $orders_mandatory = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'in the mandatory period')->get();
        $orders_delivered = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'delivered')->get();
        $orders_canceled = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'canceled')->get();
        $orders_returned = Order::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)->where('status', 'returned')->get();

        $users = User::all();



        return view('dashboard.finances.index', compact('orders_pending', 'orders_confirmed', 'users', 'orders_onway', 'orders_mandatory', 'orders_delivered',  'orders_canceled', 'orders_returned'));
    }
}
