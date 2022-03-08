<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{

    protected $fillable = [
        'user_id', 'type', 'amount', 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('type', 'like', "%$search%")
                ->orWhere('user_id', 'like', "$search");
        });
    }
}
