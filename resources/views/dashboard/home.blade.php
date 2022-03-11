@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->


    @if ($user->HasRole('affiliate'))
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">

                                @if ($user->balance->available_balance < 0)
                                    @php
                                        $available_balance = 0;
                                    @endphp
                                    <h3>{{ $available_balance . ' ' . $user->country->currency }}</h3>
                                @else
                                    <h3>{{ $user->balance->available_balance . ' ' . $user->country->currency }}</h3>
                                @endif

                                <p>{{ __('Available balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $user->balance->bonus . ' ' . $user->country->currency }}</h3>

                                <p>{{ __('Bonus balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $user->balance->outstanding_balance . ' ' . $user->country->currency }}</h3>

                                <p>{{ __('Outstanding balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $user->balance->pending_withdrawal_requests . ' ' . $user->country->currency }}
                                </h3>

                                <p>{{ __('Pending withdrawal requests') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}
                                </h3>

                                <p>{{ __('Completed withdrawal requests') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">

                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'pending']) }}">{{ __('pending') . ' ( ' . $orders->where('status', 'pending')->count() . ' )' }}</a>
                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'confirmed']) }}">{{ __('confirmed') . ' ( ' . $orders->where('status', 'confirmed')->count() . ' )' }}</a>
                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'on the way']) }}">{{ __('on the way') . ' ( ' . $orders->where('status', 'on the way')->count() . ' )' }}</a>
                    <a class="btn btn-primary btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') . ' ( ' . $orders->where('status', 'in the mandatory period')->count() . ' )' }}</a>
                    <a class="btn btn-success btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'delivered']) }}">{{ __('delivered') . ' ( ' . $orders->where('status', 'delivered')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'canceled']) }}">{{ __('canceled') . ' ( ' . $orders->where('status', 'canceled')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'returned']) }}">{{ __('returned') . ' ( ' . $orders->where('status', 'returned')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.affiliate.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'RTO']) }}">{{ __('RTO') . ' ( ' . $orders->where('status', 'RTO')->count() . ' )' }}</a>
                </div>
            </div>
        </section>
    @endif


    @if ($user->HasRole('vendor'))
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">

                                @if ($user->balance->available_balance < 0)
                                    @php
                                        $available_balance = 0;
                                    @endphp
                                    <h3>{{ $available_balance . ' ' . $user->country->currency }}</h3>
                                @else
                                    <h3>{{ $user->balance->available_balance . ' ' . $user->country->currency }}</h3>
                                @endif

                                <p>{{ __('Available balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $user->balance->bonus . ' ' . $user->country->currency }}</h3>

                                <p>{{ __('Bonus balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $user->balance->outstanding_balance . ' ' . $user->country->currency }}</h3>

                                <p>{{ __('Outstanding balance') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $user->balance->pending_withdrawal_requests . ' ' . $user->country->currency }}
                                </h3>

                                <p>{{ __('Pending withdrawal requests') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-2 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}
                                </h3>

                                <p>{{ __('Completed withdrawal requests') }}</p>
                            </div>
                            <div class="icon">

                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>



        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">

                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'pending']) }}">{{ __('pending') . ' ( ' . $orders->where('status', 'pending')->count() . ' )' }}</a>
                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'confirmed']) }}">{{ __('confirmed') . ' ( ' . $orders->where('status', 'confirmed')->count() . ' )' }}</a>
                    <a class="btn btn-info btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'on the way']) }}">{{ __('on the way') . ' ( ' . $orders->where('status', 'on the way')->count() . ' )' }}</a>
                    <a class="btn btn-primary btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'in the mandatory period']) }}">{{ __('in the mandatory period') . ' ( ' . $orders->where('status', 'in the mandatory period')->count() . ' )' }}</a>
                    <a class="btn btn-primary btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(),'user' => Auth::id(),'status' => 'Waiting for the order amount to be released']) }}">{{ __('Waiting for the order amount to be released') .' ( ' .$orders->where('status', 'Waiting for the order amount to be released')->count() .' )' }}</a>
                    <a class="btn btn-success btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'delivered']) }}">{{ __('delivered') . ' ( ' . $orders->where('status', 'delivered')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'canceled']) }}">{{ __('canceled') . ' ( ' . $orders->where('status', 'canceled')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'returned']) }}">{{ __('returned') . ' ( ' . $orders->where('status', 'returned')->count() . ' )' }}</a>
                    <a class="btn btn-danger btn-lg"
                        href="{{ route('orders.vendor.show', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'status' => 'RTO']) }}">{{ __('RTO') . ' ( ' . $orders->where('status', 'RTO')->count() . ' )' }}</a>
                </div>
            </div>
        </section>
    @endif




    @if (Auth::user()->HasRole('affiliate'))
        <!-- Modal -->
        <div {{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }} class="modal fade"
            id="affiliateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}"
                        class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('modal_3_title') }}</h5>
                        <button style="{{ app()->getLocale() == 'ar' ? 'margin-left:0' : '' }}" type="button"
                            class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ setting('modal_3_body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (Auth::user()->HasRole('vendor'))
        <!-- Modal -->
        <div {{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }} class="modal fade"
            id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}"
                        class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('modal_2_title') }}</h5>
                        <button style="{{ app()->getLocale() == 'ar' ? 'margin-left:0' : '' }}" type="button"
                            class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ setting('modal_2_body') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif




@endsection
