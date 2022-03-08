<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Message;
use App\Notification;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{



    public function show($lang, $user)
    {


        $user = User::find($user);

        return view('dashboard.messages.show')->with('user', $user);
    }


    public function add(Request $request)
    {
        $request->validate([

            'message' => "required|string",

        ]);


        $user1 = Auth::user();


        $message = Message::create([

            'message' => $request['message'],
            'user_id' => $user1->id,
            'profile' => $user1->profile,
            'sender_id' => $user1->id,

        ]);




        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();



        foreach ($users as $user) {


            $title_ar = 'يوجد رسالة جديدة للدعم الفني';
            $body_ar = $message->message;
            $title_en = 'There is a new message for technical support';
            $body_en  = $message->message;

            $notification1 = Notification::create([
                'user_id' => $user->id,
                'user_name'  => $user1->name,
                'user_image' => asset('storage/images/users/' . $user1->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $request->updated_at,
                'status' => 0,
                'url' =>  route('users.show', ['lang' => app()->getLocale(), 'user' => $user1->id]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $user->id,
                'user_name'  => $user1->name,
                'user_image' => asset('storage/images/users/' . $user1->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('users.show', ['lang' => app()->getLocale(), 'user' => $user1->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }









        session()->flash('success', 'message created successfully');

        return redirect()->route('messages.show', [app()->getLocale(), $request['user']]);
    }
}
