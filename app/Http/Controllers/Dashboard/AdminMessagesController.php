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

class AdminMessagesController extends Controller
{
    public function index($lang, $user)
    {

        $messages = Message::whenSearch(request()->search)
            ->paginate(100);

        return view('dashboard.messages.index')->with('messages', $messages);
    }


    public function add($lang, $user, Request $request)
    {
        $request->validate([

            'message' => "required|string",

        ]);


        $admin = Auth::user();

        $user = User::find($user);



        $message = Message::create([

            'message' => $request['message'],
            'user_id' => $user->id,
            'profile' => $admin->profile,
            'sender_id' => $admin->id,

        ]);


        $title_ar = 'رسالة من الدعم الفني';
        $body_ar = $message->message;
        $title_en = 'Message from technical support';
        $body_en  = $message->message;

        $notification1 = Notification::create([
            'user_id' => $user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $request->updated_at,
            'status' => 0,
            'url' =>  route('messages.show', ['lang' => app()->getLocale(), 'user' => $user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('messages.show', ['lang' => app()->getLocale(), 'user' => $user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

        ];

        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }



        session()->flash('success', 'message created successfully');

        return redirect()->route('users.show', [app()->getLocale(), $request['user']]);
    }

    public function delete($lang, Message $message)
    {

        $message->forceDelete();

        session()->flash('success', 'Message Deleted successfully');
        return redirect()->route('users.show', [app()->getLocale(), $message->user_id]);
    }
}
