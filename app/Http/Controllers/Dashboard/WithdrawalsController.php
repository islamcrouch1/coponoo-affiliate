<?php

namespace App\Http\Controllers\Dashboard;

use App\Balance;
use App\Country;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Request as AppRequest;
use App\User;
use App\Withdrawal;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator|affiliate|vendor');

        $this->middleware('permission:withdrawals-read')->only('index', 'show');
        $this->middleware('permission:withdrawals-create')->only('create', 'store');
        $this->middleware('permission:withdrawals-update')->only('edit', 'update');
        $this->middleware('permission:withdrawals-delete')->only('destroy', 'trashed');
        $this->middleware('permission:withdrawals-restore')->only('restore');
    }


    public function index(Request $request)
    {



        if (!$request->has('from') || !$request->has('to')) {

            $request->merge(['from' => Carbon::now()->subDay(365)->toDateString()]);
            $request->merge(['to' => Carbon::now()->toDateString()]);
        }

        $countries = Country::all();
        $withdrawals = Withdrawal::whereDate('created_at', '>=', request()->from)
            ->whereDate('created_at', '<=', request()->to)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);




        return view('dashboard.withdrawals.index', compact('withdrawals', 'countries'));
    }

    public function updateRequest($lang, Request $request, Withdrawal $withdrawal)
    {
        $request->validate([

            'status' => "required|string|max:255",

        ]);



        $withdrawal->update([
            'status' => $request->status,
        ]);

        $user = User::find($withdrawal->user_id);


        $balance = Balance::where('user_id', $user->id)->first();




        if ($request->status == 'canceled') {

            $balance->update([
                'available_balance' => $balance->available_balance  + $withdrawal->amount,
                'pending_withdrawal_requests' => $balance->pending_withdrawal_requests - $withdrawal->amount,
            ]);
        } elseif ($request->status == 'confirmed') {

            $balance->update([
                'completed_withdrawal_requests' => $balance->completed_withdrawal_requests  + $withdrawal->amount,
                'pending_withdrawal_requests' => $balance->pending_withdrawal_requests - $withdrawal->amount,
            ]);
        }




        if ($user->HasRole('vendor')) {



            switch ($request->status) {
                case "pending":
                    $status_en = "pending";
                    $status_ar = "معلق";
                    break;
                case "recieved":
                    $status_en = "recieved";
                    $status_ar = "تم الاستلام وقيد المراجعة من الادارة";
                    break;
                case "confirmed":
                    $status_en = "confirmed";
                    $status_ar = "تم تاكيد الطلب وارسال المبلغ";
                    break;
                case "canceled":
                    $status_en = "canceled";
                    $status_ar = "تم الغاء الطلب";
                    break;
                default:
                    break;
            }




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة طلب سحب الرصيد الخاص بك الى " . $status_ar;
            $title_en = 'Notification From Admin';
            $body_en  = "Your withdrawal request status has been changed to " . $status_en;

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
                'url' =>  route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]),
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
                'url' =>  route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }


        if ($user->HasRole('affiliate')) {



            switch ($request->status) {
                case "pending":
                    $status_en = "pending";
                    $status_ar = "معلق";
                    break;
                case "recieved":
                    $status_en = "recieved";
                    $status_ar = "تم الاستلام وقيد المراجعة من الادارة";
                    break;
                case "confirmed":
                    $status_en = "confirmed";
                    $status_ar = "تم تاكيد الطلب وارسال المبلغ";
                    break;
                case "canceled":
                    $status_en = "canceled";
                    $status_ar = "تم الغاء الطلب";
                    break;
                default:
                    break;
            }




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة طلب سحب الرصيد الخاص بك الى " . $status_ar;
            $title_en = 'Notification From Admin';
            $body_en  = "Your withdrawal request status has been changed to " . $status_en;

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
                'url' =>  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]),
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
                'url' =>  route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }







        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        } else {
            session()->flash('success', 'request updated successfully');
        }


        return redirect()->route('withdraw.admin', app()->getLocale());
    }







    public function indexaffiliate($lang, $user)
    {


        $user = User::find($user);
        $withdrawals = Withdrawal::whenSearch(request()->search)->where('user_id', $user->id)->latest()->paginate(100);

        $requests = AppRequest::where('user_id', $user->id)->latest()
            ->paginate(50);

        return view('dashboard.withdrawals.affiliate', compact('user', 'withdrawals', 'requests'));
    }


    public function indexVendor($lang, $user)
    {


        $user = User::find($user);
        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->paginate(100);

        $requests = AppRequest::where('user_id', $user->id)->latest()
            ->paginate(50);

        return view('dashboard.withdrawals.vendor', compact('user', 'withdrawals', 'requests'));
    }


    public function newRequest($lang, $user)
    {


        $user = User::find($user);
        return view('dashboard.withdrawals.request', compact('user'));
    }



    public function newVendorRequest($lang, $user)
    {


        $user = User::find($user);
        return view('dashboard.withdrawals.vendor-request', compact('user'));
    }

    public function bankInformation($lang, $user, $country, Request $request)
    {

        $request->validate([

            'full_name' => "required|string",
            'bank_name' => "required|string",
            'bank_account_number' => "required|string",
            'image1' => "image",
            'image2' => "image",
        ]);





        $links = Link::all();
        $user = User::find($user);


        $scountry = Country::findOrFail($user->country_id);
        $countries = Country::all();



        if ($request->hasFile('image1')) {



            Image::make($request['image1'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/bankinformation/' . $request['image1']->hashName()), 60);

            $image1 = $request['image1']->hashName();
        } else {
            if ($user->bank_information->image1 == Null) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'عزيز المعلم يرجى ارفاق صورة البطاقة الشخصية لكي يتم حفظ معلوماتك البنكية');
                } else {

                    session()->flash('success', 'You Should Upload Your ID Images');
                }

                return redirect()->route('finances', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $scountry->id]);
            } else {
                $image1 = $user->bank_information->image1;
            }
        }


        if ($request->hasFile('image2')) {

            Image::make($request['image2'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/bankinformation/' . $request['image2']->hashName()), 60);

            $image2 = $request['image2']->hashName();
        } else {
            if ($user->bank_information->image2 == Null) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'عزيز المعلم يرجى ارفاق صورة البطاقة الشخصية لكي يتم حفظ معلوماتك البنكية');
                } else {

                    session()->flash('success', 'You Should Upload Your ID Images');
                }

                return redirect()->route('finances', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $scountry->id]);
            } else {
                $image2 = $user->bank_information->image2;
            }
        }



        $user->bank_information->update([

            'full_name' => $request['full_name'],
            'bank_name' => $request['bank_name'],
            'bank_account_number' => $request['bank_account_number'],
            'image1' => $image1,
            'image2' => $image2,

        ]);



        if (app()->getLocale() == 'ar') {

            session()->flash('success', 'تم حفظ البيانات بنجاح');
        } else {

            session()->flash('success', 'Data Saved Successfully');
        }

        return redirect()->route('finances', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $scountry->id]);
    }


    public function storeRequest($lang, $user, Request $request)
    {



        $request->validate([

            'amount' => "required|integer",
            'type' => "required|string",
            'data' => "required|string",
            'code' => "required|string",
        ]);


        $user = User::find($user);


        if ($request->code == $user->verification_code) {
            if ($request->amount <= 0) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'لم يمكنك عمل طلب سحب الرصيد');
                } else {

                    session()->flash('success', 'You cannot make a request to withdraw the balance');
                }

                return redirect()->route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } elseif ($request->amount < '300') {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'لا يمكن عمل طلب سحب رصيدة أقل من 300 جنيه');
                } else {

                    session()->flash('success', 'It is not possible to make a request to withdraw the balance less than 300 EGP');
                }

                return redirect()->route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } elseif ($request->amount > $user->balance->available_balance + $user->balance->bonus) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'المبلغ الذي ادخلته غير متوفر في حسابك لا يمكنك من اتمام الطلب');
                } else {

                    session()->flash('success', 'The amount you entered is not available in your account. You cannot complete the order');
                }

                return redirect()->route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } else {



                $balance = Balance::where('user_id', $user->id)->first();


                $withdraw = Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'status' => 'pending',
                    'code' => 123456,
                    'country_id' => $user->country->id,
                    'user_name' => $user->name,
                    'data' => $request->data,
                    'type' => $request->type,
                ]);



                if ($request->amount < $balance->available_balance) {

                    $balance->update([
                        'available_balance' => $balance->available_balance  - $request->amount,
                        'pending_withdrawal_requests' => $balance->pending_withdrawal_requests + $request->amount,
                    ]);
                } else {


                    $nAmount = $request->amount - $balance->available_balance;


                    $balance->update([
                        'available_balance' => 0,
                        'bonus' => $balance->bonus - $nAmount,
                        'pending_withdrawal_requests' => $balance->pending_withdrawal_requests + $request->amount,

                    ]);
                }







                $users = User::whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'vendor')
                        ->where('name', '!=', 'affiliate');
                })->get();



                foreach ($users as $user1) {


                    $title_ar = 'يوجد طلب سحب رصيد';
                    $body_ar = 'تم اضافة طلب سحب رصيد جديد  : ' . $user->name;
                    $title_en = 'There is a new balance withdrawal request';
                    $body_en  = 'A new balance withdrawal request has been added from : ' . $user->name;

                    $notification1 = Notification::create([
                        'user_id' => $user1->id,
                        'user_name'  => $user->name,
                        'user_image' => asset('storage/images/users/' . $user->profile),
                        'title_ar' => $title_ar,
                        'body_ar' => $body_ar,
                        'title_en' => $title_en,
                        'body_en' => $body_en,
                        'date' => $request->updated_at,
                        'status' => 0,
                        'url' =>  route('withdraw.admin', ['lang' => app()->getLocale()]),
                    ]);



                    $date =  Carbon::now();
                    $interval = $notification1->created_at->diffForHumans($date);

                    $data = [
                        'notification_id' => $notification1->id,
                        'user_id' => $user1->id,
                        'user_name'  => $user->name,
                        'user_image' => asset('storage/images/users/' . $user->profile),
                        'title_ar' => $title_ar,
                        'body_ar' => $body_ar,
                        'title_en' => $title_en,
                        'body_en' => $body_en,
                        'date' => $interval,
                        'status' => $notification1->status,
                        'url' =>  route('withdraw.admin', ['lang' => app()->getLocale()]),
                        'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user1->id, 'notification' => $notification1->id]),

                    ];

                    try {
                        event(new NewNotification($data));
                    } catch (Exception $e) {
                    }
                }



                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'تم ارسال الطلب بنجاح وسوف يتم مراجعته من الإدارة');
                } else {

                    session()->flash('success', 'The request has been sent successfully and it will be reviewed by the administration');
                }

                return redirect()->route('withdrawals.index.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]);
            }
        } else {
            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'كود تاكيد الطلب غير صحيح');
            } else {

                session()->flash('success', 'Invalid request confirmation code');
            }

            return redirect()->route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }
    }


    public function storeVendorRequest($lang, $user, Request $request)
    {



        $request->validate([

            'amount' => "required|integer",
            'type' => "required|string",
            'data' => "required|string",
        ]);


        $user = User::find($user);


        if ($request->code == $user->verification_code) {


            if ($request->amount <= 0) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'لم يمكنك عمل طلب سحب الرصيد');
                } else {

                    session()->flash('success', 'You cannot make a request to withdraw the balance');
                }

                return redirect()->route('vendor-withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } elseif ($request->amount < '200') {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'لا يمكن عمل طلب سحب رصيدة أقل من ٢٠٠ جنيه');
                } else {

                    session()->flash('success', 'It is not possible to make a request to withdraw the balance less than 200 EGP');
                }

                return redirect()->route('vendor-withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } elseif ($request->amount > $user->balance->available_balance + $user->balance->bonus) {

                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'المبلغ الذي ادخلته غير متوفر في حسابك لا يمكنك من اتمام الطلب');
                } else {

                    session()->flash('success', 'The amount you entered is not available in your account. You cannot complete the order');
                }

                return redirect()->route('vendor-withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
            } else {



                $balance = Balance::where('user_id', $user->id)->first();


                $withdraw = Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'status' => 'pending',
                    'code' => 123456,
                    'country_id' => $user->country->id,
                    'user_name' => $user->name,
                    'data' => $request->data,
                    'type' => $request->type,
                ]);


                if ($request->amount < $balance->available_balance) {

                    $balance->update([
                        'available_balance' => $balance->available_balance  - $request->amount,
                        'pending_withdrawal_requests' => $balance->pending_withdrawal_requests + $request->amount,
                    ]);
                } else {


                    $nAmount = $request->amount - $balance->available_balance;


                    $balance->update([
                        'available_balance' => 0,
                        'bonus' => $balance->bonus - $nAmount,
                        'pending_withdrawal_requests' => $balance->pending_withdrawal_requests + $request->amount,

                    ]);
                }





                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'تم ارسال الطلب بنجاح وسوف يتم مراجعته من الإدارة');
                } else {

                    session()->flash('success', 'The request has been sent successfully and it will be reviewed by the administration');
                }

                return redirect()->route('withdrawals.index.vendor', ['lang' => app()->getLocale(), 'user' => $user->id]);
            }
        } else {
            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'كود تاكيد الطلب غير صحيح');
            } else {

                session()->flash('success', 'Invalid request confirmation code');
            }

            return redirect()->route('withdrawals.request', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }
    }
}
