<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onotes extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
