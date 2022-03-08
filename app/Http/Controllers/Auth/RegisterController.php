<?php

namespace App\Http\Controllers\Auth;

use App\Balance;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // public function redirectTo(){
    //      return route('home');
    // }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {



        if (isset($data['phone'])) {

            $data['phone'] = str_replace(' ', '', $data['phone']);

            if ($data['phone'][0] == '0') {
                $data['phone'][0] = ' ';

                $data['phone'] = str_replace(' ', '', $data['phone']);
            }

            $data['phone'] = $data['phone_hide'] . $data['phone'];
        }





        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required'],
            'phone' => ['required', 'string', 'unique:users'],
            'gender' => ['required'],
            'profile' => ['image'],
            'check' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        if (!array_key_exists('profile', $data)) {
            if ($data['gender'] == 'male') {
                $data['profile'] = 'avatarmale.png';
            } else {
                $data['profile'] = 'avatarfemale.png';
            }
        } else {


            Image::make($data['profile'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/users/' . $data['profile']->hashName()), 60);
        }



        if ($data['profile'] == 'avatarmale.png' || $data['profile'] == 'avatarfemale.png') {
            $image = $data['profile'];
        } else {
            $image = $data['profile']->hashName();
        }


        $data['phone'] = str_replace(' ', '', $data['phone']);

        if ($data['phone'][0] == '0') {
            $data['phone'][0] = ' ';

            $data['phone'] = str_replace(' ', '', $data['phone']);
        }

        $data['phone'] = $data['phone_hide'] . $data['phone'];






        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country_id' => $data['country'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'profile' => $image,
            'type' => '#'
        ]);


        $user->attachRole($data['role']);

        Cart::create([
            'user_id' => $user->id,
        ]);

        Balance::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'outstanding_balance' => 0,
            'pending_withdrawal_requests' => 0,
            'completed_withdrawal_requests' => 0,
            'bonus' => $user->hasRole('affiliate') ?  100 : 0,
        ]);

        return $user;
    }


    protected function registered(Request $request, User $user)
    {
        $user->callToVerify();
        return redirect($this->redirectPath($request, $user));
    }
}
