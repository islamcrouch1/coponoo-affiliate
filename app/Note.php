<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id' , 'admin_id' , 'note' , 'profile'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}


