<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'user_id' , 'sender_id' , 'message' , 'profile'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('message' , 'like' , "%$search%");
        });
    }

}
