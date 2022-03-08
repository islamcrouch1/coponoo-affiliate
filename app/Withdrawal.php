<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use App\User;
use App\Country;
use Illuminate\Support\Facades\Auth;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id', 'data', 'amount', 'code', 'status', 'country_id', 'user_name', 'type',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->Where('user_name', 'like', "%$search%");
        });
    }


    public function scopeWhenCountry($query, $country_id)
    {
        return $query->when($country_id, function ($q) use ($country_id) {
            return $q->where('country_id', 'like', "%$country_id%");
        });
    }

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {
            return $q->where('Status', 'like', "%$status%");
        });
    }




    public static function getWithdrawal($status, $from, $to)
    {





        if ($status == 'all') {
            $orders = DB::table('withdrawals')->select('id', 'user_name', 'data', 'amount', 'status', 'created_at')
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->get()->toArray();

            foreach ($orders as $index => $order) {


                $order1 = Withdrawal::where('id', $order->id)->first();
                $user = $order1->user;

                if ($user->HasRole('affiliate')) {
                    $orders[$index]->type = 'Affiliate';
                } else {
                    $orders[$index]->type = 'Vendor';
                }
            }
        } else {
            $orders = DB::table('withdrawals')->select('id', 'user_name', 'data', 'amount', 'status', 'created_at')->get()->toArray();

            foreach ($orders as $index => $order) {
                $order1 = Withdrawal::where('id', $order->id)->first();
                $user = $order1->user;

                if ($user->HasRole('affiliate')) {
                    $orders[$index]->type = 'Affiliate';
                } else {
                    $orders[$index]->type = 'Vendor';
                }
            }

            foreach ($orders as $index => $order) {

                if ($orders[$index]->status != $status) {

                    unset($orders[$index]);
                }
            }
        }


        $description_ar =  'تم تنزيل شيت طلبات سحب الرصيد  ';
        $description_en  = ' Withdrawals file has been downloaded ';

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'exports',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);

        return $orders;
    }
}
