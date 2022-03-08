<?php

namespace App\Http\Controllers;

use App\Product;
use App\Slide;
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
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $slides = Slide::where('slide_id', 4)->get();
        return view('front.home')->with('slides', $slides);
    }



    public function contact()
    {
        return view('front.contact');
    }


    public function about()
    {
        return view('front.about');
    }


    public function terms()
    {
        return view('front.terms');
    }



    public function products()
    {
        $products = Product::where('status', 'active')
            ->latest()
            ->paginate(20);

        return view('front.products')->with('products', $products);
    }
}
