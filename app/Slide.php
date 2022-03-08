<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Slide extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'slide_id', 'url', 'image',
    ];

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('slide_id', 'like', "%$search%")
                ->orWhere('url', 'like', "%$search%");
        });
    }
}
