<?php

namespace App;

use Facade\FlareClient\Http\Client as HttpClient;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Twilio\Rest\Client;
use Throwable;
use Twilio\Exceptions\TwilioException;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country_id', 'phone', 'gender', 'profile', 'type', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',

    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function admin_nitifications()
    {
        return $this->hasMany(AdminNotification::class);
    }

    public function aorders()
    {
        return $this->hasMany(Aorder::class);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }


    public function vorders()
    {
        return $this->hasMany(Vorder::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function onotes()
    {
        return $this->hasMany(Onotes::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }


    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }


    public function prefunds()
    {
        return $this->hasMany(Prefund::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }


    public function fav()
    {
        return $this->hasMany(Fav::class);
    }

    public static function getUsers()
    {

        $users = DB::table('users')->select('id', 'created_at', 'name', 'phone', 'email', 'status', 'gender')->get()->toArray();


        foreach ($users as $index => $phone) {

            $phone1 = str_replace('+2', '', $phone->phone);
            $users[$index]->phone = $phone1;

            $user1 = User::find($users[$index]->id);

            if ($user1->hasRole('affiliate')) {

                $users[$index]->type = 'affiliate';
            } elseif ($user1->hasRole('vendor')) {

                $users[$index]->type = 'vendor';
            } else {
                $users[$index]->type = 'admin';
            }
        }

        $description_ar =  'تم تنزيل شيت المستخدمين  ';
        $description_en  = ' Users file has been downloaded ';

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'exports',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);



        return $users;
    }


    public function balance()
    {
        return $this->hasOne(Balance::class);
    }





    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            return $q->where('phone', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('id', 'like', "$search");
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
            return $q->where('status', 'like', $status);
        });
    }

    public function scopeWhenRole($query, $role_id)
    {
        return $query->when($role_id, function ($q) use ($role_id) {
            return $this->scopeWhereRole($q, $role_id);
        });
    }


    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {
            return $q->where('type', 'like', "%$type%");
        });
    }

    public function scopeWhereRole($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereIn('name', (array)$role_name)
                ->orWhereIn('id', (array)$role_name);
        });
    }

    public function scopeWhereRoleNot($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereNotIn('name', (array)$role_name)
                ->WhereNotIn('id', (array)$role_name);
        });
    }


    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
            'status' => 'active',
        ])->save();
    }



    public function markUserBlocked()
    {
        return $this->forceFill([
            'status' => 'blocked',
        ])->save();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }




    public function callToVerify()
    {
        $code = random_int(100000, 999999);

        $this->forceFill([
            'verification_code' => $code
        ])->save();

        try {
            $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $client->messages->create(
                $this->phone, // to
                ["body" => "Your Coponoo Verification Code Is : {$code}", "from" => "Coponoo"]
            );
        } catch (TwilioException $e) {
            echo $e->getCode() . ' : ' . $e->getMessage() . "<br>";
        }
    }


    public function callToVerifyAdmin()
    {
        $code = random_int(100000, 999999);

        $this->forceFill([
            'verification_code' => $code
        ])->save();
    }

    // create(
    //     $this->phone,
    //     "+15306658566", // REPLACE WITH YOUR TWILIO NUMBER
    //     ["url" => "http://your-ngrok-url>/build-twiml/{$code}"]
    // );
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
