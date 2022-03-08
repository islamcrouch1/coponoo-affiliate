<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Country;
use App\Category;
use App\Product;
use App\Cart;
use App\Fav;
use App\ShippingRate;
use App\Stock;
use App\User;
use Illuminate\Support\Facades\Auth;


class FavController extends Controller
{
    public function index($lang, $user)
    {

        $user = User::find($user);
        $scountry = Country::findOrFail(Auth()->user()->country_id);
        $favs = Fav::where('user_id', $user->id)->paginate(20);
        return view('dashboard.fav.index', compact('user', 'favs'));
    }


    public function add($lang, $user, $product)
    {

        $user = User::find($user);
        $product = Product::find($product);

        if (Fav::where('product_id', $product->id)->where('user_id', $user->id)->get()->count() == 0) {

            $fav = Fav::create([
                'user_id' => $user->id,
                'product_id' => $product->id,

            ]);

            return 1;
        } else {
            $fav = Fav::where('product_id', $product->id)->where('user_id', $user->id)->first();
            $fav->delete();

            return 2;
        }
    } //end of products

}
