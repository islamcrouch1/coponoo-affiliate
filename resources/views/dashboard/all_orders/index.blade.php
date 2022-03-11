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
                                <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>
                                    {{ __('delivered') }}</option>
                                <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                    {{ __('canceled') }}</option>
                                <option value="returned" {{ request()->status == 'returned' ? 'selected' : '' }}>
                                    {{ __('returned') }}</option>
                                <option value="RTO" {{ request()->status == 'RTO' ? 'selected' : '' }}>
                                    {{ __('RTO') }}</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a class="btn btn-primary"
                                href="{{ route('orders-mandatory-check', ['lang' => app()->getLocale()]) }}"><i
                                    class="fa fa-order mr-1"></i>{{ __('Review mandatory period requests') }}</a>
                        </div>


                        <div class="col-md-2 mb-3">
                            <a class="btn btn-primary"
                                href="{{ route('admin.refunds', ['lang' => app()->getLocale()]) }}"><i
                                    class="fa fa-order mr-1"></i>{{ __('Refunds Requsets') }}</a>
                        </div>



                        <div class="col-md-2 mb-3">
                            <a class="btn btn-primary"
                                href="{{ route('admin.prefunds', ['lang' => app()->getLocale()]) }}"><i
                                    class="fa fa-order mr-1"></i>{{ __('Partial Refunds Requsets') }}</a>
                        </div>





                    </div>
                </form>


                <form method="POST"
                    action="{{ route('orders.export', ['lang' => app()->getLocale(), 'from' => request()->from, 'to' => request()->to]) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-2 mb-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="all" selected>{{ __('All Status') }}</option>
                                <option value="pending">{{ __('pending') }}</option>
                                <option value="confirmed">{{ __('confirmed') }}</option>
                                <option value="on the way">{{ __('on the way') }}</option>
                                <option value="in the mandatory period">{{ __('in the mandatory period') }}</option>
                                <option value="delivered">{{ __('delivered') }}</option>
                                <option value="canceled">{{ __('canceled') }}</option>
                                <option value="returned">{{ __('returned') }}</option>
                                <option value="RTO">{{ __('RTO') }}</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            @if (auth()->user()->hasPermission('users-read'))
                                <button type="submit" class="btn btn-info">{{ __('Export') }}
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-primary">{{ __('Export') }}
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            @endif
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

                        <form id="select-form" method="POST"
                            action="{{ route('orders-change-status-all', ['lang' => app()->getLocale()]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-1">
                                    <select class="form-control" name="status" style="display:inline-block">
                                        <option value="pending" selected>{{ __('pending') }}</option>
                                        <option value="confirmed">{{ __('confirmed') }}</option>
                                        <option value="on the way">{{ __('on the way') }}</option>
                                        <option value="in the mandatory period">{{ __('in the mandatory period') }}
                                        </option>
                                        <option value="delivered">{{ __('delivered') }}</option>
                                        <option value="canceled">{{ __('canceled') }}</option>
                                        <option value="returned">{{ __('returned') }}</option>
                                        <option value="RTO">{{ __('RTO') }}</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button id="select-button" class="btn btn-info"
                                        type="submit">{{ __('Change Requests Status') }}</button>
                                </div>

                                <div class="col-md-9">
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'pending']) }}">{{ __('pending') . ' ( ' . \App\Order::where('status', 'pending')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'confirmed']) }}">{{ __('confirmed') . ' ( ' . \App\Order::where('status', 'confirmed')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'on the way']) }}">{{ __('on the way') . ' ( ' . \App\Order::where('status', 'on the way')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') .' ( ' .\App\Order::where('status', 'in the mandatory period')->count() .' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'delivered']) }}">{{ __('delivered') . ' ( ' . \App\Order::where('status', 'delivered')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'canceled']) }}">{{ __('canceled') . ' ( ' . \App\Order::where('status', 'canceled')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'returned']) }}">{{ __('returned') . ' ( ' . \App\Order::where('status', 'returned')->count() . ' )' }}</a>
                                    <a class="btn btn-info"
                                        href="{{ route('all_orders.index', ['lang' => app()->getLocale(), 'status' => 'RTO']) }}">{{ __('RTO') . ' ( ' . \App\Order::where('status', 'RTO')->count() . ' )' }}</a>
                                </div>

                            </div>

                            @if ($orders->count() > 0)
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>

                                            <th style="padding-bottom: 34px ;"><input class="form-check-input"
                                                    type="checkbox" value="" id="checkall"></th>
                                            <th>#id</th>
                                            <th>{{ __('affiliate Name') }}</th>
                                            <th>{{ __('Client Name') }}</th>
                                            <th class="text-center">{{ __('Client Phone') }}</th>
                                            <th>{{ __('Order Status') }}</th>
                                            <th class="text-center">{{ __('Total Amount') }}</th>
                                            <th>{{ __('Commission') }}</th>
                                            <th>{{ __('Profit') }}</th>
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
                                                        name="checkAll[]"
                                                        style="margin-right: 11px;
                                                                                                                                                margin-left: 11px">
                                                </td>

                                                <td>{{ $order->id }}</td>

                                                <td><small>
                                                        <a
                                                            href="{{ route('users.show', [app()->getLocale(), $order->user_id]) }}">{{ $order->user_name }}</a>
                                                    </small></td>
                                                <td><small>{{ substr($order->client_name, 0, 90) }}</small></td>
                                                <td><small>{{ $order->client_phone }}</small></td>
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

                                                        @case('RTO')
                                                            <span class="badge badge-danger badge-lg">{{ __('RTO') }}</span>
                                                        @break

                                                        @default
                                                    @endswitch

                                                    @if ($order->refund)
                                                        @if ($order->refund->id != null && $order->status != 'returned')
                                                            @if ($order->refund->status == 0)
                                                                <br><span
                                                                    class="badge badge-danger badge-lg">{{ __('There is a return request') }}</span>
                                                            @elseif ($order->refund->status == 1)
                                                                <br><span
                                                                    class="badge badge-danger badge-lg">{{ __('Return request denied') }}</span>
                                                            @endif
                                                        @endif
                                                    @endif


                                                    @if ($order->prefunds->count() != 0)
                                                        @if ($order->status != 'returned' && $order->status != 'canceled')
                                                            @foreach ($order->prefunds as $prefund)
                                                                @if ($prefund->status == 0)
                                                                    <br><span
                                                                        class="badge badge-danger badge-lg">{{ __('There is a partial refund request') }}</span>
                                                                @elseif ($prefund->status == 1)
                                                                    <br><span
                                                                        class="badge badge-danger badge-lg">{{ __('Partial refund request denied') }}</span>
                                                                @elseif ($prefund->status == 2)
                                                                    <br><span
                                                                        class="badge badge-danger badge-lg">{{ __('Partial refund request approved') }}
                                                                        <br>
                                                                        {{ __('Order ID : ') . $prefund->orderid }}</span>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif


                                                </td>
                                                <td><small>{{ $order->total_price . ' ' . $order->user->country->currency }}</small>
                                                </td>
                                                <td><small>{{ $order->total_commission . ' ' . $order->user->country->currency }}</small>
                                                </td>
                                                <td><small>{{ $order->total_profit . ' ' . $order->user->country->currency }}</small>
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



                                                    <a class="btn btn-info btn-sm order-i" data-toggle="tooltip"
                                                        data-placement="top" title=" {{ __('Affiliate Info') }}"
                                                        href="{{ route('users.show', [app()->getLocale(), $order->user->id]) }}">
                                                        <i class=" fas fa-solid fa-user"></i> </a>


                                                    <a style="color:#ffffff" class="btn btn-secondary btn-sm order-i"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="  {{ __('Order Display') }}"
                                                        href="{{ route('orders.order.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        <i class="fas fa-solid fa-tv"></i>

                                                    </a>



                                                    @if ($order->status != 'canceled' && $order->status != 'returned' && $order->status != 'RTO')
                                                        <button type="button" class="btn btn-primary btn-sm order-i"
                                                            data-toggle="modal"
                                                            data-target="#modal-primary-{{ $order->id }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title=" {{ __('Change Request Status') }}">
                                                            <i style="color:#ffffff"
                                                                class=" fas fa-solid fa-calendar-check"></i>
                                                        </button>
                                                    @endif

                                                    @if (auth()->user()->hasPermission('onotes-read'))
                                                        <button style="" type="button"
                                                            class="btn btn-success btn-sm order-i" data-toggle="modal"
                                                            data-target="#modal-danger-{{ $order->id }}"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="  {{ __('Notes') }}" data-toggle="modal">
                                                            <i class=" fas fa-solid fa-highlighter"></i>
                                                        </button>
                                                    @endif


                                                    @if ($order->refund)
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-primaryy-{{ $order->id }}">
                                                            {{ __('reason for return request') }}
                                                        </button>
                                                    @endif


                                                    @if ($order->status != 'canceled' && $order->status != 'returned' && $order->prefunds->count() != 0)
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#modal-primaryyy-{{ $order->id }}">
                                                            {{ __('Partial refund requests') }}
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
                        <h3 class="p-4">No orders To Show</h3>
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
        <div class="modal fade" id="modal-danger-{{ $order->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST"
                        action="{{ route('add.onote', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'order' => $order->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ __('Order Notes') . ' #' . $order->id }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            @if ($order->onotes->count() > 0)
                                @foreach ($order->onotes as $note)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="image pb-1">
                                                <a class="p-3"
                                                    href="{{ route('users.show', [app()->getLocale(), $note->user_id]) }}">
                                                    <img src="{{ asset('storage/images/users/' . $note->user->profile) }}"
                                                        class="img-circle elevation-2" alt="User Image"
                                                        style="width:30%; margin:4px">
                                                </a>

                                                @php
                                                    $date = Carbon\Carbon::now();
                                                    $interval = $note->created_at->diffForHumans($date);
                                                @endphp

                                                <span style="direction: ltr !important"
                                                    class="badge badge-success">{{ $interval }}</span>

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            {{ $note->note }}
                                        </div>
                                    </div>

                                    <hr>
                                @endforeach
                            @else
                                <p>
                                    {{ __('There are currently no notes for this order') }}
                                </p>
                            @endif

                            <hr>

                            @if (auth()->user()->hasPermission('onotes-create'))
                                <div class="form-group row">
                                    <label for="note"
                                        class="col-md-2 col-form-label text-md-right">{{ __('Note') }}</label>

                                    <div class="col-md-10">
                                        <input id="note" type="text"
                                            class="form-control @error('note') is-invalid @enderror" name="note"
                                            value="{{ old('note') }}" required autocomplete="note" autofocus>

                                        @error('note')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('Close') }}</button>
                            @if (auth()->user()->hasPermission('onotes-create'))
                                <button type="submit" class="btn btn-primary">{{ __('Add Note') }}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>


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
                        action="{{ route('orders.update.order', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                                <div class="col-md-8">

                                    <select style="height: 50px;"
                                        class=" form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required autocomplete="status">

                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            {{ __('confirmed') }}</option>
                                        <option value="on the way"
                                            {{ $order->status == 'on the way' ? 'selected' : '' }}>
                                            {{ __('on the way') }}</option>
                                        <option value="in the mandatory period"
                                            {{ $order->status == 'in the mandatory period' ? 'selected' : '' }}>
                                            {{ __('in the mandatory period') }}</option>
                                        <option value="delivered"
                                            {{ $order->status == 'compdeliveredleted' ? 'selected' : '' }}>
                                            {{ __('delivered') }}</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>
                                        <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>
                                            {{ __('returned') }}</option>
                                        <option value="RTO" {{ $order->status == 'RTO' ? 'selected' : '' }}>
                                            {{ __('RTO') }}</option>
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



        @if ($order->refund)
            <div style="direction: rtl" class="modal fade" id="modal-primaryy-{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content bg-primary">
                        <div style="direction: ltr" class="modal-header">
                            <h4 style="direction: rtl;" class="modal-title">
                                {{ __('reason for return request') . ' #' . $order->id }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.return.reject', ['lang' => app()->getLocale(),'order' => $order->id,'user' => $order->user->id]) }}"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="modal-body">

                                <div class="form-group row">
                                    <label for="status"
                                        class="col-md-12 col-form-label">{{ __('Reason for refund request: ') . $order->refund->reason }}</label>

                                </div>

                                @if ($order->refund->refuse_reason != null)
                                    <div class="form-group row">
                                        <label for="status"
                                            class="col-md-12 col-form-label">{{ __('Reason for refuse refund request: ') . $order->refund->refuse_reason }}</label>

                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="reason"
                                        class="col-md-5 col-form-label">{{ __('Reason for rejection') }}</label>

                                    <div class="col-md-7">
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

                            </div>


                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit"
                                    class="btn btn-outline-light">{{ __('Reject the return request') }}</button>

                            </div>
                        </form>


                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endif


        @if ($order->prefunds->count() != 0)
            <div style="direction: rtl" class="modal fade" id="modal-primaryyy-{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content bg-primary">
                        <div style="direction: ltr" class="modal-header">
                            <h4 style="direction: rtl;" class="modal-title">
                                {{ __('Partial refund requests') . ' - ' . ' #' . $order->id }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>

                        @foreach ($order->prefunds as $prefund)
                            <form method="POST"
                                action="{{ route('admin.prefund', ['lang' => app()->getLocale(),'order' => $order->id,'user' => $order->user->id,'product' => $prefund->product_id,'prefund' => $prefund->id]) }}"
                                enctype="multipart/form-data">
                                @csrf


                                <div class="modal-body">

                                    <div class="form-group row">
                                        <label for="status" class="col-md-12 col-form-label">{{ __('Product Name: ') }}
                                            {{ app()->getLocale() == 'ar' ? $prefund->product->name_ar : $prefund->product->name_en }}
                                        </label>

                                    </div>

                                    <div class="form-group row">
                                        <label for="status"
                                            class="col-md-12 col-form-label">{{ __('Product ID: ') . ' #' . $prefund->product_id }}
                                        </label>

                                    </div>


                                    <div class="form-group row">
                                        <label for="status"
                                            class="col-md-12 col-form-label">{{ __('Product Color: ') }}
                                            {{ app()->getLocale() == 'ar' ? $prefund->stock->color->color_ar : $prefund->stock->color->color_en }}
                                        </label>

                                    </div>

                                    <div class="form-group row">
                                        <label for="status" class="col-md-12 col-form-label">{{ __('Product Size: ') }}
                                            {{ app()->getLocale() == 'ar' ? $prefund->stock->size->size_ar : $prefund->stock->size->size_en }}
                                        </label>

                                    </div>

                                    <div class="form-group row">
                                        <label for="status"
                                            class="col-md-12 col-form-label">{{ __('Stock: ') . $prefund->quantity }}
                                        </label>

                                    </div>

                                    <div class="form-group row">
                                        <label for="status"
                                            class="col-md-12 col-form-label">{{ __('Reason for refund request: ') . $prefund->reason }}</label>

                                    </div>

                                    @if ($prefund->refuse_reason != null)
                                        <div class="form-group row">
                                            <label for="status"
                                                class="col-md-12 col-form-label">{{ __('Reason for refuse refund request: ') . $prefund->refuse_reason }}</label>

                                        </div>
                                    @endif


                                    @if ($prefund->status == 2)
                                        <div class="form-group row">
                                            <label for="status"
                                                class="col-md-12 col-form-label">{{ __('Partial refund request approved - ') . __('Order ID : ') . $prefund->orderid }}</label>

                                        </div>
                                    @endif




                                    @if ($prefund->refuse_reason == null && $prefund->status != 2)
                                        <div class="form-group row">
                                            <label for="reason"
                                                class="col-md-5 col-form-label">{{ __('Reason for rejection') }}</label>

                                            <div class="col-md-7">
                                                <input id="reason" type="text"
                                                    class="form-control @error('reason') is-invalid @enderror"
                                                    name="reason" value="{{ old('reason') }}" autocomplete="reason"
                                                    autofocus>

                                                @error('reason')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif


                                    @if ($prefund->refuse_reason == null && $prefund->status != 2)
                                        <div class="form-group row">
                                            <label for="status"
                                                class="col-md-5 col-form-label">{{ __('Select Status') }}</label>
                                            <div class="col-md-7">

                                                <select class=" form-control @error('status') is-invalid @enderror"
                                                    name="status" value="{{ old('status') }}" required
                                                    autocomplete="status">

                                                    <option value="" selected>{{ __('Select Status') }}</option>
                                                    <option value="1">{{ __('rejected') }}</option>
                                                    <option value="2">{{ __('accepted') }}</option>

                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif





                                </div>


                                <div class="modal-footer modal-refund justify-content-between">
                                    <button type="button" class="btn btn-outline-light"
                                        data-dismiss="modal">{{ __('Close') }}</button>

                                    @if ($prefund->refuse_reason == null && $prefund->status != 2)
                                        <button type="submit"
                                            class="btn btn-outline-light">{{ __('Save changes') }}</button>
                                    @endif

                                </div>
                            </form>
                        @endforeach



                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endif
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
