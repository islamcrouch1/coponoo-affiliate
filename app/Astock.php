<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Astock extends Model
{
    protected $fillable = [
        'color_id', 'size_id', 'product_id', 'stock', 'image', 'order_id'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('stock', 'like', "%$search%")
                ->orWhere('color_id', 'like', "%$search%")
                ->orWhere('size_id', 'like', "%$search%")
                ->orWhere('product', 'like', "%$search%");
        });
    }
}
