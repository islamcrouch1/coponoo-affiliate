<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\User;
use App\Country;


class Address extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id', 'province', 'city','country_id','phone','district','street','building','notes',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('phone' , 'like' , "%$search%")
            ->orWhere('city' , 'like' , "%$search%");
        });
    }

}
