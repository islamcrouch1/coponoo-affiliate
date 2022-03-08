<?php

namespace App\Http\Controllers\Dashboard;

use App\Country;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ProfileController extends Controller
{
    public function edit($lang)
    {

        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator' , 'administrator'])->get();
        $user = Auth::user();
        return view('dashboard.users.profile ' , compact('user' , 'roles' , 'countries'));
    }


    public function update($lang ,Request $request)
    {


        $user = Auth::user();

        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'profile' => "image",

            ]);


            if($request->hasFile('profile')){

                if($user->profile == 'avatarmale.png' || $user->profile == 'avatarfemale.png'){

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }else{
                    Storage::disk('public')->delete('/images/users/' . $user->profile);

                    Image::make($request['profile'])->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('storage/images/users/' . $request['profile']->hashName()) , 60);

                }


                $user->update([
                    'profile' => $request['profile']->hashName(),
                ]);
            }



            // $request->phone = str_replace(' ', '', $request->phone);
            // $request->phone = $request->phone_hide . $request->phone;
            // $request->merge(['phone' => $request->phone]);






            if($request->password == NULL){


                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    // 'country_id' => $request['country'],
                    // 'phone' => $request->phone,
                    // 'gender' => $request['gender'],
                    // 'type' => $request['type'],
                ]);


            }else{
                $user->update([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    // 'country_id' => $request['country'],
                    // 'phone' => $request->phone,
                    // 'gender' => $request['gender'],
                    'password' => Hash::make($request['password']),
                    // 'type' => $request['type'],
                ]);

            }






            // if($request['role'] == '3'){
            //     $user->detachRoles($user->roles);
            //     $user->attachRole($request['role']);
            // }else{
            //     $user->detachRoles($user->roles);
            //     $user->attachRoles(['administrator' , $request['role']]);


            // }

            if(app()->getLocale() == 'ar'){
                session()->flash('success' , 'تم تحديث حسابك بنجاح');

            }else{
                session()->flash('success' , 'Your profile updated successfully');

            }


            return redirect()->route('profile.edit' , app()->getLocale());

    }
}
