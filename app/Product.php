<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Category;
use App\Order;
use App\Cart;
use App\User;
use App\Stock;
use App\Vorder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name_en', 'name_ar', 'description_ar', 'description_en', 'vendor_price', 'min_price', 'max_price',  'category_id', 'country_id', 'user_id', 'status', 'vendor_id', 'price', 'fixed_price', 'total_profit', 'SKU'
    ];

    protected $appends = ['profit_percent'];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function astocks()
    {
        return $this->hasMany(Astock::class);
    }

    public function fav()
    {
        return $this->hasMany(Fav::class);
    }

    public function limits()
    {
        return $this->hasMany(Limit::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function carts()
    {
        return $this->belongsToMany(Cart::class)
            ->withPivot('stock_id', 'price', 'stock', 'vendor_price', 'product_type')
            ->withTimestamps();
    }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }




    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('category_id');
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


    public function aorder()
    {
        return $this->belongsTo(Aorder::class);
    }


    public function vorders()
    {
        return $this->belongsToMany(Vorder::class)
            ->withPivot('stock_id', 'price', 'stock', 'total', 'vorder_id')
            ->withTimestamps();
    }


    public static function getProducts($status, $category)
    {


        if (Auth::user()->HasRole('vendor')) {

            $products = DB::table('products')->select('id', 'SKU', 'user_id', 'status', 'category_id', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'fixed_price')->where('user_id', Auth::user()->id)->get()->toArray();
        } else {
            $products = DB::table('products')->where('status', $status == null ? '!=' : '=', $status)
                ->join('category_product', function ($q) {
                    $q->on('category_product.product_id', '=', 'products.id');
                })->where('category_product.category_id', $category == null ? '!=' : '=', $category)
                ->select('products.id', 'SKU', 'user_id', 'status', 'products.category_id', 'country_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'vendor_price', 'fixed_price')->get()->toArray();
        }







        foreach ($products as $index => $product) {



            $color_str = '';
            $size_str = '';
            $stock_str = '';
            $image_str = '';

            $stocks = Stock::where('product_id', $product->id)->get();

            $stocks1 = $stocks->unique('color_id');
            $stocks2 = $stocks->unique('size_id');


            foreach ($stocks1 as $stock) {
                $color_str .= $stock->color_id . ',';
            }

            foreach ($stocks2 as $stock) {
                $size_str .= $stock->size_id . ',';
            }



            foreach ($stocks as $stock) {

                $stock_str .= $stock->stock . ',';
            }

            $color_str =   substr($color_str, 0, -1);
            $size_str =   substr($size_str, 0, -1);
            $stock_str =  substr($stock_str, 0, -1);




            $products[$index]->colors = $color_str;
            $products[$index]->sizes = $size_str;
            $products[$index]->stock = $stock_str;


            $images = ProductImage::where('product_id', $product->id)->get();


            foreach ($images as $image) {

                $image_str .= 'https://coponoo.com/storage/images/products/' . $image->url . ',';
            }

            $image_str =  substr($image_str, 0, -1);


            $products[$index]->images = $image_str;
        }


        $description_ar =  'تم تنزيل شيت المنتجات  ';
        $description_en  = ' Product file has been downloaded ';

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'exports',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);





        return $products;
    }




    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('name_ar', 'like', "%$search%")
                ->orWhere('name_en', 'like', "%$search%")
                ->orWhere('description_ar', 'like', "%$search%")
                ->orWhere('description_en', 'like', "%$search%")
                ->orWhere('SKU', 'like', "%$search%");
        });
    }

    // public function getProfitPercentAttribute(){
    //     $profit = $this->sale_price - $this->purchase_price ;
    //     $profit_percent = $profit * 100 / $this->purchase_price ;
    //     return number_format($profit_percent , 2) ;
    // }




    public function scopeWhenCategory($query, $category_id)
    {
        return $query->when($category_id, function ($q) use ($category_id) {
            return $q->where('category_id', 'like', "$category_id");
        });
    }


    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "$country_id");
        });
    }
}
