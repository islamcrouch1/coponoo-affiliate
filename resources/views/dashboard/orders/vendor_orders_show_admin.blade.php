@extends('layouts.dashboard.app')

@section('adminContent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Orders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Orders') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img src="{{ asset('storage/images/logo.png') }}" class=""
                                        style="width:80px">
                                    <small
                                        class="{{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">{{ __('Date: ') . $order->created_at }}
                                    </small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                {{ __('Merchant Information') }}
                                <address>
                                    <strong>Coponoo.com</strong><br>
                                    {{ __('3, 26th of July Street, second floor, Flat 25, in front of Al-Hawari, Lebanon Square, above the pharmacy, Dr. Amira, Al-Muhandseen') }}<br>
                                    {{ __('Phone:') }}<span style="direction: ltr !important">01094666865</span><br>
                                    {{ __('Email:') }} info@Coponoo.com
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
                                                <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                </td>
                                                <td>{{ $product->SKU }}</td>
                                                <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->color->color_ar: $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                                </td>
                                                <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->size->size_ar: $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                                </td>
                                                <td>{{ $product->pivot->stock }}</td>
                                                <td>{{ $product->vendor_price . ' ' . $order->user->country->currency }}
                                                </td>
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
                        </tr> --}}
                                        {{-- <tr>
                          <th>{{__('Total:')}}</th>
                          <td>{{ $order->shipping_rate->cost +  $total_price . ' ' . $order->user->country->currency}}</td>
                        </tr> --}}
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('orders.vendor.print.admin', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                    rel="noopener" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i>{{ __('Print') }}</a>

                                @if (Auth()->user()->hasRole('administrator') ||
    Auth()->user()->hasRole('superadministrator'))
                                    <a type="button" class="btn btn-success"
                                        href="{{ route('orders-all-vendors', app()->getLocale()) }}"><i
                                            class="far fa-back"></i> {{ __('back to orders') }}
                                    @else
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"><i
                                                class="far fa-back"></i> {{ __('back to orders') }}
                                @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
