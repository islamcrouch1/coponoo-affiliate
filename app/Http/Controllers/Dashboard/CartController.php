<?php

namespace App\Http\Controllers\Dashboard;

use App\Astock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Country;
use App\Category;
use App\Product;
use App\Cart;
use App\ShippingRate;
use App\Stock;
use App\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index($lang, $user)
    {

        $user = User::find($user);
        $rates = ShippingRate::where('country_id', $user->country->id)->get();
        $scountry = Country::findOrFail(Auth()->user()->country_id);


        foreach ($user->cart->products as $product1) {


            // review this condition  // if (($product1->pivot->price - $product1->min_price) * $product1->pivot->stock < 0)


            if ($product1->pivot->vendor_price != $product1->vendor_price || $product1->stocks->find($product1->pivot->stock_id) == NULL) {


                $user->cart->products()->wherePivot('stock_id', $product1->pivot->stock_id)->detach();


                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'تم تحديث بعض أسعار المنتجات الموجودة بسلة مشترياتك يرجى مراجعة الطلب مرة أخرى');
                } else {

                    session()->flash('success', 'Some prices of the products in your cart have been updated, please check the order again');
                }


                return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
            }
        }

        return view('dashboard.cart.index', compact('user', 'rates'));
    }


    public function add(Request $request)
    {




        $product = Product::find($request->product_id);

        $stock = $request->stock_id;

        $product_type = $request->product_type;

        if ($product_type == '0') {
            $av_stock = Stock::find($stock);
            $stock = $av_stock->stock;
        } else {
            $av_stock = Astock::find($stock);
            $stock = $av_stock->stock;
        }

        $max = $product->max_price;
        $min = $product->min_price;


        if ($request->stock > $stock) {
            return 2;
        }


        if ($request->price < $min || $request->price > $max) {
            return 3;
        }

        if ($request->vendor_price != $product->vendor_price) {
            return 4;
        }


        $cart = Auth()->user()->cart;

        if ($cart->products()->where('stock_id', $request->stock_id)->count() > 0) {
            return 0;
        }

        $price1 = ceil($request->price);

        $cart->products()->attach($product->id, ['stock_id' => $request->stock_id, 'stock' => $request->stock, 'price' => $price1, 'vendor_price' => $product->vendor_price, 'product_type' => $product_type]);


        return 1;
    } //end of products


    public function remove($lang, $user, $product, $stock)
    {

        $scountry = Country::findOrFail(Auth()->user()->country_id);
        $product = Product::find($product);
        $user = User::find($user);

        $cart = $user->cart;

        $cart->products()->wherePivot('stock_id', $stock)->detach();



        return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
    } //end of products
}
