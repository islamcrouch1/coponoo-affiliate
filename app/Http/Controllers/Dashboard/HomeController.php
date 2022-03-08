<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\Vorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();


        if($user->HasRole('vendor')){

            $orders = Vorder::where('user_id' , $user->id)->get();



        }elseif($user->HasRole('affiliate')){

            $orders = Order::where('user_id' , $user->id)->get();




        }else{
            $orders = 0;
        }






        return view('dashboard.home' , compact('user' , 'orders'));
    }



}
