<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use \Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;



use App\Country;
use App\User;
use Illuminate\Support\Facades\Redirect;

class PasswordResetController extends Controller
{
    public function index($lang ,  $country)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail($country);
        $countries = Country::all();




        return view('password-reset-request' , compact('countries' , 'scountry'  ));
    }

    public function verify($lang ,  $country , Request $request)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail($country);
        $countries = Country::all();



        $request->phone = str_replace(' ', '', $request->phone);

        if($request->phone[0] == '0'){
            $request->phone[0] = ' ' ;

            $request->phone = str_replace(' ', '', $request->phone);

        }



        $request->phone = $request->phone_hide . $request->phone;
        $request->merge(['phone' => $request->phone]);


        $user = User::where('phone' , $request->phone)->first();


        if($user == null){
            if(app()->getLocale() == 'ar'){
                return redirect()->route('password.reset.request'  , ['lang' => app()->getLocale() , 'country' => $scountry])->with('status', 'رقم الموبايل الذي ادخلته غير صحيح أو لم يتم التسجيل به في المنصة الخاصة بنا');
            }else{
                return redirect()->route('password.reset.request'  , ['lang' => app()->getLocale() , 'country' => $scountry])->with('status', 'The mobile number you entered is not valid or has not been registered on our platform');
            }
        }else{
            $user->callToVerify();
            return redirect()->route('password.reset.confirm.show'  , ['lang' => app()->getLocale() , 'country' => $scountry , 'user' => $user->id]);
        }




    }


    public function show($lang ,  $country , Request $request)
    {
        // $category = Category::all();

        $scountry = Country::findOrFail($country);
        $countries = Country::all();

        $user = User::find($request->user);

            return view('password-reset-confirm' , compact('countries' , 'scountry'  , 'user' ));

    }

    public function resend($lang , $country , Request $request)
    {


        $user = User::find($request->user);
        $user->callToVerify();

        return Redirect::back();


    }


    public function sendConf($lang , Request $request)
    {


        $user = User::find($request->user);
        $user->callToVerify();

        return 1;


    }


    public function change($lang , $country , Request $request)
    {


        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        $user = User::find($request->user);


        if ($user->verification_code !== $request->code) {
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

        return view('password-reset-change'  , compact('countries' , 'scountry'  , 'user' ));


    }


    public function confirm($lang , $country , Request $request)
    {

        $scountry = Country::findOrFail($country);
        $countries = Country::all();
        $user = User::find($request->user);



        if($request->password != $request->password_confirmation){



            if(app()->getLocale() == 'ar'){
                $request->session()->flash('status','الرقم السري الذي ادخلته غير متطابق');
                return view('password-reset-change' , compact('countries' , 'scountry'  , 'user' ));
            }else{
                $request->session()->flash('status','The password you entered does not match');
                return view('password-reset-change' , compact('countries' , 'scountry'  , 'user' ));
            }
        }





        $user->update([
            'password' => Hash::make($request['password']),
        ]);


        if(app()->getLocale() == 'ar'){

            session()->flash('success' , 'تم تغيير الرقم السري بنجاح');

        }else{

            session()->flash('success' , 'Password changed successfully');
        }


        return redirect()->route('login'  , ['lang' => app()->getLocale() , 'country'=>$scountry->id]);

    }





}
