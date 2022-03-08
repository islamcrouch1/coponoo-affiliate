<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{

    protected $fillable = [
        'user_id' , 'order_id' , 'reason' , 'status' , 'refuse_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }





    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('reason' , 'like' , "%$search%");
        });
    }
}
