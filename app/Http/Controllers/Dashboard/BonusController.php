<?php

namespace App\Http\Controllers\Dashboard;

use App\Bonus;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Request as AppRequest;
use Carbon\Carbon;
use Exception;

class BonusController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:bonus-read')->only('index', 'show');
        $this->middleware('permission:bonus-create')->only('create', 'store');
        $this->middleware('permission:bonus-update')->only('edit', 'update');
        $this->middleware('permission:bonus-delete')->only('destroy', 'trashed');
        $this->middleware('permission:bonus-restore')->only('restore');
    }

    public function index()
    {
        $bonuses = Bonus::whenSearch(request()->search)
            ->latest()
            ->paginate(100);

        return view('dashboard.bonus.index')->with('bonuses', $bonuses);
    }

    public function create()
    {
        return view('dashboard.bonus.create');
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

            'type' => "required|string|max:255",
            'amount' => "required|numeric",
            'date' => "required|string",

        ]);


        if ($request->type == 'all') {
            $users = User::whereRoleIs(['affiliate', 'vendor'])->get();

            foreach ($users as $user) {
                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);



                $request_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $request_en = 'A bonus has been added to your account from the administration';


                $requset1 = AppRequest::create([
                    'user_id' => $user->id,
                    'balance_id' => $user->balance->id,
                    'order_id' => '0',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '+ ' . $request->amount,
                ]);


                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';

                $notification1 = Notification::create([
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $request->updated_at,
                    'status' => 0,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id])
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [

                    'notification_id' => $notification1->id,
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

                ];

                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        } elseif ($request->type == 'affiliate') {
            $users = User::whereRoleIs(['affiliate'])->get();

            foreach ($users as $user) {
                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);



                $request_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $request_en = 'A bonus has been added to your account from the administration';


                $requset1 = AppRequest::create([
                    'user_id' => $user->id,
                    'balance_id' => $user->balance->id,
                    'order_id' => '0',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '+ ' . $request->amount,
                ]);


                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';

                $notification1 = Notification::create([
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $request->updated_at,
                    'status' => 0,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id])
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [

                    'notification_id' => $notification1->id,
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

                ];

                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        } elseif ($request->type == 'vendor') {
            $users = User::whereRoleIs(['vendor'])->get();

            foreach ($users as $user) {
                $user->balance->update([
                    'bonus' => $user->balance->bonus + intval($request->amount)
                ]);



                $request_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $request_en = 'A bonus has been added to your account from the administration';


                $requset1 = AppRequest::create([
                    'user_id' => $user->id,
                    'balance_id' => $user->balance->id,
                    'order_id' => '0',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '+ ' . $request->amount,
                ]);


                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'تم اضافة بونص الى حسابك من الادارة';
                $title_en = 'New notification from admin';
                $body_en = 'A bonus has been added to your account from the administration';

                $notification1 = Notification::create([
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $request->updated_at,
                    'status' => 0,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id])
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [

                    'notification_id' => $notification1->id,
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . $user->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  $user->hasRole('affiliate') ?  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) : route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

                ];

                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        }



        $bonus = Bonus::create([

            'user_id' => Auth::id(),
            'amount' => $request['amount'],
            'date' => $request['date'],
            'type' => $request['type'],


        ]);


        session()->flash('success', 'bones added successfully');

        return redirect()->route('bonus.index', app()->getLocale());
    }
}
