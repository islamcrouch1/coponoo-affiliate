@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('My stock orders') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('My stock orders') }}</li>
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
                                <option value="rejected" {{ request()->status == 'rejected' ? 'selected' : '' }}>
                                    {{ __('rejected') }}</option>
                                <option value="canceled" {{ request()->status == 'canceled' ? 'selected' : '' }}>
                                    {{ __('canceled') }}</option>
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
                                    href="{{ route('mystock.orders', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'pending']) }}">{{ __('pending') .' ( ' .\App\Aorder::where('user_id', Auth::id())->where('status', 'pending')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('mystock.orders', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'confirmed']) }}">{{ __('confirmed') .' ( ' .\App\Aorder::where('user_id', Auth::id())->where('status', 'confirmed')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('mystock.orders', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'rejected']) }}">{{ __('rejected') .' ( ' .\App\Aorder::where('user_id', Auth::id())->where('status', 'rejected')->count() .' )' }}</a>
                                <a class="btn btn-info"
                                    href="{{ route('mystock.orders', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'canceled']) }}">{{ __('canceled') .' ( ' .\App\Aorder::where('user_id', Auth::id())->where('status', 'canceled')->count() .' )' }}</a>
                            </div>

                        </div>

                        @if ($orders->count() > 0)
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>

                                        <th>#id</th>
                                        <th>{{ __('Order Status') }}</th>
                                        <th>{{ __('Product Name') }}</th>
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

                                                    @case('rejected')
                                                        <span class="badge badge-info badge-lg">{{ __('rejected') }}</span>
                                                    @break

                                                    @case('canceled')
                                                        <span class="badge badge-danger badge-lg">{{ __('canceled') }}</span>
                                                    @break

                                                    @default
                                                @endswitch

                                            </td>
                                            <td>
                                                <small>
                                                    {{ app()->getLocale() == 'ar' ? $order->product->name_ar : $order->product->name_en }}
                                                </small>
                                            </td>
                                            <td><small>{{ $order->total_price . ' ' . $order->user->country->currency }}</small>
                                            </td>
                                            <td><small>


                                                    @php
                                                        $date = Carbon\Carbon::now();
                                                        $interval = $order->created_at->diffForHumans($date);
                                                    @endphp

                                                    <span style="direction: ltr !important"
                                                        class="badge badge-success">{{ $interval }}</span>

                                                </small></td>
                                            <td><small>

                                                    @php
                                                        $date = Carbon\Carbon::now();
                                                        $interval = $order->updated_at->diffForHumans($date);
                                                    @endphp

                                                    <span style="direction: ltr !important"
                                                        class="badge badge-success">{{ $interval }}</span>

                                                </small></td>


                                            <td class="project-actions">

                                                <a style="color:#ffffff" class="btn btn-primary btn-sm"
                                                    href="{{ route('mystock.product', ['lang' => app()->getLocale(),'product' => $order->product->id,'order' => $order->id]) }}">
                                                    {{ __('Show product') }}
                                                </a>

                                                @if ($order->status == 'pending')
                                                    <a style="color:#ffffff" class="btn btn-danger btn-sm"
                                                        href="{{ route('mystock.cancel', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        {{ __('Cancel') }}
                                                    </a>
                                                @endif

                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modal-primary-{{ $order->id }}">
                                                    {{ __('Order Details') }}
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
        <div style="direction: rtl" class="modal fade" id="modal-primary-{{ $order->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div style="direction: ltr" class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">
                            {{ __('Order Details') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">


                        <table class="table table-striped projects">
                            <thead>
                                <tr>

                                    <th>{{ __('Color') }}</th>
                                    <th>{{ __('Size') }}</th>
                                    <th>{{ __('Quantity') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->astocks as $stock)
                                    <tr>

                                        <td>{{ $stock->color->color_ar }}</td>
                                        <td>{{ $stock->size->size_ar }}</td>
                                        <td>{{ $stock->stock }}</td>


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>


                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light"
                            data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                    </form>


                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endforeach


@endsection
