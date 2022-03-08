<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Notification extends Model
{


    protected $fillable = [
        'user_id', 'user_name', 'user_image', 'title_ar', 'body_ar' , 'date', 'url', 'title_en','body_en','status',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWhenSearch($query , $search)
    {
        return $query->when($search , function($q) use($search) {
            return $q->where('title_ar' , 'like' , "%$search%")
            ->orWhere('title_en' , 'like' , "%$search%")
            ->orWhere('body_ar' , 'like' , "%$search%")
            ->orWhere('body_en' , 'like' , "%$search%");
        });
    }


}
