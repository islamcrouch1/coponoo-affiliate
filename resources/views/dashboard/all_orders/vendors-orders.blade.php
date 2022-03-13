@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Vendors Orders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Vendors Orders') }}</li>
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
                                <input type="text" name="search" placeholder="{{ __('Search by client name or phone') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>



                        <div class="col-md-1" style="text-align: center">
                            <label for="from" class="col-md-2 col-form-label">{{ __('From') }}</label>
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="from" class="form-control" value="{{ request()->from }}">
                        </div>

                        <div class="col-md-1" style="text-align: center">
                            <label for="to" class="col-md-2 col-form-label">{{ __('To') }}</label>
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="to" class="form-control" value="{{ request()->to }}">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search  ml-2 mr-2"></i>{{ __('Search') }}</button>
                        </div>


                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="country_id" style="display:inline-block">
                                <option value="" selected>{{ __('All Countries') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('All Status') }}</option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('pending') }}</option>
                                <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                    {{ __('confirmed') }}</option>
                                <option value="on the way" {{ request()->status == 'on the way' ? 'selected' : '' }}>
                                    {{ __('on the way') }}</option>
                                <option value="in the mandatory period"
                                    {{ request()->status == 'in the mandatory period' ? 'selected' : '' }}>
                                    {{ __('in the mandatory period') }}</option>
                                <option value="Waiting for the order amount to be released"
                                    {{ request()->status == 'Waiting for the order amount to be released' ? 'selected' : '' }}>
                                    {{ __('Waiting for the order amount to be released') }}</option>
                                <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>
                                    {{ __('delivered') }}</option>
                                <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                    {{ __('canceled') }}</option>
                                <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                    {{ __('returned') }}</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <a class="btn btn-primary"
                                href="{{ route('orders-mandatory-check-vendors', ['lang' => app()->getLocale()]) }}"><i
                                    class="fa fa-order mr-1"></i>{{ __('Review requests pending release of the amount') }}</a>
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
                        @if ($orders->count() > 0)
                            <form id="select-form" method="POST"
                                action="{{ route('orders-change-status-all-vendors', ['lang' => app()->getLocale()]) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <div class="col-md-1">
                                        <select class="form-control" name="status" style="display:inline-block">
                                            <option value="delivered">{{ __('delivered') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button id="select-button" class="btn btn-info"
                                            type="submit">{{ __('Change Requests Status') }}</button>
                                    </div>

                                    <div class="col-md-9">
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'pending']) }}">{{ __('pending') . ' ( ' . \App\Vorder::where('status', 'pending')->count() . ' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'confirmed']) }}">{{ __('confirmed') . ' ( ' . \App\Vorder::where('status', 'confirmed')->count() . ' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'on the way']) }}">{{ __('on the way') . ' ( ' . \App\Vorder::where('status', 'on the way')->count() . ' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') .' ( ' .\App\Vorder::where('status', 'in the mandatory period')->count() .' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(),'status' => 'Waiting for the order amount to be released']) }}">{{ __('Waiting for the order amount to be released') .' ( ' .\App\Vorder::where('status', 'Waiting for the order amount to be released')->count() .' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'delivered']) }}">{{ __('delivered') . ' ( ' . \App\Vorder::where('status', 'delivered')->count() . ' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'canceled']) }}">{{ __('canceled') . ' ( ' . \App\Vorder::where('status', 'canceled')->count() . ' )' }}</a>
                                        <a class="btn btn-info"
                                            href="{{ route('orders-all-vendors', ['lang' => app()->getLocale(), 'status' => 'returned']) }}">{{ __('returned') . ' ( ' . \App\Vorder::where('status', 'returned')->count() . ' )' }}</a>

                                    </div>

                                </div>



                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>

                                            <th style="padding-bottom: 34px ;"><input class="form-check-input"
                                                    type="checkbox" value="" id="checkall"></th>
                                            <th>#id</th>
                                            <th>{{ __('Vendor Name') }}</th>
                                            <th>{{ __('Order Number') }}</th>
                                            <th>{{ __('Order Status') }}</th>
                                            <th class="text-center">{{ __('Total Amount') }}</th>
                                            <th> {{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th style="" class="">{{ __('Actions') }}</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                            @foreach ($orders as $order)
                                                <td style="padding-bottom: 34px ;"><input class="form-check-input"
                                                        type="checkbox" value="{{ $order->id }}" class="cb-element"
                                                        name="checkAll[]"></td>

                                                <td>{{ $order->id }}</td>

                                                <td><small>
                                                        <a
                                                            href="{{ route('users.show', [app()->getLocale(), $order->user_id]) }}">{{ $order->user_name }}</a>
                                                    </small></td>


                                                <td>{{ $order->order->id }}</td>


                                                <td>

                                                    @switch($order->status)
                                                        @case('pending')
                                                            <span class="badge badge-warning badge-lg">{{ __('pending') }}</span>
                                                        @break

                                                        @case('confirmed')
                                                            <span
                                                                class="badge badge-primary badge-lg">{{ __('confirmed') }}</span>
                                                        @break

                                                        @case('on the way')
                                                            <span class="badge badge-info badge-lg">{{ __('on the way') }}</span>
                                                        @break

                                                        @case('delivered')
                                                            <span
                                                                class="badge badge-success badge-lg">{{ __('delivered') }}</span>
                                                        @break

                                                        @case('canceled')
                                                            <span class="badge badge-danger badge-lg">{{ __('canceled') }}</span>
                                                        @break

                                                        @case('in the mandatory period')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('in the mandatory period') }}</span>
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



                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('users.show', [app()->getLocale(), $order->user->id]) }}">
                                                        {{ __('Vendor Info') }}
                                                    </a>


                                                    <a style="color:#ffffff" class="btn btn-primary btn-sm"
                                                        href="{{ route('admin.vendors.orders.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        {{ __('Order Display') }}
                                                    </a>



                                                    @if ($order->status == 'Waiting for the order amount to be released')
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-primary-{{ $order->id }}">
                                                            {{ __('Change Request Status') }}
                                                        </button>
                                                    @endif






                                                    {{-- @if ($order->status != 'canceled' || $order->status != 'returned')

                                    @if (auth()->user()->hasPermission('all_orders-update'))
                                        <a class="btn btn-info btn-sm" href="{{route('orders.edit' , ['lang'=>app()->getLocale() , 'order'=>$order->id , 'user'=>$order->user->id])}}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                           {{__('Edit')}}
                                        </a>
                                    @else
                                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                       {{__('Edit')}}
                                        </a>
                                    @endif

                                @endif --}}

                                                </td>
                                        </tr>
                        @endforeach


                        </tbody>
                        </table>
                        </form>

                        <div class="row mt-3"> {{ $orders->appends(request()->query())->links() }}</div>
                    @else
                        <h3 class="pl-2">No orders To Show</h3>
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

    @foreach ($orders as $order)
        <div class="modal fade" id="modal-primary-{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">
                            {{ __('Change Request Status for - ') . $order->user->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('orders.update.status.vendors', ['lang' => app()->getLocale(), 'vorder' => $order->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                                <div class="col-md-8">

                                    <select style="height: 50px;"
                                        class=" form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required autocomplete="status">

                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            {{ __('delivered') }}</option>
                                    </select>
                                    @error('status')
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
                            <button type="submit" class="btn btn-outline-light">{{ __('Save changes') }}</button>
                        </div>

                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endforeach



    <div class="modal fade" id="modal-order">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="direction: rtl;" class="modal-title">{{ __('Show Details for order') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="box-body">

                        <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                            <div class="loader"></div>
                            <p style="margin-top: 10px">Loading ....</p>
                        </div>

                        <div id="order-product-list">





                        </div><!-- end of order product list -->


                    </div><!-- end of box body -->



                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
