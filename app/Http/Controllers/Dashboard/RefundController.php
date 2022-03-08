<?php

namespace App\Http\Controllers\Dashboard;

use App\Balance;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\Prefund;
use App\Product;
use App\Refund;
use App\Request as AppRequest;
use App\ShippingRate;
use App\User;
use App\Vorder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function sendRequest($lang, Request $request, Order $order, User $user)
    {



        $request->validate([

            'reason' => "required|string",

        ]);


        $rerturn = Refund::create([

            'user_id' => $user->id,
            'order_id' => $order->id,
            'reason' => $request->reason,

        ]);



        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();



        foreach ($users as $user1) {


            $title_ar = 'يوجد طلب مرتجع جديد';
            $body_ar = 'تم اضافة طلب مرتجع جديد من  : ' . $user->name;
            $title_en = 'There is a new refund request';
            $body_en  = 'A new refund request has been added from : ' . $user->name;

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
                'url' =>  route('admin.refunds', ['lang' => app()->getLocale()]),
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
                'url' =>  route('admin.refunds', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user1->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }






        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم ارسال الطلب بنجاح');
        } else {
            session()->flash('success', 'Request sent successfully');
        }






        return redirect()->route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $user->id]);
    }


    public function sendPrequest($lang, Request $request, Product $product, User $user, Order $order)
    {



        $request->validate([

            'reason' => "required|string",
            'quantity' => "required|string"

        ]);


        $product1 = $order->products->where('id', $product->id)->first();






        if ($request->quantity <= '0' || $request->quantity > $product1->pivot->stock) {

            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'الكمية المطلوبة لعمل طلب المرتجع غير صحيحة');
            } else {
                session()->flash('success', 'The quantity required to make the refund request is incorrect');
            }

            return redirect()->route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $user->id]);
        }


        $return = Prefund::create([

            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'stock_id' => $product1->pivot->stock_id,
            'reason' => $request->reason,
            'quantity' => $request->quantity,


        ]);


        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'vendor')
                ->where('name', '!=', 'affiliate');
        })->get();



        foreach ($users as $user1) {


            $title_ar = 'يوجد طلب مرتجع جزئي جديد';
            $body_ar = 'تم اضافة طلب مرتجع جزئي جديد من  : ' . $user->name;
            $title_en = 'There is a new partial refund request';
            $body_en  = 'A new partial refund request has been added from : ' . $user->name;

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
                'url' =>  route('admin.prefunds', ['lang' => app()->getLocale()]),
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
                'url' =>  route('admin.prefunds', ['lang' => app()->getLocale()]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $user1->id, 'notification' => $notification1->id]),

            ];

            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }
        }





        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم ارسال الطلب بنجاح');
        } else {
            session()->flash('success', 'Request sent successfully');
        }






        return redirect()->route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $user->id]);
    }


    public function rejectPrefund($lang, Request $request, Order $order, User $user, Product $product, Prefund $prefund)
    {



        $request->validate([

            'reason' => "nullable|string",
            'status' => "required|string"

        ]);











        if ($request->status == '1') {

            $prefund->update([

                'status' => $request->status,
                'refuse_reason' => $request->reason

            ]);


            $title_ar = 'اشعار من الإدارة';
            $body_ar = "تم رفض طلب المرتجع الخاص بطلبك رقم " . $order->id . ' سبب الرفض : ' . $request->reason;
            $title_en = 'Notification From Admin';
            $body_en  = "Your return request has been rejected "  . $order->id . 'the reason of refuse : ' . $request->reason;


            $notification1 = Notification::create([
                'user_id' => $prefund->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $prefund->updated_at,
                'status' => 0,
                'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $prefund->user->id]),
            ]);



            $date =  Carbon::now();
            $interval = $notification1->created_at->diffForHumans($date);

            $data = [
                'notification_id' => $notification1->id,
                'user_id' => $prefund->user->id,
                'user_name'  => Auth::user()->name,
                'user_image' => asset('storage/images/users/' . Auth::user()->profile),
                'title_ar' => $title_ar,
                'body_ar' => $body_ar,
                'title_en' => $title_en,
                'body_en' => $body_en,
                'date' => $interval,
                'status' => $notification1->status,
                'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $prefund->user->id]),
                'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $prefund->user->id, 'notification' => $notification1->id]),

            ];


            try {
                event(new NewNotification($data));
            } catch (Exception $e) {
            }






            if (app()->getLocale() == 'ar') {
                session()->flash('success', 'تم رفض طلب المرتجع بنجاح ');
            } else {
                session()->flash('success', 'The return request was successfully rejected');
            }






            return redirect()->route('all_orders.index', ['lang' => app()->getLocale()]);
        }


        if ($request->status == '2') {

            if ($order->status == 'delivered') {

                $order1 = $user->orders()->create([
                    'total_price' => 0,
                    'total_commission' => 0,
                    'total_profit' => 0,
                    'address' => $order->address,
                    'house' => $order->house,
                    'special_mark' => $order->special_mark,
                    'status' => 'returned',
                    'client_name' => $order->client_name,
                    'client_phone' => $order->client_phone,
                    'phone2' => $order->phone2,
                    'notes' => $order->notes,
                    'country_id' => $user->country->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'shipping_rate_id' => $order->shipping_rate_id,
                ]);


                $total_price = 0;

                $product1 = $order->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();



                $order1->products()->attach($product->id, ['stock_id' => $prefund->stock_id, 'stock' => $prefund->quantity, 'price' => $product1->pivot->price, 'vendor_price' => $product->vendor_price, 'commission_for_item' => $product1->pivot->commission_for_item, 'profit_for_item' => $product1->pivot->profit_for_item, 'total' => ($product1->pivot->price * $prefund->quantity), 'commission' => ($product1->pivot->price -  $product->min_price) *  $prefund->quantity]);



                $total_price = $product->vendor_price * $prefund->quantity;

                $vorder = $product->user->vorders()->create([
                    'total_price' => $total_price,
                    'status' => 'returned',
                    'order_id' => $order->id,
                    'country_id' => $user->country->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ]);




                $vorder->products()->attach($product->id, ['stock_id' => $prefund->stock_id, 'stock' => $prefund->quantity, 'price' => $product->vendor_price, 'total' => ($product->vendor_price * $prefund->quantity)]);



                if ($vorder->status == 'Waiting for the order amount to be released') {

                    $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                    $balance1->update([
                        'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
                    ]);


                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  'مرتجع' . ' - ' . 'تعديل على الرصيد المعلق';
                    $request_en = 'Order status changed to : ' . 'returned' . ' - ' . 'Outstanding balance change';


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

                    $request_ar = 'تم تغيير حالة الطلب الى : ' .  'مرتجع' . ' - ' . 'تعديل على الرصيد المتاح';
                    $request_en = 'Order status changed to : ' . 'returned' . ' - ' . 'Available balance change';


                    $requset1 = AppRequest::create([
                        'user_id' => $vorder->user->id,
                        'balance_id' => $balance1->id,
                        'order_id' => $vorder->id,
                        'request_ar' => $request_ar,
                        'request_en' => $request_en,
                        'balance' => '- ' . $vorder->total_price,
                    ]);
                }








                $product->stocks->find($prefund->stock_id)->update([
                    'stock' => $product->stocks->find($prefund->stock_id)->stock + $prefund->quantity
                ]);



                $balance = Balance::where('user_id', $order->user->id)->first();

                $balance->update([
                    'available_balance' => $balance->available_balance - (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                ]);

                $request_ar = 'تم تغيير حالة الطلب الى : ' .  'مرتجع' . ' - ' . 'تعديل على الرصيد المتاح';
                $request_en = 'Order status changed to : ' . 'returned' . ' - ' . 'Available balance change';


                $requset1 = AppRequest::create([
                    'user_id' => $order->user->id,
                    'balance_id' => $balance->id,
                    'order_id' => $order->id,
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '- ' . (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                ]);


                $order1->update([
                    'total_price' => ($product1->pivot->price * $prefund->quantity),
                    'total_commission' => (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                    'total_profit' => $product1->pivot->profit_for_item * $prefund->quantity,

                ]);


                $order->update([
                    'total_price' => $order->total_price - $order1->total_price,
                    'total_commission' => $order->total_commission - $order1->total_commission,
                    'total_profit' => $order->total_profit - $order1->total_profit,
                ]);


                $vorder1 = $product->vorders->where('order_id', $order->id)->where('pivot.product_id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();


                $vorder1->update([
                    'total_price' => $vorder1->total_price - $vorder->total_price,

                ]);



                $v1 = $vorder1->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();
                $v2 = $order->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();




                $v1->pivot->total = $vorder->total_price;
                $v1->pivot->stock = $v1->pivot->stock - $prefund->quantity;


                $v2->pivot->total = $v2->pivot->price * $prefund->quantity;
                $v2->pivot->commission_for_item  = $v2->pivot->commission_for_item  * $prefund->quantity;
                $v2->pivot->stock  = $v2->pivot->stock -  $prefund->quantity;


                $v1->pivot->save();
                $v2->pivot->save();


                $prefund->update([
                    'orderid' => $order1->id,
                    'status' => 2
                ]);
            } else {



                $order1 = $user->orders()->create([
                    'total_price' => 0,
                    'total_commission' => 0,
                    'total_profit' => 0,
                    'address' => $order->address,
                    'house' => $order->house,
                    'special_mark' => $order->special_mark,
                    'status' => 'canceled',
                    'client_name' => $order->client_name,
                    'client_phone' => $order->client_phone,
                    'phone2' => $order->phone2,
                    'notes' => $order->notes,
                    'country_id' => $user->country->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'shipping_rate_id' => $order->shipping_rate_id,
                ]);


                $total_price = 0;

                $product1 = $order->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();


                $order1->products()->attach($product->id, ['stock_id' => $prefund->stock_id, 'stock' => $prefund->quantity, 'price' => $product1->pivot->price, 'vendor_price' => $product->vendor_price, 'commission_for_item' => $product1->pivot->commission_for_item, 'profit_for_item' => $product1->pivot->profit_for_item, 'total' => ($product1->pivot->price * $prefund->quantity), 'commission' => ($product1->pivot->price -  $product->min_price) *  $prefund->quantity]);



                $total_price = $product->vendor_price * $prefund->quantity;

                $vorder = $product->user->vorders()->create([
                    'total_price' => $total_price,
                    'status' => 'canceled',
                    'order_id' => $order->id,
                    'country_id' => $user->country->id,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ]);




                $vorder->products()->attach($product->id, ['stock_id' => $prefund->stock_id, 'stock' => $prefund->quantity, 'price' => $product->vendor_price, 'total' => ($product->vendor_price * $prefund->quantity)]);


                $balance1 = Balance::where('user_id', $vorder->user->id)->first();

                $balance1->update([
                    'outstanding_balance' => $balance1->outstanding_balance  - $vorder->total_price,
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


                $product->stocks->find($prefund->stock_id)->update([
                    'stock' => $product->stocks->find($prefund->stock_id)->stock + $prefund->quantity
                ]);



                $balance = Balance::where('user_id', $order->user->id)->first();

                $balance->update([
                    'outstanding_balance' => $balance->outstanding_balance - (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                ]);

                $request_ar = 'تم تغيير حالة الطلب الى : ' .  'ملغي' . ' - ' . 'تعديل على الرصيد المعلق';
                $request_en = 'Order status changed to : ' . 'canceled' . ' - ' . 'Outstanding balance change';


                $requset1 = AppRequest::create([
                    'user_id' => $order->user->id,
                    'balance_id' => $balance->id,
                    'order_id' => $order->id,
                    'request_ar' => $request_ar,
                    'request_en' => $request_en,
                    'balance' => '- ' . (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                ]);


                $order1->update([
                    'total_price' => ($product1->pivot->price * $prefund->quantity),
                    'total_commission' => (($product1->pivot->price -  $product->min_price) *  $prefund->quantity),
                    'total_profit' => $product1->pivot->profit_for_item * $prefund->quantity,

                ]);


                $order->update([
                    'total_price' => $order->total_price - $order1->total_price,
                    'total_commission' => $order->total_commission - $order1->total_commission,
                    'total_profit' => $order->total_profit - $order1->total_profit,
                ]);


                $vorder1 = $product->vorders->where('order_id', $order->id)->where('pivot.product_id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();


                $vorder1->update([
                    'total_price' => $vorder1->total_price - $vorder->total_price,

                ]);


                $v1 = $vorder1->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();
                $v2 = $order->products->where('id', $product->id)->where('pivot.stock_id', $prefund->stock_id)->first();




                $v1->pivot->total = $vorder->total_price;
                $v1->pivot->stock = $v1->pivot->stock - $prefund->quantity;


                $v2->pivot->total = $v2->pivot->price * $prefund->quantity;
                $v2->pivot->commission_for_item  = $v2->pivot->commission_for_item  * $prefund->quantity;
                $v2->pivot->stock  = $v2->pivot->stock -  $prefund->quantity;


                $v1->pivot->save();
                $v2->pivot->save();


                $prefund->update([
                    'orderid' => $order1->id,
                    'status' => 2
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

                default:
                    break;
            }



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
        }


        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم الموافقة على طلب المرتجع');
        } else {
            session()->flash('success', 'Refund request approved');
        }






        return redirect()->route('all_orders.index', ['lang' => app()->getLocale()]);
    }

    public function rejectRequest($lang, Request $request, Order $order, User $user)
    {



        $request->validate([

            'reason' => "required|string",

        ]);


        $refund = $order->refund;


        $refund->update([

            'status' => 1,
            'refuse_reason' => $request->reason

        ]);






        $title_ar = 'اشعار من الإدارة';
        $body_ar = "تم رفض طلب المرتجع الخاص بطلبك رقم " . $order->id . ' سبب الرفض : ' . $request->reason;
        $title_en = 'Notification From Admin';
        $body_en  = "Your return request has been rejected "  . $order->id . 'the reason of refuse : ' . $request->reason;


        $notification1 = Notification::create([
            'user_id' => $refund->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $refund->updated_at,
            'status' => 0,
            'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $refund->user->id]),
        ]);



        $date =  Carbon::now();
        $interval = $notification1->created_at->diffForHumans($date);

        $data = [
            'notification_id' => $notification1->id,
            'user_id' => $refund->user->id,
            'user_name'  => Auth::user()->name,
            'user_image' => asset('storage/images/users/' . Auth::user()->profile),
            'title_ar' => $title_ar,
            'body_ar' => $body_ar,
            'title_en' => $title_en,
            'body_en' => $body_en,
            'date' => $interval,
            'status' => $notification1->status,
            'url' =>  route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => $refund->user->id]),
            'change_status' => route('notification-change', ['lang' => app()->getLocale(), 'user' => $refund->user->id, 'notification' => $notification1->id]),

        ];


        try {
            event(new NewNotification($data));
        } catch (Exception $e) {
        }






        if (app()->getLocale() == 'ar') {
            session()->flash('success', 'تم رفض طلب المرتجع بنجاح ');
        } else {
            session()->flash('success', 'The return request was successfully rejected');
        }






        return redirect()->route('admin.refunds', ['lang' => app()->getLocale()]);
    }
}
