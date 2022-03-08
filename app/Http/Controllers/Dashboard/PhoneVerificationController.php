<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \Illuminate\Validation\ValidationException;

use App\Country;
use App\User;
use Illuminate\Support\Facades\Redirect;

class PhoneVerificationController extends Controller
{

    public function show(Request $request)
    {


        $scountry = Country::findOrFail($request->country);
        $countries = Country::all();




        return $request->user()->hasVerifiedPhone()
                        ? redirect()->route('home' , app()->getLocale())
                        : view('verifyphone' , compact('countries' , 'scountry' ));
    }

    public function verify($lang , Request $request , $country)
    {



        $scountry = Country::findOrFail($country);
        $countries = Country::all();




        if ($request->user()->verification_code !== $request->code) {
            if(app()->getLocale() == "en"){
                throw ValidationException::withMessages([
                    'code' => ['The code your provided is wrong. Please try again or request another call.'],
                ]);
            }else{
                throw ValidationException::withMessages([
                    'code' => ['الكود الذي ادخلته غير صحيح , يرجى المحاولة مره اخرى'],
                ]);
            }

        }

        if ($request->user()->hasVerifiedPhone()) {

            return redirect()->route('home' , ['user'=>$request->user() , 'lang'=>app()->getLocale()]);

        }

        $request->user()->markPhoneAsVerified();

        // return redirect()->route('home')->with('status', 'Your phone was successfully verified!');

        return redirect()->route('home' , ['user'=>$request->user() , 'lang'=>app()->getLocale()]);

    }


    public function resend($lang , $user , $country , Request $request)
    {


        $user = User::find($user);
        $user->callToVerify();


        return Redirect::back();


    }

}
