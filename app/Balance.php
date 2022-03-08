<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id', 'available_balance', 'outstanding_balance', 'pending_withdrawal_requests', 'completed_withdrawal_requests', 'bonus'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
