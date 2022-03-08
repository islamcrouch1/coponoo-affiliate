<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Size extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'size_ar', 'size_en'
    ];


    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function astocks()
    {
        return $this->hasMany(Astock::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('size_ar', 'like', "%$search%")
                ->orWhere('size_en', 'like', "%$search%");
        });
    }
}
