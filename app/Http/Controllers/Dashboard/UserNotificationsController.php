<?php

namespace App\Http\Controllers\Dashboard;
use App\AdminNotification;
use App\Country;
use App\Http\Controllers\Controller;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

class UserNotificationsController extends Controller
{


    public function index($lang , $user)
    {
        $notifications = Notification::where('user_id' , $user)
        ->whenSearch(request()->search)
        ->paginate(50);

        return view('dashboard.notifications.index')->with('notifications' , $notifications);
    }

    public function changeStatus ($lang , $user , Request $request)
    {


        $notification = Notification::findOrFail($request->notification);



        if($notification->status == 0){

            $notification->update([
                'status' => 1 ,
            ]);

        }
    }


    public function changeStatusAll ($lang , $user , Request $request)
    {


        $notifications = Notification::where('user_id' , $user)->get();


        foreach($notifications as $notification){


        if($notification->status == 0){

            $notification->update([
                'status' => 1 ,
            ]);

        }


        }


        return redirect()->back();



    }


}
