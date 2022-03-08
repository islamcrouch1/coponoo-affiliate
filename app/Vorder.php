<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



use App\User;
use App\Product;
use App\Order;
use App\Country;

class Vorder extends Model
{



    use SoftDeletes;


    protected $fillable = [
         'status' , 'country_id' , 'user_name'  , 'user_id' , 'order_id' , 'total_price'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot('stock_id', 'price','stock' , 'total' , 'vorder_id' )
    	->withTimestamps();
    }



    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('id' , 'like' , "%$search%")
            ->orWhere('total_price' , 'like' , "%$search%")
            ->orWhere('user_name' , 'like' , "%$search%")
            ->orWhere('client_name' , 'like' , "%$search%")
            ->orWhere('client_phone' , 'like' , "%$search%");
        });
    }


    public function scopeWhenCountry($query , $country_id)
    {
        return $query->when($country_id , function($q) use($country_id) {
            return $q->where('country_id' , 'like' , "%$country_id%");
        });
    }

    public function scopeWhenStatus($query , $status)
    {
        return $query->when($status , function($q) use($status) {
            return $q->where('Status' , 'like' , "%$status%");
        });
    }
    public function scopeWhenPaymentStatus($query , $payment_status)
    {
        return $query->when($payment_status , function($q) use($payment_status) {
            return $q->where('payment_status' , 'like' , "%$payment_status%");
        });
    }

}
