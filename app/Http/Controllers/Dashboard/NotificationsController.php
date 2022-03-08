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

class NotificationsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:notifications-read')->only('index', 'show');
        $this->middleware('permission:notifications-create')->only('create', 'store');
        $this->middleware('permission:notifications-update')->only('edit', 'update');
        $this->middleware('permission:notifications-delete')->only('destroy', 'trashed');
        $this->middleware('permission:notifications-restore')->only('restore');
    }


    public function index($lang)
    {

        $notifications = AdminNotification::whenSearch(request()->search)
            ->paginate(50);

        return view('dashboard.notifications.index')->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang, Request $request)
    {
        $countries = Country::all();
        return view('dashboard.notifications.create')->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'body_ar' => "required|string",
            'body_en' => "required|string",
            'type' => "required|string",
            'country' => "required",

        ]);

        $notification = AdminNotification::create([
            'body_ar' => $request['body_ar'],
            'body_en' => $request['body_en'],
            'type' => $request['type'],
            'country_id' => $request['country'],
            'user_id' => Auth::id(),

        ]);


        if ($request->type == 'all') {
            $users = User::where('country_id', $request->country)->get();
        } else {
            $users = User::where('country_id', $request->country)->where('type', $request->type)->get();
        }


        foreach ($users as $user) {

            $title_ar = 'اشعار من الإدارة';
            $body_ar = $request->body_ar;
            $title_en = 'Notification From Admin';
            $body_en  = $request->body_ar;


            $notification1 = Notification::create([
                'user_id' => $user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $notification->created_at,
                'url' =>  route('home', ['lang' => app()->getLocale(),  'country' => $user->country->id]),
            ]);



            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $notification->created_at->format('Y-m-d H:i:s'),
                'status' => $notification1->status,
                'url' =>  route('home', ['lang' => app()->getLocale(),  'country' => $user->country->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'country' => $user->country->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }





        session()->flash('success', 'notification created successfully');


        return redirect()->route('notifications.index', app()->getLocale());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $notification, Request $request)
    {
        $notification = notification::find($notification);
        $country = Country::findOrFail($request->country);
        $learning_system = LearningSystem::findOrFail($request->learning_system);
        return view('dashboard.notifications.edit ')->with('notification', $notification)->with('learning_system', $learning_system)->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, notification $notification)
    {

        $request->validate([

            'name_ar' => "required|string|max:255",
            'name_en' => "required|string|max:255",



        ]);



        $notification->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],

        ]);







        session()->flash('success', 'notification updated successfully');

        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        $notifications = notification::where('learning_system_id', $request->learning_system)->whenSearch(request()->search)
            ->paginate(50);

        return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $notification, Request $request)
    {

        $notification = notification::withTrashed()->where('id', $notification)->first();

        if ($notification->trashed()) {

            if (auth()->user()->hasPermission('notifications-delete')) {
                $notification->forceDelete();

                session()->flash('success', 'notification Deleted successfully');

                $notifications = notification::where('learning_system_id', $request->learning_system)->onlyTrashed()->paginate(50);

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $notifications = notification::where('learning_system_id', $request->learning_system)->onlyTrashed()->paginate(50);
                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
            }
        } else {

            if (auth()->user()->hasPermission('notifications-trash')) {
                $notification->delete();

                session()->flash('success', 'notification trashed successfully');

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                $notifications = notification::where('learning_system_id', $request->learning_system)->whenSearch(request()->search)
                    ->paginate(50);

                return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');

                $country = Country::findOrFail($request->country);

                $learning_system = LearningSystem::findOrFail($request->learning_system);

                $notifications = notification::where('learning_system_id', $request->learning_system)->whenSearch(request()->search)
                    ->paginate(50);

                return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
            }
        }
    }


    public function trashed(Request $request)
    {

        $notifications = notification::where('learning_system_id', $request->learning_system)->onlyTrashed()->paginate(50);
        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
    }

    public function restore($lang, $notification, Request $request)
    {

        $notification = notification::withTrashed()->where('id', $notification)->first()->restore();

        session()->flash('success', 'notification restored successfully');

        $country = Country::findOrFail($request->country);

        $learning_system = LearningSystem::findOrFail($request->learning_system);

        $notifications = notification::where('learning_system_id', $request->learning_system)->whenSearch(request()->search)
            ->paginate(50);

        return view('dashboard.notifications.index')->with('notifications', $notifications)->with('country', $country)->with('learning_system', $learning_system);
    }
}
