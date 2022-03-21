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

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->

        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search" autofocus
                                    placeholder="{{ __('Search by client name or phone') }}" class="form-control"
                                    value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('All Status') }}</option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('pending') }}</option>
                                <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                    {{ __('confirmed') }}</option>
                                <option value="on the way" {{ request()->status == 'on the way' ? 'selected' : '' }}>
                                    {{ __('on the way') }}</option>
                                <option value="delivered"
                                    {{ request()->status == 'compdeliveredleted' ? 'selected' : '' }}>
                                    {{ __('delivered') }}</option>
                                <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                    {{ __('canceled') }}</option>
                                <option value="in the mandatory period"
                                    {{ request()->status == 'in the mandatory period' ? 'selected' : '' }}>
                                    {{ __('in the mandatory period') }}</option>
                                <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                    {{ __('returned') }}</option>
                                <option value="RTO" {{ request()->status == 'RTO' ? 'selected' : '' }}>
                                    {{ __('RTO') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">


                        <h3 class="card-title">{{ __('Orders') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">

                        <div class="row">

                            <div class="col-md-12">
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'pending']) }}">{{ __('pending') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'pending')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'confirmed']) }}">{{ __('confirmed') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'confirmed')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'on the way']) }}">{{ __('on the way') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'on the way')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'in the mandatory period')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'Waiting for the order amount to be released']) }}">{{ __('Waiting for the order amount to be released') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'Waiting for the order amount to be released')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'delivered']) }}">{{ __('delivered') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'delivered')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'canceled']) }}">{{ __('canceled') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'canceled')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'returned']) }}">{{ __('returned') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'returned')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'RTO']) }}">{{ __('RTO') .' ( ' .\App\vOrder::where('user_id', Auth::id())->where('status', 'RTO')->count() .' )' }}</a>
                            </div>

                        </div>

                        @if ($orders->count() > 0)
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>

                                        <th>#id</th>
                                        <th>{{ __('Order Status') }}</th>
                                        <th>{{ __('Total Amount') }}</th>
                                        <th> {{ __('Created At') }}</th>
                                        <th>{{ __('Updated At') }}</th>
                                        <th style="" class="">{{ __('Actions') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>

                                            <td>{{ $order->id }}</td>

                                            <td>

                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning badge-lg">{{ __('pending') }}</span>
                                                    @break

                                                    @case('confirmed')
                                                        <span class="badge badge-primary badge-lg">{{ __('confirmed') }}</span>
                                                    @break

                                                    @case('on the way')
                                                        <span class="badge badge-info badge-lg">{{ __('on the way') }}</span>
                                                    @break

                                                    @case('delivered')
                                                        <span class="badge badge-success badge-lg">{{ __('delivered') }}</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge badge-danger badge-lg">{{ __('canceled') }}</span>
                                                    @break

                                                    @case('in the mandatory period')
                                                        <span
                                                            class="badge badge-info badge-lg">{{ __('in the mandatory period') }}</span>
                                                    @break

                                                    @case('returned')
                                                        <span class="badge badge-danger badge-lg">{{ __('returned') }}</span>
                                                    @break

                                                    @case('Waiting for the order amount to be released')
                                                        <span
                                                            class="badge badge-info badge-lg">{{ __('Waiting for the order amount to be released') }}</span>
                                                    @break

                                                    @case('RTO')
                                                        <span class="badge badge-danger badge-lg">{{ __('RTO') }}</span>
                                                    @break

                                                    @default
                                                @endswitch

                                            </td>
                                            <td><small>{{ $order->total_price . ' ' . $order->user->country->currency }}</small>
                                            </td>
                                            <td><small>


                                                    @php
                                                        $date = Carbon\Carbon::now();
                                                        $interval = $order->created_at->diffForHumans($date);
                                                    @endphp

                                                    {{ $order->created_at }}

                                                    <span style="direction: ltr !important"
                                                        class="badge badge-success">{{ $interval }}</span>

                                                </small></td>
                                            <td><small>

                                                    @php
                                                        $date = Carbon\Carbon::now();
                                                        $interval = $order->updated_at->diffForHumans($date);
                                                    @endphp

                                                    {{ $order->updated_at }}

                                                    <span style="direction: ltr !important"
                                                        class="badge badge-success">{{ $interval }}</span>

                                                </small></td>


                                            <td class="project-actions">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                <a style="color:#ffffff" class="btn btn-primary btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Order Display') }}"
                                                    href="{{ route('vendor.order.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                    <i class=" fas fa-solid fa-tv"></i>
                                                </a>
                                                    </div>
                                                </div>



                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="row mt-3"> {{ $orders->appends(request()->query())->links() }}</div>
                        @else
                            <h3 class="p-4">{{ __('You do not have orders to view') }}</h3>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>

            {{-- <div class="col-md-4">

                <div class="card">

                    <div class="card-header">


                    <h3 class="card-title">Show Products</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                    </div>
                    </div>

                    <div class="card-body p-0 table-responsive">


                    <div class="box-body">

                        <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                            <div class="loader"></div>
                            <p style="margin-top: 10px">Loading ....</p>
                        </div>

                        <div id="order-product-list">





                        </div><!-- end of order product list -->


                    </div><!-- end of box body -->

                </div><!-- end of box -->

            </div><!-- end of col --> --}}
        </div>

        </div>



    </section>
    <!-- /.content -->



@endsection
