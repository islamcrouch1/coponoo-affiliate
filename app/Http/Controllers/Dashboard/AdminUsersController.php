<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ProductImport;


use App\Balance;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Cart;
use App\Monitor;
use App\Teacher;
use App\Course;
use App\BankInformation;
use App\Category;
use Carbon\Traits\Timestamp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;
use App\Notification;
use App\Hour;
use App\Request as AppRequest;


use App\Wallet;
use App\Country;
use App\Exports\Product1Export;
use App\HourRequest;
use App\WalletRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Exports\UserExport;
use App\Exports\ProductExport;
use App\Exports\WithdrawalsExport;
use App\Log;
use App\Order;
use App\Product;
use App\Vorder;
use App\Withdrawal;
use Intervention\Image\ImageManagerStatic as Image;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator');

        $this->middleware('permission:users-read')->only('index', 'show');
        $this->middleware('permission:users-create')->only('create', 'store');
        $this->middleware('permission:users-update')->only('edit', 'update');
        $this->middleware('permission:users-delete')->only('destroy', 'trashed');
        $this->middleware('permission:users-restore')->only('restore');
    }


    public function index()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenType(request()->type)
            ->with('roles')
            ->latest()
            ->paginate(100);
        return view('dashboard.users.index', compact('users', 'roles', 'countries'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator'])->get();
        return view('dashboard.users.create')->with('roles', $roles)->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $request->phone = str_replace(' ', '', $request->phone);

        if ($request->phone[0] == '0') {
            $request->phone[0] = ' ';

            $request->phone = str_replace(' ', '', $request->phone);
        }


        $request->phone = $request->phone_hide . $request->phone;
        $request->merge(['phone' => $request->phone]);


        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users",
            'password' => "required|string|min:8|confirmed",
            'country' => "required",
            'phone' => "required|string|unique:users",
            'gender' => "required",
            'profile' => "image",
            'role' => "required|string"


        ]);




        if ($request['profile'] == '') {
            if ($request['gender'] == 'male') {
                $request['profile'] = 'avatarmale.png';
            } else {
                $request['profile'] = 'avatarfemale.png';
            }
        } else {


            Image::make($request['profile'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/users/' . $request['profile']->hashName()), 60);
        }



        if ($request['profile'] == 'avatarmale.png' || $request['profile'] == 'avatarfemale.png') {
            $image = $request['profile'];
        } else {
            $image = $request['profile']->hashName();
        }











        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'country_id' => $request['country'],
            'phone' => $request->phone,
            'gender' => $request['gender'],
            'profile' => $image,
            'type' => '#',
        ]);

        if ($request['role'] == '3' || $request['role'] == '4') {
            $user->attachRole($request['role']);
        } else {
            $user->attachRoles(['administrator', $request['role']]);
        }



        Cart::create([
            'user_id' => $user->id,
        ]);


        Balance::create([
            'user_id' => $user->id,
            'available_balance' => 0,
            'outstanding_balance' => 0,
            'pending_withdrawal_requests' => 0,
            'completed_withdrawal_requests' => 0,
            'bonus' => 100,
        ]);


        session()->flash('success', 'user created successfully');

        // $user->callToVerifyAdmin();


        return redirect()->route('users.index', app()->getLocale());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, User $user)
    {

        // $wallet_requests = WalletRequest::where('user_id' , $user->id)
        // ->where('status' , 'done')
        // ->paginate(20);

        // $hour_requests = HourRequest::where('user_id' , $user->id)
        // ->where('status' , 'done')
        // ->paginate(20);


        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(50);


        $orders = Order::where('user_id', $user->id)
            ->whenSearch(request()->search_order)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->latest()
            ->paginate(100);


        $vorders = Vorder::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);


        $requests = AppRequest::where('user_id', $user->id)->latest()
            ->paginate(50);


        $products = Product::where('user_id', $user->id)
            ->whenSearch(request()->search)
            ->whenCategory(request()->category_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $countries = Country::all();

        $categories = Category::all();

        return view('dashboard.users.show', compact('user', 'withdrawals', 'orders', 'countries', 'vorders', 'requests', 'products', 'categories'));
    }

    public function activate($lang, User $user)
    {

        $user->markPhoneAsVerified();

        return redirect()->route('users.index', app()->getLocale());
    }


    public function block($lang, User $user)
    {

        $user->markUserBlocked();

        return redirect()->route('users.index', app()->getLocale());
    }



    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function ordersExport($lang, Request $request)
    {
        return Excel::download(new ProductExport($request->status, $request->from, $request->to), 'orders.xlsx');
    }

    public function withdrawalsExport($lang, Request $request)
    {

        return Excel::download(new WithdrawalsExport($request->status, $request->from, $request->to), 'withdrawals.xlsx');
    }



    public function productsExport($lang, Request $request)
    {
        return Excel::download(new Product1Export($request->status, $request->category), 'products.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file('file')->store('import');


        $import = new ProductImport;
        $import->import($file);


        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }


        if (!session('status')) {

            if (app()->getLocale() == 'ar') {
                return back()->withStatus('تم رفع الملف بنجاح.');
            } else {
                return back()->withStatus('The file has been uploaded successfully.');
            }
        } else {
            return back();
        }
    }


    public function deactivate($lang, User $user)
    {

        $user->forceFill([
            'phone_verified_at' => NULL,
            'status' => "inactive"

        ])->save();


        return redirect()->route('users.index', app()->getLocale());
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $user)
    {

        $countries = Country::all();
        $roles = Role::WhereRoleNot(['superadministrator', 'administrator', 'user', 'vendor', 'affiliate'])->get();
        $user = User::find($user);
        return view('dashboard.users.edit ', compact('user', 'roles', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, User $user)
    {



        $request->phone = str_replace(' ', '', $request->phone);


        if ($request->phone[0] == '0') {
            $request->phone[0] = ' ';

            $request->phone = str_replace(' ', '', $request->phone);
        }


        $request->phone = $request->phone_hide . $request->phone;
        $request->merge(['phone' => $request->phone]);


        $request->validate([

            'name' => "required|string|max:255",
            'email' => "required|string|email|max:255|unique:users,email," . $user->id,
            'country' => "required",
            'phone' => "required|string|unique:users,phone," . $user->id,
            'gender' => "required",
            'profile' => "image",
            // 'type' => "required|string",
            'role' => "required|string",


        ]);


        if ($request->hasFile('profile')) {

            if ($user->profile == 'avatarmale.png' || $user->profile == 'avatarfemale.png') {

                Image::make($request['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $request['profile']->hashName()), 60);
            } else {
                Storage::disk('public')->delete('/images/users/' . $user->profile);

                Image::make($request['profile'])->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/images/users/' . $request['profile']->hashName()), 60);
            }


            $user->update([
                'profile' => $request['profile']->hashName(),
            ]);
        }












        if ($request->password == NULL) {


            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'country_id' => $request['country'],
                'phone' => $request->phone,
                'gender' => $request['gender'],
                // 'type' => $request['type'],
            ]);



            $description_ar = " تم تعديل بيانات المستخدم " . ' - ' .  $request['name'] . ' - ' . $request['email']  . ' - ' .  $request->phone . ' - ' . $request['gender'];
            $description_en  = "user data changed" . ' - ' .  $request['name'] . ' - ' . $request['email']  . ' - ' .  $request->phone . ' - ' . $request['gender'];

            $log = Log::create([

                'user_id' => Auth::id(),
                'user_type' => 'admin',
                'log_type' => 'users',
                'description_ar' => $description_ar,
                'description_en' => $description_en,

            ]);
        } else {

            $description_ar = "تم تعديل الرقم السري "  . 'مستخدم رقم ' . ' #' . $user->id;
            $description_en  = "password changed" . ' uesr ID ' . ' #' . $user->id;

            $log = Log::create([

                'user_id' => Auth::id(),
                'user_type' => 'admin',
                'log_type' => 'users',
                'description_ar' => $description_ar,
                'description_en' => $description_en,

            ]);


            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'country_id' => $request['country'],
                'phone' => $request->phone,
                'gender' => $request['gender'],
                'password' => Hash::make($request['password']),
                // 'type' => $request['type'],
            ]);
        }







        if ($request['role'] == '3' || $request['role'] == '4') {
            $user->detachRoles($user->roles);
            $user->attachRole($request['role']);
        } else {
            $user->detachRoles($user->roles);
            $user->attachRoles(['administrator', $request['role']]);
        }

        session()->flash('success', 'user updated successfully');

        return redirect()->route('users.index', app()->getLocale());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $user)
    {

        $user = User::withTrashed()->where('id', $user)->first();

        if ($user->trashed()) {

            if (auth()->user()->hasPermission('users-delete')) {


                Storage::disk('public')->delete('/images/users/' . $user->profile);

                $user->forceDelete();

                session()->flash('success', 'user Deleted successfully');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                    ->whereRoleNot('superadministrator')
                    ->whenSearch(request()->search)
                    ->whenRole(request()->role_id)
                    ->whenCountry(request()->country_id)
                    ->whenStatus(request()->status)
                    ->whenType(request()->type)
                    ->with('roles')
                    ->latest()
                    ->paginate(100);


                return view('dashboard.users.index', compact('users', 'roles', 'countries'));
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                $countries = Country::all();
                $roles = Role::WhereRoleNot('superadministrator')->get();
                $users = User::onlyTrashed()
                    ->whereRoleNot('superadministrator')
                    ->whenSearch(request()->search)
                    ->whenRole(request()->role_id)
                    ->whenCountry(request()->country_id)
                    ->whenStatus(request()->status)
                    ->whenType(request()->type)
                    ->with('roles')
                    ->latest()
                    ->paginate(100);


                return view('dashboard.users.index', compact('users', 'roles', 'countries'));
            }
        } else {
            if (auth()->user()->hasPermission('users-trash')) {


                if ($user->orders->count() > '0' || $user->messages->count() > '0' || $user->vorders->count() > '0') {
                    session()->flash('success', 'you can not delete this user because it is related with some data on the system');
                    return redirect()->route('users.index', app()->getLocale());
                }

                $user->delete();

                session()->flash('success', 'user trashed successfully');
                return redirect()->route('users.index', app()->getLocale());
            } else {
                session()->flash('success', 'Sorry.. you do not have permission to make this action');
                return redirect()->route('users.index', app()->getLocale());
            }
        }
    }



    public function trashed()
    {
        $countries = Country::all();
        $roles = Role::WhereRoleNot('superadministrator')->get();
        $users = User::onlyTrashed()
            ->whereRoleNot('superadministrator')
            ->whenSearch(request()->search)
            ->whenRole(request()->role_id)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenType(request()->type)
            ->with('roles')
            ->latest()
            ->paginate(100);


        return view('dashboard.users.index', compact('users', 'roles', 'countries'));
    }

    public function restore($lang, $user)
    {

        $user = User::withTrashed()->where('id', $user)->first()->restore();

        session()->flash('success', 'user restored successfully');
        return redirect()->route('users.index', app()->getLocale());
    }

    public function monitor($lang, Request $request, User $user)
    {

        $request->validate([

            'countries' => "array",
            'courses_categories' => "array",
            'teachers' => "array",

        ]);



        $user->monitor->countries()->sync($request->countries);
        $user->monitor->courses_categories()->sync($request->courses_categories);
        $user->monitor->teachers()->sync($request->teachers);


        session()->flash('success', 'user updated successfully');
        return redirect()->route('users.index', app()->getLocale());
    }


    public function addBalance($lang, Request $request, User $user)
    {

        $request->validate([

            'balance' => "required|string",

        ]);




        $wallet = Wallet::whare('user_id', $user->id)->first();

        $balance = $request->balance;


        if ($balance > 0) {

            $orderid = time() . rand(999, 9999);

            $request_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance . ' ' . $user->country->currency;
            $request_en = 'You have earned free wallet credit with a value : ' . $request->balance . ' ' . $user->country->currency;


            $wallet_request = WalletRequest::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'status' => 'done',
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => $request->balance,
                'orderid' => $orderid,
            ]);



            $wallet->update([

                'balance' => $wallet->balance + $wallet_request->balance,

            ]);

            $title_ar = 'اشعار من الإدارة';
            $body_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance . ' ' . $user->country->currency;
            $title_en = 'Notification From Admin';
            $body_en  = 'You have earned free wallet credit with a value : ' . $request->balance . ' ' . $user->country->currency;


            $notification = Notification::create([
                'user_id' => $user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $wallet_request->created_at,
                'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
            ]);



            $data = [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $wallet_request->created_at->format('Y-m-d H:i:s'),
                'status' => $notification->status,
                'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'country' => $user->country->id, 'notification' => $notification->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }



            session()->flash('success', 'Ballace Added successfully');
        } else {
            session()->flash('success', 'Can not add 0 balance to user wallet');
        }


        return redirect()->route('users.index', app()->getLocale());
    }



    public function addBalanceAll($lang, Request $request)
    {

        $request->validate([

            'balance_students' => "required|string",
            'balance_teachers' => "required|string",
            'country_id' => "required|string",


        ]);

        $balance_students = $request->balance_students;
        $balance_teachers = $request->balance_teachers;



        if ($balance_students > 0) {


            $users = User::where('type', 'student')
                ->where('country_id', $request->country_id)
                ->get();

            foreach ($users as $user) {

                $wallet = Wallet::whare('user_id', $user->id)->first();


                $orderid = time() . rand(999, 9999);

                $request_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance_students . ' ' . $user->country->currency;
                $request_en = 'You have earned free wallet credit with a value : ' . $request->balance_students . ' ' . $user->country->currency;


                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $wallet->id,
                    'status' => 'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => $request->balance_students,
                    'orderid' => $orderid,
                ]);



                $wallet->update([

                    'balance' => $wallet->balance + $wallet_request->balance,

                ]);

                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance_students . ' ' . $user->country->currency;
                $title_en = 'Notification From Admin';
                $body_en  = 'You have earned free wallet credit with a value : ' . $request->balance_students . ' ' . $user->country->currency;


                $notification = Notification::create([
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $wallet_request->created_at,
                    'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
                ]);



                $data = [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $wallet_request->created_at->format('Y-m-d H:i:s'),
                    'status' => $notification->status,
                    'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'country' => $user->country->id, 'notification' => $notification->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        }


        if ($balance_teachers > 0) {


            $users = User::where('type', 'teacher')
                ->where('country_id', $request->country_id)
                ->get();

            foreach ($users as $user) {

                $wallet = Wallet::whare('user_id', $user->id)->first();


                $orderid = time() . rand(999, 9999);

                $request_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance_teachers . ' ' . $user->country->currency;
                $request_en = 'You have earned free wallet credit with a value : ' . $request->balance_teachers . ' ' . $user->country->currency;


                $wallet_request = WalletRequest::create([
                    'user_id' => $user->id,
                    'wallet_id' => $wallet->id,
                    'status' => 'done',
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => $request->balance_teachers,
                    'orderid' => $orderid,
                ]);



                $wallet->update([

                    'balance' => $wallet->balance + $wallet_request->balance,

                ]);

                $title_ar = 'اشعار من الإدارة';
                $body_ar = 'لقد ربحت رصيد مجاني في محفظتك بقيمة : ' . $request->balance_teachers . ' ' . $user->country->currency;
                $title_en = 'Notification From Admin';
                $body_en  = 'You have earned free wallet credit with a value : ' . $request->balance_teachers . ' ' . $user->country->currency;


                $notification = Notification::create([
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $wallet_request->created_at,
                    'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
                ]);



                $data = [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $wallet_request->created_at->format('Y-m-d H:i:s'),
                    'status' => $notification->status,
                    'url' =>  route('wallet', ['lang' => app()->getLocale(), 'user' => $user->id,  'country' => $user->country->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user->id, 'country' => $user->country->id, 'notification' => $notification->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        }




        session()->flash('success', 'Ballace Added successfully');
        return redirect()->route('users.index', app()->getLocale());
    }
}
