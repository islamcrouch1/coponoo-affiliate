<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Color extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'color_ar', 'color_en',  'hex'
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
            return $q->where('color_ar', 'like', "%$search%")
                ->orWhere('color_ar', 'like', "%$search%");
        });
    }
}
