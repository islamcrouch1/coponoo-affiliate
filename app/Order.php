<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\User;
use App\Product;
use App\Address;
use App\Country;
use App\Vorder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{

    use SoftDeletes;


    protected $fillable = [
        'total_price', 'address', 'status', 'country_id', 'user_name', 'wallet_balance', 'shipping_rate_id', 'total_commission', 'total_profit', 'notes', 'client_phone', 'client_name', 'special_mark', 'house', 'phone2', 'shipping'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class);
    }


    public function prefunds()
    {
        return $this->hasMany(Prefund::class);
    }


    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function onotes()
    {
        return $this->hasMany(Onotes::class);
    }



    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('stock_id', 'price', 'stock', 'total', 'commission', 'commission_for_item', 'profit_for_item', 'product_type')
            ->withTimestamps();
    }

    public function shipping_rate()
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function vorders()
    {
        return $this->hasMany(Vorder::class);
    }

    public static function getOrders($status, $from, $to)
    {



        if ($status == 'all') {

            $orders = DB::table('order_product')->select('id', 'order_id', 'created_at', 'updated_at', 'product_id', 'vendor_price', 'price', 'commission_for_item', 'profit_for_item', 'total', 'stock', 'stock_id', 'product_type')
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();

            foreach ($orders as $index => $order) {
                $order1 = Product::where('id', $order->product_id)->first();
                $orders[$index]->product_name_ar = $order1->name_ar;
                $orders[$index]->product_name_en = $order1->name_en;

                // dd($order1->orders->where('id' , $order->id)->first()->status);

                $orders[$index]->affiliate_id = $order1->orders->where('id', $order->order_id)->first()->user_id;
                $orders[$index]->status = $order1->orders->where('id', $order->order_id)->first()->status;
                $orders[$index]->customer_name = $order1->orders->where('id', $order->order_id)->first()->client_name;
                $orders[$index]->customer_phone = $order1->orders->where('id', $order->order_id)->first()->client_phone;
                $orders[$index]->customer_phone2 = $order1->orders->where('id', $order->order_id)->first()->phone2;
                $orders[$index]->address = $order1->orders->where('id', $order->order_id)->first()->address;
                $orders[$index]->house = $order1->orders->where('id', $order->order_id)->first()->house;
                $orders[$index]->special_mark = $order1->orders->where('id', $order->order_id)->first()->special_mark;
                $orders[$index]->notes = $order1->orders->where('id', $order->order_id)->first()->notes;



                $stock = Stock::where('id', $order->stock_id)->first();

                $orders[$index]->color = $stock->color->color_en;
                $orders[$index]->size = $stock->size->size_en;
                $orders[$index]->SKU = $order1->SKU;
                $orders[$index]->vendor_id = $order1->user_id;


                if ($order->product_type == '0') {
                    $orders[$index]->product_type = 'Sonoo stock';
                } else {
                    $orders[$index]->product_type = 'affiliate stock';
                }



                $order2 = Order::find($order->order_id);
                $total = intval($order2->shipping_rate->cost) + $order->total;
                $orders[$index]->total = $total;
            }
        } else {
            $orders = DB::table('order_product')->select('id', 'order_id', 'created_at', 'updated_at', 'product_id', 'vendor_price', 'price', 'commission_for_item', 'profit_for_item', 'total', 'stock', 'stock_id', 'product_type')->get()->toArray();

            foreach ($orders as $index => $order) {
                $order1 = Product::where('id', $order->product_id)->first();
                $orders[$index]->product_name_ar = $order1->name_ar;
                $orders[$index]->product_name_en = $order1->name_en;

                // dd($order1->orders->where('id' , $order->id)->first()->status);

                $orders[$index]->affiliate_id = $order1->orders->where('id', $order->order_id)->first()->user_id;
                $orders[$index]->status = $order1->orders->where('id', $order->order_id)->first()->status;
                $orders[$index]->customer_name = $order1->orders->where('id', $order->order_id)->first()->client_name;
                $orders[$index]->customer_phone = $order1->orders->where('id', $order->order_id)->first()->client_phone;


                $stock = Stock::where('id', $order->stock_id)->first();

                $orders[$index]->color = $stock->color->color_en;
                $orders[$index]->size = $stock->size->size_en;
                $orders[$index]->SKU = $order1->SKU;
                $orders[$index]->vendor_id = $order1->user_id;


                if ($order->product_type == '0') {
                    $orders[$index]->product_type = 'Sonoo stock';
                } else {
                    $orders[$index]->product_type = 'affiliate stock';
                }


                $order2 = Order::find($order->order_id);
                $total = intval($order2->shipping) + $order->total;
                $orders[$index]->total = $total;
            }

            foreach ($orders as $index => $order) {

                if ($orders[$index]->status != $status) {

                    unset($orders[$index]);
                }
            }
        }




        $description_ar =  'تم تنزيل شيت الطلبات  ';
        $description_en  = ' Orders file has been downloaded ';

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'exports',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);




        return $orders;
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('id', 'like', "%$search%")
                ->orWhere('total_price', 'like', "%$search%")
                ->orWhere('user_name', 'like', "%$search%")
                ->orWhere('client_name', 'like', "%$search%")
                ->orWhere('client_phone', 'like', "%$search%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }
    public function scopeWhenPaymentStatus($query, $payment_status)
    {
        return $query->when($payment_status, function ($q) use ($payment_status) {
            return $q->where('payment_status', 'like', "%$payment_status%");
        });
    }
}
