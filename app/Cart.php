<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('stock_id', 'price', 'stock', 'vendor_price', 'product_type')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
