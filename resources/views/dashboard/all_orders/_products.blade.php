<div id="print-area">
    <table class="table table-striped projects">

        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name_en }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sale_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3 style="padding:10px; padding-bottom:0px; {{app()->getLocale() == 'ar' ? 'direction:rtl' : ''}}">{{__('Wallet Balance : ')}}<span class="total-price">
        {{ number_format($order->wallet_balance, 2)  . ' ' . $order->country->currency}}
    </span></h3>
    <h3 style="padding:10px; padding-bottom:0px; {{app()->getLocale() == 'ar' ? 'direction:rtl' : ''}}">{{__('Shipping Fee : ')}}<span class="total-price">
        {{ number_format($order->shipping, 2)  . ' ' . $order->country->currency}}
    </span></h3>
    <h3 style="padding:10px; padding-bottom:0px; {{app()->getLocale() == 'ar' ? 'direction:rtl' : ''}}">{{__('Paid Amount : ')}}<span class="total-price">
        {{ number_format($order->total_price, 2) . ' ' . $order->country->currency }}
    </span></h3>



    <div class="card">
        <h5  style="padding:10px" class="card-title">Order status</h5>
        <div class="card-body">
            @switch($order->status)
            @case('recieved')
            <span class="badge badge-success badge-lg">{{__('Awaiting review from management')}}</span>
                @break
            @case("processing")
            <span class="badge badge-warning badge-lg">{{__('Your order is under review')}}</span>
            @break
            @case("shipped")
            <span class="badge badge-info badge-lg">{{__('Your order has been shipped')}}</span>
            @break
            @case("completed")
            <span class="badge badge-primary badge-lg">{{__('You have successfully received your request')}}</span>
            @break
            @case("canceled")
            <span class="badge badge-danger badge-lg">{{__('The order has been canceled')}}</span>
            @break
            @default
            @endswitch
        </div>
    </div>

    <div class="card">
        <h5  style="padding:10px" class="card-title">Order Address</h5>
        <div class="card-body">
            @php
               $address =  $order->address;
            @endphp
            {{$user->country->name_en . '-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}
        </div>
    </div>

</div>




<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i>Print</button>
