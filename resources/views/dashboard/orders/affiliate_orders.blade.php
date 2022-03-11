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


                            <div class="col-md-9">
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'pending']) }}">{{ __('pending') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'pending')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'confirmed']) }}">{{ __('confirmed') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'confirmed')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'on the way']) }}">{{ __('on the way') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'on the way')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'in the mandatory period')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'delivered']) }}">{{ __('delivered') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'delivered')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'canceled']) }}">{{ __('canceled') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'canceled')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'returned']) }}">{{ __('returned') .' ( ' .\App\Order::where('user_id', Auth::id())->where('status', 'returned')->count() .' )' }}</a>

                            </div>

                        </div>

                        @if ($orders->count() > 0)
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>

                                        <th>#id</th>
                                        <th>{{ __('Client Name') }}</th>
                                        <th class="text-center">{{ __('Client Phone') }}</th>
                                        <th>{{ __('Order Status') }}</th>
                                        <th class="text-center">{{ __('Total Amount') }}</th>
                                        <th>{{ __('Commission') }}</th>
                                        <th> {{ __('Created At') }}</th>
                                        <th>{{ __('Updated At') }}</th>
                                        <th style="" class="">{{ __('Actions') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>

                                            <td>{{ $order->id }}</td>

                                            <td><small>{{ $order->client_name }}</small></td>
                                            <td><small>{{ $order->client_phone }}</small></td>
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

                                                <a style="color:#ffffff" class="btn btn-primary btn-sm"
                                                    href="{{ route('orders.order.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                    {{ __('Order Display') }}

                                                </a>

                                                @if ($order->status == 'pending')
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('orders.affiliate.cancel', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        {{ __('Cancel') }}
                                                    </a>
                                                @endif



                                                @if ($order->status != 'canceled' && $order->status != 'returned' && $order->status != 'pending' && $order->refund == null)
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#modal-primary-{{ $order->id }}">
                                                        {{ __('return request') }}
                                                    </button>
                                                @endif



                                                @if ($order->refund != null && $order->refund->status == 1)
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#modal-primaryy-{{ $order->id }}">
                                                        {{ __('Reason for refuse refund request') }}
                                                    </button>
                                                @endif

                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modal-danger-{{ $order->id }}">
                                                    {{ __('Notes') }}
                                                </button>



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
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Order Notes') . ' #' . $order->id }}
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
                                                <img src="{{ asset('storage/images/icon.png') }}"
                                                    class="img-circle elevation-2" alt="User Image"
                                                    style="width:30%; margin:4px">
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


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div style="direction: rtl" class="modal fade" id="modal-primary-{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div style="direction: ltr" class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">
                            {{ __('Return request for order No - ') . ' #' . $order->id }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('affiliate.return', ['lang' => app()->getLocale(), 'order' => $order->id, 'user' => Auth::user()->id]) }}"
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

        @if ($order->refund != null && $order->refund->status == 1)
            <div style="direction: rtl" class="modal fade" id="modal-primaryy-{{ $order->id }}">
                <div class="modal-dialog">
                    <div class="modal-content bg-primary">
                        <div style="direction: ltr" class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">


                            @if ($order->refund->refuse_reason != null)
                                <div class="form-group row">
                                    <label for="status"
                                        class="col-md-12 col-form-label">{{ __('Reason for refuse refund request: ') . $order->refund->refuse_reason }}</label>

                                </div>
                            @endif

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light"
                                data-dismiss="modal">{{ __('Close') }}</button>
                        </div>


                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endif
    @endforeach

@endsection
