<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefund extends Model
{


    protected $fillable = [
        'user_id' , 'order_id' , 'reason' , 'status' , 'refuse_reason' , 'product_id' , 'stock_id' , 'quantity' , 'orderid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }




}
