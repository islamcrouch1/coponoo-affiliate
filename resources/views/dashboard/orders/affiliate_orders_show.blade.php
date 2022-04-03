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
                                    <strong>coponoo.com</strong><br>
                                    {{ __('3, 26th of July Street, second floor, Flat 25, in front of Al-Hawari, Lebanon Square, above the pharmacy, Dr. Amira, Al-Muhandseen') }}<br>
                                    {{ __('Phone:') }}<span style="direction: ltr !important">01094666865</span><br>
                                    {{ __('Email:') }} info@coponoo.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                {{ __('Client Information') }}
                                <address>
                                    <strong>{{ $order->client_name }}</strong><br>
                                    {{ __('Address:') . $order->address }}<br>
                                    @if ($order->house)
                                        {{ __('House:') . $order->house }}<br>
                                    @endif
                                    @if ($order->special_mark)
                                        {{ __('Special Mark:') . $order->special_mark }}<br>
                                    @endif
                                    {{ __('Phone:') . $order->client_phone }}<br>
                                    @if ($order->phone2)
                                        {{ __('Alternate number:') . $order->phone2 }}<br>
                                    @endif
                                    {{ __('Notes:') . $order->notes }}<br>
                                </address>
                            </div>
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
                                            <th>{{ __('Commission') }}</th>
                                            @if (auth()->user()->HasRole('superadministrator'))
                                                <th>{{ __('Coponoo Commission') }}</th>
                                            @endif

                                            @if (auth()->user()->HasRole('affiliate'))
                                                <th>{{ __('Actions') }}</th>
                                            @endif





                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $product)
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                                    @if ($product->pivot->product_type)
                                                        <span
                                                            class="badge badge-danger badge-lg">{{ __('My stock') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->SKU }}</td>
                                                @if ($product->pivot->product_type == '0')
                                                    <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->color->color_ar: $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                                    </td>
                                                    <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->size->size_ar: $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                                    </td>
                                                @else
                                                    <td>{{ app()->getLocale() == 'ar'? $product->astocks->find($product->pivot->stock_id)->color->color_ar: $product->astocks->find($product->pivot->stock_id)->color->color_en }}
                                                    </td>
                                                    <td>{{ app()->getLocale() == 'ar'? $product->astocks->find($product->pivot->stock_id)->size->size_ar: $product->astocks->find($product->pivot->stock_id)->size->size_en }}
                                                    </td>
                                                @endif
                                                <td>{{ $product->pivot->stock }}</td>
                                                <td>{{ $product->min_price . ' ' . $order->user->country->currency }}
                                                </td>
                                                <td>{{ $product->pivot->price * $product->pivot->stock . ' ' . $order->user->country->currency }}
                                                </td>
                                                <td>{{ ($product->pivot->price - $product->min_price) * $product->pivot->stock .' ' .$order->user->country->currency }}
                                                </td>
                                                @if (auth()->user()->HasRole('superadministrator'))
                                                    <td>{{ $product->pivot->price * $product->pivot->stock -($product->pivot->price - $product->min_price) * $product->pivot->stock -$product->vendor_price * $product->pivot->stock .' ' .$order->user->country->currency }}
                                                    </td>
                                                @endif

                                                @if (auth()->user()->HasRole('affiliate'))
                                                    @if ($product->pivot->product_type == '0')
                                                        @if ($order->status != 'canceled' &&
    $order->status != 'returned' &&
    $order->status != 'pending' &&
    $order->refund == null &&
    $order->prefunds->where('product_id', $product->id)->where('stock_id', $product->pivot->stock_id)->where('status', '0')->count() == 0)
                                                            <td>
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-primary-{{ $product->id }}">
                                                                    {{ __('return request') }}
                                                                </button>
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
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
                                        $total_price += $product->pivot->price * $product->pivot->stock;
                                    } //end of foreach
                                @endphp

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">{{ __('Subtotal:') }}</th>
                                            <td>{{ $total_price . ' ' . $order->user->country->currency }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Shipping:') }}</th>
                                            <td>{{ $order->shipping . ' ' . $order->user->country->currency }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Total:') }}</th>
                                            <td>{{ $order->shipping + $total_price . ' ' . $order->user->country->currency }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="{{ route('orders.affiliate.print', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                                    rel="noopener" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i>{{ __('Print') }}</a>

                                @if (Auth()->user()->HasRole('administrator') ||
    Auth()->user()->HasRole('superadministrator'))
                                    <a type="button" class="btn btn-success"
                                        href="{{ route('all_orders.index', app()->getLocale()) }}"><i
                                            class="far fa-back"></i> {{ __('back to orders') }}
                                    @else
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"><i
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


    @foreach ($order->products as $product)
        <div style="direction: rtl" class="modal fade" id="modal-primary-{{ $product->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div style="direction: ltr" class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">{{ __('Return request for product - ') }}
                            {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }} </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('affiliate.preturn', ['lang' => app()->getLocale(),'product' => $product->id,'user' => $order->user->id,'order' => $order->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="reason"
                                    class="col-md-4 col-form-label">{{ __('Reason for return request') }}</label>

                                <div class="col-md-8">
                                    <input id="reason" type="text"
                                        class="form-control @error('reason') is-invalid @enderror" name="reason"
                                        value="{{ old('reason') }}" autocomplete="reason" autofocus required>

                                    @error('reason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row pr-3">
                                <label for="quantity" class="col-md-4 p-1">{{ __('Enter the quantity') }}</label>

                                <div class="col-md-8">
                                    <input id="quantity" type="number" min="1" max="{{ $product->pivot->stock }}"
                                        class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                        value="1" required>

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light"
                                data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-outline-light">{{ __('Send Request') }}</button>
                        </div>

                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach


@endsection
