<?php

namespace App\Http\Controllers\Dashboard;

use App\Astock;
use App\Balance;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use App\Category;
use App\Product;
use App\Vorder;

use App\Notification;

use App\Events\NewNotification;
use App\Log;
use App\Request as AppRequest;
use App\ShippingRate;
use App\Stock;
use App\Wallet;
use App\WalletRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('role:superadministrator|administrator|affiliate|vendor');

        $this->middleware('permission:orders-read')->only('index', 'show');
        $this->middleware('permission:orders-create')->only('create', 'store');
        $this->middleware('permission:orders-update')->only('edit', 'update');
        $this->middleware('permission:orders-delete')->only('destroy', 'trashed');
        $this->middleware('permission:orders-restore')->only('restore');
    }


    public function index()
    {
        $orders = Order::whenSearch(request()->search)
            ->whenCountry(request()->country_id)
            ->whenStatus(request()->status)
            ->whenPaymentStatus(request()->payment_status)
            ->paginate(100);

        return view('dashboard.orders.index')->with('orders', $orders);
    }

    public function affiliateIndex($lang, $user)
    {
        $orders = Order::where('user_id', $user)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $user = User::find($user);

        return view('dashboard.orders.affiliate_orders')->with('orders', $orders)->with('user', $user);
    }


    public function vendorIndex($lang, $user)
    {
        $orders = Vorder::where('user_id', $user)
            ->whenSearch(request()->search)
            ->whenStatus(request()->status)
            ->latest()
            ->paginate(100);

        $user = User::find($user);

        return view('dashboard.orders.vendor_orders')->with('orders', $orders)->with('user', $user);
    }


    public function affiliateShow($lang, $order)
    {

        $order = Order::find($order);



        return view('dashboard.orders.affiliate_orders_show')->with('order', $order);
    }


    public function vendorShow($lang, $order)
    {

        $order = Vorder::find($order);



        return view('dashboard.orders.vendor_orders_show')->with('order', $order);
    }


    public function vendorShowAdmin($lang, $order)
    {

        $order = Vorder::find($order);



        return view('dashboard.orders.vendor_orders_show_admin')->with('order', $order);
    }

    public function printOrder($lang, $order)
    {

        $order = Order::find($order);



        return view('dashboard.orders.affiliate_orders_print')->with('order', $order);
    }


    public function printVendorOrder($lang, $order)
    {

        $order = Vorder::find($order);



        return view('dashboard.orders.vendor_orders_print')->with('order', $order);
    }


    public function printVendorOrderAdmin($lang, $order)
    {

        $order = Vorder::find($order);



        return view('dashboard.orders.vendor_admin_show_print')->with('order', $order);
    }


    public function cancelOrder($lang, $order)
    {

        $order = Order::find($order);

        // foreach ($order->products as $product) {

        //     $product->update([
        //         'stock' => $product->stock + $product->pivot->quantity
        //     ]);

        // }

        foreach ($order->products as $product) {

            if ($product->pivot->product_type == '0') {

                $product->stocks->find($product->pivot->stock_id)->update([
                    'stock' => $product->stocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                ]);
            } else {

                $product->astocks->find($product->pivot->stock_id)->update([
                    'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                ]);
            }
        } //end of foreach


        foreach ($order->vorders as $vorder) {


            $balance1 = Balance::where('user_id', $vorder->user->id)->first();

            $balance1->update([
                'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
            ]);

            $vorder->update([
                'status' => 'canceled',
            ]);


            $request_ar = 'تم تغيير حالة الطلب الى : ' .  'ملغي' . ' - ' . 'تعديل على الرصيد المعلق';
            $request_en = 'Order status changed to : ' . 'canceled' . ' - ' . 'Outstanding balance change';





            $requset1 = AppRequest::create([
                'user_id' => $vorder->user->id,
                'balance_id' => $balance1->id,
                'order_id' => $vorder->id,
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => '- ' . $vorder->total_price,
            ]);
        } //end of foreach

        $order->update([
            'status' => 'canceled',
        ]);


        $description_ar = "تم تغيير حالة الطلب الى ملغي" . ' طلب رقم ' . ' #' . $order->id;
        $description_en  = "order status has been changed to cancelled" . ' order No ' . ' #' . $order->id;

        $log = Log::create([

            'user_id' => $order->user->id,
            'user_type' => 'affiliate',
            'log_type' => 'orders',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);


        $mystock_price = 0;

        foreach ($order->products as $product) {
            if ($product->pivot->product_type != '0') {
                $mystock_price += ($product->min_price * $product->pivot->stock);
            }
        }

        $balance = Balance::where('user_id', $order->user->id)->first();

        $balance->update([
            'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission - $mystock_price,
        ]);


        $request_ar = 'تم تغيير حالة الطلب الى : ' .  'ملغي' . ' - ' . 'تعديل على الرصيد المعلق';
        $request_en = 'Order status changed to : ' . 'canceled' . ' - ' . 'Outstanding balance change';


        $requset1 = AppRequest::create([
            'user_id' => $order->user->id,
            'balance_id' => $balance->id,
            'order_id' => $order->id,
            'request_ar' => $request_ar,
            'request_en' => $request_en,
            'balance' => '- ' . ($order->total_commission + $mystock_price),
        ]);

        if (app()->getLocale() == 'ar') {

            session()->flash('success', 'تم إلغاء الطلب بنجاح');
        } else {

            session()->flash('success', 'Order canceled successfully');
        }


        return redirect()->route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lang, Request $request)
    {

        $user = User::find($request->user);


        $categories = Category::where('country_id', $user->country->id)->with('products')->get();

        $orders = $user->orders()->with('products')->paginate(100);



        return view('dashboard.orders.create', compact('user', 'categories', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeaffiliate($lang, Request $request, $user)
    {

        $user = User::find($user);


        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'shipping' => 'required|string',
            'phone1' => 'required|string',
            'notes' => 'nullable|string',
            'house' => 'nullable|string',
            'phone2' => 'nullable|string',
            'special_mark' => 'nullable|string',



        ]);


        if ($request->notes) {
            $notes = $request->notes;
        } else {
            $notes = '';
        }

        $count = 0;

        foreach ($user->cart->products as $product) {

            if ($product->pivot->product_type == 0) {

                if ($product->pivot->stock > intval(Stock::find($product->pivot->stock_id)->stock)) {
                    $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
                    $count = $count + 1;
                }
            } else {

                if ($product->pivot->stock > intval(Astock::find($product->pivot->stock_id)->stock)) {
                    $user->cart->products()->wherePivot('stock_id', $product->pivot->stock_id)->detach();
                    $count = $count + 1;
                }
            }
        }


        if ($count > 0) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'هناك منتجات ليس بها مخزون كافي لعمل الطلب يرجى مراجعة الكميات المتاحه في المخزون مع العلم انه تم حذف هذه المنتجات من سلة مشترياتك');
            } else {

                session()->flash('success', 'There are products that do not have enough stock to make the order, please check the available quantities in stock');
            }


            return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }

        if ($user->cart->products->count() <= 0) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'سلة مشترياتك فارغة لا يمكنك من اتمام الطلب في الوقت الحالي');
            } else {

                session()->flash('success', 'Your cart is empty. You cannot complete your order at this time');
            }


            return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }


        foreach ($user->cart->products as $product1) {


            if ($product1->pivot->vendor_price != $product1->vendor_price) {


                $user->cart->products()->wherePivot('stock_id', $product1->pivot->stock_id)->detach();


                if (app()->getLocale() == 'ar') {

                    session()->flash('success', 'تم تحديث بعض أسعار المنتجات الموجودة بسلة مشترياتك يرجى مراجعة الطلب مرة أخرى');
                } else {

                    session()->flash('success', 'Some prices of the products in your cart have been updated, please check the order again');
                }


                return redirect()->route('cart', ['lang' => app()->getLocale(), 'user' => $user->id]);
            }
        }




        $this->attach_order($request, $user, $notes);

        if (app()->getLocale() == 'ar') {

            session()->flash('success', 'تم عمل الطلب بنجاح');
        } else {

            session()->flash('success', 'Order added successfully');
        }

        return redirect()->route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $user->id]);
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
    public function edit($lang, Order $order, Request $request)
    {


        $user = User::find($request->user);

        $categories = Category::with('products')->get();

        $orders = $user->orders()->with('products')->paginate(100);

        return view('dashboard.orders.edit', compact('user', 'categories', 'order', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($lang, Request $request, order $order)
    {


        $user = User::find($request->user);



        $request->validate([
            'products' => 'required|array',
            'address_id' => 'required|string',
            'status' => 'required|string',
        ]);


        $count = 0;

        foreach ($request->products as $key => $product) {
            $product = Product::find($key);
            if ($product->stock <= '0') {
                $count = $count + 1;
            }
        }

        if ($count > 0) {

            if (app()->getLocale() == 'ar') {

                session()->flash('success', 'هناك منتجات ليس بها مخزون كافي لعمل الطلب يرجى مراجعة الكميات المتاحه في المخزون');
            } else {

                session()->flash('success', 'There are products that do not have enough stock to make the order, please check the available quantities in stock');
            }

            $categories = Category::with('products')->get();

            $orders = $user->orders()->with('products')->paginate(100);

            return view('dashboard.orders.edit', compact('user', 'categories', 'order', 'orders'));
        }


        if ($request->notes) {
            $notes = $request->notes;
        } else {
            $notes = '';
        }


        $this->detach_order($order);

        $this->attach_order($request, $user, $notes);


        session()->flash('success', 'order updated successfully');



        return redirect()->route('all_orders.index', app()->getLocale());
    }





    private function attach_order($request, $user, $notes)
    {

        $shipping = ShippingRate::find($request->shipping)->cost;




        $order = $user->orders()->create([
            'total_price' => 0,
            'total_commission' => 0,
            'total_profit' => 0,
            'address' => $request->address,
            'house' => $request->house,
            'special_mark' => $request->special_mark,
            'status' => 'pending',
            'client_name' => $request->name,
            'client_phone' => $request->phone1,
            'phone2' => $request->phone2,
            'notes' => $notes,
            'country_id' => $user->country->id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'shipping_rate_id' => $request->shipping,
            'shipping' => $shipping,
        ]);



        $total_price = 0;


        foreach ($user->cart->products as $product) {




            $order->products()->attach($product->id, ['stock_id' => $product->pivot->stock_id, 'stock' => $product->pivot->stock, 'price' => $product->pivot->price, 'vendor_price' => $product->vendor_price, 'commission_for_item' => $product->pivot->price - $product->price, 'profit_for_item' => $product->price - $product->vendor_price, 'total' => ($product->pivot->price * $product->pivot->stock), 'commission' => ($product->pivot->price - $product->min_price) * $product->pivot->stock, 'product_type' => $product->pivot->product_type]);


            $total_price += ($product->vendor_price * $product->pivot->stock);

            $vorder = $product->user->vorders()->create([
                'total_price' => $total_price,
                'status' => 'pending',
                'order_id' => $order->id,
                'country_id' => $user->country->id,
                'user_id' => $product->user->id,
                'user_name' => $product->user->name,
            ]);


            $vorder->products()->attach($product->id, ['stock_id' => $product->pivot->stock_id, 'stock' => $product->pivot->stock, 'price' => $product->vendor_price, 'total' => ($product->vendor_price * $product->pivot->stock)]);


            $balance1 = Balance::where('user_id', $product->user->id)->first();

            $balance1->update([
                'outstanding_balance' => $balance1->outstanding_balance  + $total_price,
            ]);


            $request_ar =  'إضافة الى الرصيد المعلق';
            $request_en =  'add to outstanding balance';


            $requset1 = AppRequest::create([
                'user_id' => $vorder->user->id,
                'balance_id' => $balance1->id,
                'order_id' => $vorder->id,
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => '+ ' . $total_price,
            ]);


            $total_price = 0;
        }



        $total_price = 0;
        $total_commission = 0;
        $total_profit = 0;

        foreach ($user->cart->products as $product) {

            $total_price += ($product->pivot->price * $product->pivot->stock);
            $total_commission += ($product->pivot->price - $product->min_price) * $product->pivot->stock;
            $total_profit += ($product->min_price - $product->vendor_price) * $product->pivot->stock;

            if ($product->pivot->product_type == '0') {

                $product->stocks->find($product->pivot->stock_id)->update([
                    'stock' => $product->stocks->find($product->pivot->stock_id)->stock - $product->pivot->stock
                ]);
            } else {

                $product->astocks->find($product->pivot->stock_id)->update([
                    'stock' => $product->astocks->find($product->pivot->stock_id)->stock - $product->pivot->stock
                ]);
            }
        } //end of foreach


        $order->update([
            'total_price' => $total_price,
            'total_commission' => $total_commission,
            'total_profit' => $total_profit,

        ]);

        $balance = Balance::where('user_id', $user->id)->first();

        $mystock_price = 0;



        foreach ($user->cart->products as $product) {
            if ($product->pivot->product_type != '0') {
                $mystock_price += ($product->min_price * $product->pivot->stock);
            }
        }


        $balance->update([
            'outstanding_balance' => $balance->outstanding_balance  + $order->total_commission + $mystock_price,
        ]);

        foreach ($user->cart->products as $product) {

            $user->cart->products()->detach();
        }


        $request_ar =  'إضافة الى الرصيد المعلق';
        $request_en =  'add to outstanding balance';


        $requset1 = AppRequest::create([
            'user_id' => $order->user->id,
            'balance_id' => $balance->id,
            'order_id' => $order->id,
            'request_ar' => $request_ar,
            'request_en' => $request_en,
            'balance' => '+ ' . ($order->total_commission + $mystock_price),
        ]);



        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();



        foreach ($users as $user1) {


            $title_ar = 'يوجد طلب جديد';
            $body_ar = 'تم اضافة طلب جديد من  : ' . $user->name;
            $title_en = 'There is a new order';
            $body_en  = 'A new order has been added from : ' . $user->name;

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
                'url' =>  route('all_orders.index', ['lang' => app()->getLocale()]),
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
                'url' =>  route('all_orders.index', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user1->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }
    } //end of attach order

    private function detach_order($order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        } //end of for each

        $order->forceDelete();
    } //end of detach orderupdateStatusAll



    public function updateStatusAllVendors($lang, Request $request)
    {

        $request->validate([

            'status' => "required|string|max:255",
            'checkAll' => "required|array",

        ]);



        foreach ($request->checkAll as $order) {


            $order = Vorder::find($order);


            if ($order->status == "Waiting for the order amount to be released") {

                if ($order->status == $request->status) {
                } else {



                    $order->update([
                        'status' => $request->status,
                    ]);






                    $balance1 = Balance::where('user_id', $order->user->id)->first();

                    $balance1->update([
                        'outstanding_balance' => $balance1->outstanding_balance  - $order->total_price,
                        'available_balance' => $balance1->available_balance  + $order->total_price,

                    ]);
                }


                switch ($order->status) {
                    case "pending":
                        $status_en = "pending";
                        $status_ar = "معلق";
                        break;
                    case "confirmed":
                        $status_en = "confirmed";
                        $status_ar = "مؤكد";
                        break;
                    case "on the way":
                        $status_en = "on the way";
                        $status_ar = "في الطريق";
                        break;
                    case "delivered":
                        $status_en = "delivered";
                        $status_ar = "تم تحرير مبلغ الطلب";
                        break;
                    case "canceled":
                        $status_en = "canceled";
                        $status_ar = "ملغي";
                        break;
                    case "in the mandatory period":
                        $status_en = "in the mandatory period";
                        $status_ar = "تم التسليم وفي المدة الاجبارية";
                        break;
                    case "returned":
                        $status_en = "returned";
                        $status_ar = "مرتجع";
                        break;
                    case "Waiting for the order amount to be released":
                        $status_en = "Waiting for the order amount to be released";
                        $status_ar = "في انتظار تحرير مبلغ الطلب";
                        break;

                    default:
                        break;
                }


                $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
                $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


                $requset1 = AppRequest::create([
                    'user_id' => $order->user->id,
                    'balance_id' => $balance1->id,
                    'order_id' => $order->id,
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '+ ' . $order->total_price,
                ]);




                $title_ar = 'اشعار من الإدارة';
                $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
                $title_en = 'Notification From Admin';
                $body_en  = "Your order status has been changed to " . $status_en;


                $notification1 = Notification::create([
                    'user_id' => $order->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $order->updated_at,
                    'status' => 0,
                    'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [
                    'notification_id' => $notification1->id,
                    'user_id' => $order->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $order->user->id, 'notification' => $notification1->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }
            }
        }




        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        } else {
            session()->flash('success', 'request updated successfully');
        }


        return redirect()->route('orders-all-vendors', app()->getLocale());
    }

    public function updateStatusAll($lang, Request $request)
    {




        $request->validate([

            'status' => "required|string|max:255",
            'checkAll' => "required|array",

        ]);



        foreach ($request->checkAll as $order) {


            $order = Order::find($order);


            if ($order->status == $request->status) {
            } else {



                if (($request->status == 'returned' && $order->status == 'pending') || ($request->status == 'returned' && $order->status == 'confirmed') || ($request->status == 'returned' && $order->status == 'on the way') || ($request->status == 'returned' && $order->status == 'in the mandatory period')) {



                    if (app()->getLocale() == 'ar') {
                        session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
                    } else {
                        session()->flash('success', 'The status of the order cannot be changed');
                    }


                    return redirect()->route('all_orders.index', app()->getLocale());
                }


                if ($order->status == 'delivered' && $request->status != 'returned') {



                    if (app()->getLocale() == 'ar') {
                        session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
                    } else {
                        session()->flash('success', 'The status of the order cannot be changed');
                    }


                    return redirect()->route('all_orders.index', app()->getLocale());
                }


                if ($order->status == 'returned' || $order->status == 'canceled' || $order->status == 'RTO') {



                    if (app()->getLocale() == 'ar') {
                        session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
                    } else {
                        session()->flash('success', 'The status of the order cannot be changed');
                    }


                    return redirect()->route('all_orders.index', app()->getLocale());
                }

                if ((($order->status == 'returned' || $order->status == 'RTO')  && $request->status == 'canceled') || (($order->status == 'canceled' || $order->status == 'RTO')  && $request->status == 'returned') || (($order->status == 'canceled' || $order->status == 'returned')  && $request->status == 'RTO')) {



                    if (app()->getLocale() == 'ar') {
                        session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
                    } else {
                        session()->flash('success', 'The status of the order cannot be changed');
                    }


                    return redirect()->route('all_orders.index', app()->getLocale());
                }



                if ((($request->status == 'canceled' || $request->status == 'RTO') && $order->status == 'delivered')) {



                    if (app()->getLocale() == 'ar') {
                        session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
                    } else {
                        session()->flash('success', 'The status of the order cannot be changed');
                    }


                    return redirect()->route('all_orders.index', app()->getLocale());
                }


                $order->update([
                    'status' => $request->status,
                ]);


                switch ($order->status) {
                    case "pending":
                        $status_en = "pending";
                        $status_ar = "معلق";
                        break;
                    case "confirmed":
                        $status_en = "confirmed";
                        $status_ar = "مؤكد";
                        break;
                    case "on the way":
                        $status_en = "on the way";
                        $status_ar = "في الطريق";
                        break;
                    case "delivered":
                        $status_en = "delivered";
                        $status_ar = "تم تحرير مبلغ الطلب";
                        break;
                    case "canceled":
                        $status_en = "canceled";
                        $status_ar = "ملغي";
                        break;
                    case "in the mandatory period":
                        $status_en = "in the mandatory period";
                        $status_ar = "تم التسليم وفي المدة الاجبارية";
                        break;
                    case "returned":
                        $status_en = "returned";
                        $status_ar = "مرتجع";
                        break;
                    case "RTO":
                        $status_en = "RTO";
                        $status_ar = "فشل في التوصيل";
                        break;
                    default:
                        break;
                }




                $title_ar = 'اشعار من الإدارة';
                $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
                $title_en = 'Notification From Admin';
                $body_en  = "Your order status has been changed to " . $status_en;

                $description_ar = "تم تغيير حالة الطلب الى " . $status_ar . ' طلب رقم ' . ' #' . $order->id;
                $description_en  = "order status has been changed to " . $status_en . ' order No ' . ' #' . $order->id;

                $log = Log::create([

                    'user_id' => Auth::id(),
                    'user_type' => 'admin',
                    'log_type' => 'orders',
                    'description_ar' => $description_ar,
                    'description_en' => $description_en,

                ]);



                $notification1 = Notification::create([
                    'user_id' => $order->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $order->updated_at,
                    'status' => 0,
                    'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
                ]);



                $date =  Carbon::now();
                $interval = $notification1->created_at->diffForHumans($date);

                $data = [
                    'notification_id' => $notification1->id,
                    'user_id' => $order->user->id,
                    'user_name'  => Auth::user()->name,
                    'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                    'title_ar' => $title_ar,
                    'body_ar' => $body_ar,
                    'title_en' => $title_en,
                    'body_en' => $body_en,
                    'date' => $interval,
                    'status' => $notification1->status,
                    'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
                    'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $order->user->id, 'notification' => $notification1->id]),

                ];


                try {
                    event(new NewNotification($data));
                } catch (Exception $e) {
                }





                if ($request->status == 'canceled' || $request->status == 'RTO') {



                    foreach ($order->vorders as $vorder) {


                        $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                        $balance1->update([
                            'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
                        ]);

                        $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
                        $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


                        $requset1 = AppRequest::create([
                            'user_id' => $vorder->user->id,
                            'balance_id' => $balance1->id,
                            'order_id' => $vorder->id,
                            'request_ar' => $request_ar,
                            'request_en' => $request_en,
                            'balance' => '- ' . $vorder->total_price,
                        ]);
                    } //end of foreach


                    foreach ($order->products as $product) {
                        if ($product->pivot->product_type == '0') {
                            $product->stocks->find($product->pivot->stock_id)->update([
                                'stock' => $product->stocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                            ]);
                        } else {
                            $product->astocks->find($product->pivot->stock_id)->update([
                                'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                            ]);
                        }
                    }

                    $mystock_price = 0;

                    foreach ($order->products as $product) {
                        if ($product->pivot->product_type != '0') {
                            $mystock_price += ($product->min_price * $product->pivot->stock);
                        }
                    }

                    $balance = Balance::where('user_id', $order->user->id)->first();

                    $balance->update([
                        'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission - $mystock_price,
                    ]);


                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
                    $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $order->user->id,
                        'balance_id' => $balance->id,
                        'order_id' => $order->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '- ' . ($order->total_commission + $mystock_price),
                    ]);
                }



                if ($request->status == 'returned') {



                    foreach ($order->vorders as $vorder) {



                        if ($vorder->status == 'Waiting for the order amount to be released') {

                            $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                            $balance1->update([
                                'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
                            ]);


                            $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
                            $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


                            $requset1 = AppRequest::create([
                                'user_id' => $vorder->user->id,
                                'balance_id' => $balance1->id,
                                'order_id' => $vorder->id,
                                'request_ar' => $request_ar,
                                'request_en' => $request_en,
                                'balance' => '- ' . $vorder->total_price,
                            ]);
                        } else {



                            $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                            $balance1->update([
                                'available_balance' => $balance1->available_balance  - $vorder->total_price,
                            ]);

                            $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
                            $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


                            $requset1 = AppRequest::create([
                                'user_id' => $vorder->user->id,
                                'balance_id' => $balance1->id,
                                'order_id' => $vorder->id,
                                'request_ar' => $request_ar,
                                'request_en' => $request_en,
                                'balance' => '- ' . $vorder->total_price,
                            ]);
                        }
                    } //end of foreach


                    foreach ($order->products as $product) {

                        if ($product->pivot->product_type == '0') {
                            $product->stocks->find($product->pivot->stock_id)->update([
                                'stock' => $product->stocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                            ]);
                        } else {
                            $product->astocks->find($product->pivot->stock_id)->update([
                                'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                            ]);
                        }
                    }

                    $mystock_price = 0;

                    foreach ($order->products as $product) {
                        if ($product->pivot->product_type != '0') {
                            $mystock_price += ($product->min_price * $product->pivot->stock);
                        }
                    }

                    $balance = Balance::where('user_id', $order->user->id)->first();

                    $balance->update([
                        'available_balance' => $balance->available_balance - $order->total_commission - $mystock_price,
                    ]);

                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
                    $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $order->user->id,
                        'balance_id' => $balance->id,
                        'order_id' => $order->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '- ' . ($order->total_commission + $mystock_price),
                    ]);
                }


                if ($request->status == 'delivered') {


                    $mystock_price = 0;

                    foreach ($order->products as $product) {
                        if ($product->pivot->product_type != '0') {
                            $mystock_price += ($product->min_price * $product->pivot->stock);
                        }
                    }

                    $balance = Balance::where('user_id', $order->user->id)->first();

                    $balance->update([
                        'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission - $mystock_price,
                        'available_balance' => $balance->available_balance  + $order->total_commission + $mystock_price,
                    ]);



                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
                    $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $order->user->id,
                        'balance_id' => $balance->id,
                        'order_id' => $order->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '+ ' . ($order->total_commission + $mystock_price),
                    ]);
                }




                foreach ($order->vorders as $vorder) {

                    if ($request->status == 'delivered') {
                        $vorder->update([
                            'status' => 'Waiting for the order amount to be released',
                        ]);
                    } else {

                        $vorder->update([
                            'status' => $request->status,
                        ]);
                    }



                    switch ($vorder->status) {
                        case "pending":
                            $status_en = "pending";
                            $status_ar = "معلق";
                            break;
                        case "confirmed":
                            $status_en = "confirmed";
                            $status_ar = "مؤكد";
                            break;
                        case "on the way":
                            $status_en = "on the way";
                            $status_ar = "في الطريق";
                            break;
                        case "delivered":
                            $status_en = "delivered";
                            $status_ar = "تم تحرير مبلغ الطلب";
                            break;
                        case "canceled":
                            $status_en = "canceled";
                            $status_ar = "ملغي";
                            break;
                        case "in the mandatory period":
                            $status_en = "in the mandatory period";
                            $status_ar = "تم التسليم وفي المدة الاجبارية";
                            break;
                        case "returned":
                            $status_en = "returned";
                            $status_ar = "مرتجع";
                            break;
                        case "Waiting for the order amount to be released":
                            $status_en = "Waiting for the order amount to be released";
                            $status_ar = "في انتظار تحرير مبلغ الطلب";
                            break;
                        case "RTO":
                            $status_en = "RTO";
                            $status_ar = "فشل في التوصيل";
                            break;
                        default:
                            break;
                    }




                    $title_ar = 'اشعار من الإدارة';
                    $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
                    $title_en = 'Notification From Admin';
                    $body_en  = "Your order status has been changed to " . $status_en;


                    $notification1 = Notification::create([
                        'user_id' => $vorder->user->id,
                        'user_name'  => Auth::user()->name,
                        'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                        'title_ar' => $title_ar,
                        'body_ar' => $body_ar,
                        'title_en' => $title_en,
                        'body_en' => $body_en,
                        'date' => $vorder->updated_at,
                        'status' => 0,
                        'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
                    ]);



                    $date =  Carbon::now();
                    $interval = $notification1->created_at->diffForHumans($date);

                    $data = [
                        'notification_id' => $notification1->id,
                        'user_id' => $vorder->user->id,
                        'user_name'  => Auth::user()->name,
                        'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                        'title_ar' => $title_ar,
                        'body_ar' => $body_ar,
                        'title_en' => $title_en,
                        'body_en' => $body_en,
                        'date' => $interval,
                        'status' => $notification1->status,
                        'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
                        'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $vorder->user->id, 'notification' => $notification1->id]),

                    ];



                    try {
                        event(new NewNotification($data));
                    } catch (Exception $e) {
                    }
                } //end of foreach

            }
        }











        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        } else {
            session()->flash('success', 'request updated successfully');
        }


        return redirect()->route('all_orders.index', app()->getLocale());
    }


    public function updateStatusForVendors($lang, Request $request, Vorder $vorder)
    {



        $request->validate([

            'status' => "required|string|max:255",

        ]);

        $vorder->update([
            'status' => $request->status,
        ]);


        switch ($vorder->status) {
            case "pending":
                $status_en = "pending";
                $status_ar = "معلق";
                break;
            case "confirmed":
                $status_en = "confirmed";
                $status_ar = "مؤكد";
                break;
            case "on the way":
                $status_en = "on the way";
                $status_ar = "في الطريق";
                break;
            case "delivered":
                $status_en = "delivered";
                $status_ar = "تم تحرير مبلغ الطلب";
                break;
            case "canceled":
                $status_en = "canceled";
                $status_ar = "ملغي";
                break;
            case "in the mandatory period":
                $status_en = "in the mandatory period";
                $status_ar = "تم التسليم وفي المدة الاجبارية";
                break;
            case "returned":
                $status_en = "returned";
                $status_ar = "مرتجع";
                break;
            case "Waiting for the order amount to be released":
                $status_en = "Waiting for the order amount to be released";
                $status_ar = "في انتظار تحرير مبلغ الطلب";
                break;

            default:
                break;
        }




        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $status_en;


        $notification1 = Notification::create([
            'user_id' => $vorder->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $vorder->updated_at,
            'status' => 0,
            'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $vorder->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $vorder->user->id, 'notification' => $notification1->id]),

        ];


        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }






        $balance1 = Balance::where('user_id', $vorder->user->id)->first();

        $balance1->update([
            'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
            'available_balance' => $balance1->available_balance  + $vorder->total_price,

        ]);


        $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
        $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


        $requset1 = AppRequest::create([
            'user_id' => $vorder->user->id,
            'balance_id' => $balance1->id,
            'order_id' => $vorder->id,
            'request_ar' => $request_ar,
            'request_en' => $request_en,
            'balance' => '+ ' . $vorder->total_price,
        ]);



        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        } else {
            session()->flash('success', 'request updated successfully');
        }


        return redirect()->route('orders-all-vendors', app()->getLocale());
    }

    public function updateStatus($lang, Request $request, Order $order)
    {



        $request->validate([

            'status' => "required|string|max:255",

        ]);



        if (($request->status == 'returned' && $order->status == 'pending') || ($request->status == 'returned' && $order->status == 'confirmed') || ($request->status == 'returned' && $order->status == 'on the way') || ($request->status == 'returned' && $order->status == 'in the mandatory period')) {



            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
            } else {
                session()->flash('success', 'The status of the order cannot be changed');
            }


            return redirect()->route('all_orders.index', app()->getLocale());
        }



        if ($order->status == 'delivered' && $request->status != 'returned') {



            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
            } else {
                session()->flash('success', 'The status of the order cannot be changed');
            }


            return redirect()->route('all_orders.index', app()->getLocale());
        }



        if ((($request->status == 'canceled' || $request->status == 'RTO')  && $order->status == 'delivered')) {



            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'لا يمكن تغيير حالة الطلب ');
            } else {
                session()->flash('success', 'The status of the order cannot be changed');
            }


            return redirect()->route('all_orders.index', app()->getLocale());
        }











        $order->update([
            'status' => $request->status,
        ]);


        switch ($order->status) {
            case "pending":
                $status_en = "pending";
                $status_ar = "معلق";
                break;
            case "confirmed":
                $status_en = "confirmed";
                $status_ar = "مؤكد";
                break;
            case "on the way":
                $status_en = "on the way";
                $status_ar = "في الطريق";
                break;
            case "delivered":
                $status_en = "delivered";
                $status_ar = "تم تحرير مبلغ الطلب";
                break;
            case "canceled":
                $status_en = "canceled";
                $status_ar = "ملغي";
                break;
            case "in the mandatory period":
                $status_en = "in the mandatory period";
                $status_ar = "تم التسليم وفي المدة الاجبارية";
                break;
            case "returned":
                $status_en = "returned";
                $status_ar = "مرتجع";
                break;
            case "RTO":
                $status_en = "RTO";
                $status_ar = "فشل في التوصيل";
                break;


            default:
                break;
        }


        $description_ar = "تم تغيير حالة الطلب الى " . $status_ar . ' طلب رقم ' . ' #' . $order->id;
        $description_en  = "order status has been changed to " . $status_en . ' order No ' . ' #' . $order->id;

        $log = Log::create([

            'user_id' => Auth::id(),
            'user_type' => 'admin',
            'log_type' => 'orders',
            'description_ar' => $description_ar,
            'description_en' => $description_en,

        ]);




        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
        $title_en = 'Notification From Admin';
        $body_en  = "Your order status has been changed to " . $status_en;



        $notification1 = Notification::create([
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $order->updated_at,
            'status' => 0,
            'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $order->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $order->user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $order->user->id, 'notification' => $notification1->id]),

        ];


        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }






        if ($request->status == 'canceled' || $request->status == 'RTO') {



            foreach ($order->vorders as $vorder) {


                $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                $balance1->update([
                    'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
                ]);


                $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
                $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


                $requset1 = AppRequest::create([
                    'user_id' => $vorder->user->id,
                    'balance_id' => $balance1->id,
                    'order_id' => $vorder->id,
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '- ' . $vorder->total_price,
                ]);
            } //end of foreach


            foreach ($order->products as $product) {

                if ($product->pivot->product_type == '0') {
                    $product->stocks->find($product->pivot->stock_id)->update([
                        'stock' => $product->stocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                    ]);
                } else {
                    $product->astocks->find($product->pivot->stock_id)->update([
                        'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                    ]);
                }
            }


            $mystock_price = 0;

            foreach ($order->products as $product) {
                if ($product->pivot->product_type != '0') {
                    $mystock_price += ($product->min_price * $product->pivot->stock);
                }
            }

            $balance = Balance::where('user_id', $order->user->id)->first();

            $balance->update([
                'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission - $mystock_price,
            ]);



            $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
            $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


            $requset1 = AppRequest::create([
                'user_id' => $order->user->id,
                'balance_id' => $balance->id,
                'order_id' => $order->id,
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => '- ' . ($order->total_commission + $mystock_price),
            ]);
        }




        if ($request->status == 'returned') {



            foreach ($order->vorders as $vorder) {

                if ($vorder->status == 'Waiting for the order amount to be released') {

                    $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                    $balance1->update([
                        'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
                    ]);


                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المعلق';
                    $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Outstanding balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $vorder->user->id,
                        'balance_id' => $balance1->id,
                        'order_id' => $vorder->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '- ' . $vorder->total_price,
                    ]);
                } else {

                    $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                    $balance1->update([
                        'available_balance' => $balance1->available_balance  - $vorder->total_price,
                    ]);


                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
                    $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $vorder->user->id,
                        'balance_id' => $balance1->id,
                        'order_id' => $vorder->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '- ' . $vorder->total_price,
                    ]);
                }
            } //end of foreach


            foreach ($order->products as $product) {
                if ($product->pivot->product_type == '0') {
                    $product->stocks->find($product->pivot->stock_id)->update([
                        'stock' => $product->stocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                    ]);
                } else {
                    $product->astocks->find($product->pivot->stock_id)->update([
                        'stock' => $product->astocks->find($product->pivot->stock_id)->stock + $product->pivot->stock
                    ]);
                }
            }


            $mystock_price = 0;

            foreach ($order->products as $product) {
                if ($product->pivot->product_type != '0') {
                    $mystock_price += ($product->min_price * $product->pivot->stock);
                }
            }

            $balance = Balance::where('user_id', $order->user->id)->first();

            $balance->update([
                'available_balance' => $balance->available_balance - $order->total_commission - $mystock_price,
            ]);


            $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
            $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


            $requset1 = AppRequest::create([
                'user_id' => $order->user->id,
                'balance_id' => $balance->id,
                'order_id' => $order->id,
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => '- ' . ($order->total_commission + $mystock_price),
            ]);
        }


        if ($request->status == 'delivered') {


            $mystock_price = 0;

            foreach ($order->products as $product) {
                if ($product->pivot->product_type != '0') {
                    $mystock_price += ($product->min_price * $product->pivot->stock);
                }
            }

            $balance = Balance::where('user_id', $order->user->id)->first();

            $balance->update([
                'outstanding_balance' => $balance->outstanding_balance  - $order->total_commission - $mystock_price,
                'available_balance' => $balance->available_balance  + $order->total_commission + $mystock_price,
            ]);


            $request_ar = 'تم تغيير حالة الطلب الى : ' .  $status_ar . ' - ' . 'تعديل على الرصيد المتاح';
            $request_en = 'Order status changed to : ' . $status_en . ' - ' . 'Available balance change';


            $requset1 = AppRequest::create([
                'user_id' => $order->user->id,
                'balance_id' => $balance->id,
                'order_id' => $order->id,
                'request_ar' => $request_ar,
                'request_en' => $request_en,
                'balance' => '+ ' . ($order->total_commission + $mystock_price),
            ]);
        }





        foreach ($order->vorders as $vorder) {

            if ($request->status == 'delivered') {
                $vorder->update([
                    'status' => 'Waiting for the order amount to be released',
                ]);
            } else {

                $vorder->update([
                    'status' => $request->status,
                ]);
            }



            switch ($vorder->status) {
                case "pending":
                    $status_en = "pending";
                    $status_ar = "معلق";
                    break;
                case "confirmed":
                    $status_en = "confirmed";
                    $status_ar = "مؤكد";
                    break;
                case "on the way":
                    $status_en = "on the way";
                    $status_ar = "في الطريق";
                    break;
                case "delivered":
                    $status_en = "delivered";
                    $status_ar = "تم تحرير مبلغ الطلب";
                    break;
                case "canceled":
                    $status_en = "canceled";
                    $status_ar = "ملغي";
                    break;
                case "in the mandatory period":
                    $status_en = "in the mandatory period";
                    $status_ar = "تم التسليم وفي المدة الاجبارية";
                    break;
                case "returned":
                    $status_en = "returned";
                    $status_ar = "مرتجع";
                    break;
                case "Waiting for the order amount to be released":
                    $status_en = "Waiting for the order amount to be released";
                    $status_ar = "في انتظار تحرير مبلغ الطلب";
                    break;
                case "RTO":
                    $status_en = "RTO";
                    $status_ar = "فشل في التوصيل";
                    break;

                default:
                    break;
            }




            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم تغيير حالة الطلب الخاص بك الى " . $status_ar;
            $title_en = 'Notification From Admin';
            $body_en  = "Your order status has been changed to " . $status_en;


            $notification1 = Notification::create([
                'user_id' => $vorder->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $vorder->updated_at,
                'status' => 0,
                'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $vorder->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => $vorder->user->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $vorder->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        } //end of foreach




        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم تحديث حالة الطلب بنجاح');
        } else {
            session()->flash('success', 'request updated successfully');
        }


        return redirect()->route('all_orders.index', app()->getLocale());
    }
}
