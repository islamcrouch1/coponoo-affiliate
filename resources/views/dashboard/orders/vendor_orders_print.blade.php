<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>coponoo.com | Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">


    @if (app()->getLocale() == 'ar')
        <style>
            .card {
                direction: rtl;
                text-align: right;
            }

            .wrapper {
                direction: rtl;
                text-align: right;
            }

            .content-header {
                direction: rtl;
                text-align: right;
            }

            .content-gummla {
                direction: rtl;
                text-align: right;
            }

        </style>
    @endif
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <img src="{{ asset('storage/images/logo.png') }}" class="" style="width:80px">
                        <small
                            class="{{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">{{ __('Date: ') . $order->created_at }}
                        </small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    {{ __('Merchant Information') }}
                    <address>
                        <strong>coponoo.com</strong><br>
                        {{ __('3, 26th of July Street, second floor, Flat 25, in front of Al-Hawari, Lebanon Square, above the pharmacy, Dr. Amira, Al-Muhandseen') }}<br>
                        {{ __('Phone:') }}<span style="direction: ltr !important">01094666865</span><br>
                        {{ __('Email:') }} info@coponoo.com
                    </address>
                </div>
                <!-- /.col -->

                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>{{ __('Order ID:') . $order->id }} </b><br>
                    <br>
                    {{-- <b></b> 4F3S8J<br>
            <b>Payment Due:</b> 2/22/2014<br>
            <b>Account:</b> 968-34567 --}}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Product name') }}</th>
                                <th>{{ __('SKU') }}</th>
                                <th>{{ __('Color') }}</th>
                                <th>{{ __('Size') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Unitt Price') }}</th>
                                <th>{{ __('Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</td>
                                    <td>{{ $product->SKU }}</td>
                                    <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->color->color_ar: $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                    </td>
                                    <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->size->size_ar: $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                    </td>
                                    <td>{{ $product->pivot->stock }}</td>
                                    <td>{{ $product->vendor_price . ' ' . $order->user->country->currency }}</td>
                                    <td>{{ $product->vendor_price * $product->pivot->stock . ' ' . $order->user->country->currency }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->

                <!-- /.col -->
                <div class="col-6">
                    {{-- <p class="lead">Amount Due 2/22/2014</p> --}}


                    @php
                        $total_price = 0;

                        foreach ($order->products as $product) {
                            $total_price += $product->vendor_price * $product->pivot->stock;
                        } //end of foreach
                    @endphp

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">{{ __('Subtotal:') }}</th>
                                <td>{{ $total_price . ' ' . $order->user->country->currency }}</td>
                            </tr>
                            {{-- <tr>
                        <th>{{__('Shipping:')}}</th>
                        <td>{{$order->shipping_rate->cost . ' ' . $order->user->country->currency}}</td>
                      </tr>
                      <tr>
                        <th>{{__('Total:')}}</th>
                        <td>{{ $order->shipping_rate->cost +  $total_price . ' ' . $order->user->country->currency}}</td>
                      </tr> --}}
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
