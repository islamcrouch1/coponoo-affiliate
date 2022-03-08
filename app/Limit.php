<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $fillable = [
        'product_id'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
