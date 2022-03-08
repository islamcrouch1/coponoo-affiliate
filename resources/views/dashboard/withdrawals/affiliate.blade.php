@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Withdrawals Requests') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Withdrawals Requests') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

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
                            <h3>{{ $user->balance->pending_withdrawal_requests . ' ' . $user->country->currency }}</h3>

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
                            <h3>{{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}</h3>

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
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-6">
                    <!-- small box -->

                    <div class="alert alert-danger" role="alert">
                        {{ __('Please note that the minimum withdrawal amount is 300') . ' ' . $user->country->currency }}
                    </div>
                </div>
            </div>
        </div>

    </section>





    <!-- Main content -->
    <section class="content">

        <!-- Default box -->



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">{{ __('Financial Operations Archive') }}</h3>
                    </div>

                    <div class="card-body p-0">
                        @if ($user->requests->count() == 0)
                            <div style="padding:20px" class="row">
                                <div class="col-md-6 pt-3">
                                    <h6>{{ __('There are no previous transactions performed on your balance') }}</h6>
                                </div>
                            </div>
                        @else


                            <div class="table-responsive">


                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th>
                                                {{ __('Process ID') }}
                                            </th>
                                            <th>
                                                {{ __('Process') }}
                                            </th>
                                            <th>
                                                {{ __('Order ID') }}
                                            </th>
                                            <th>
                                                {{ __('Balance') }}
                                            </th>
                                            <th>
                                                {{ __('Process Date') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($requests as $request)
                                            <tr>
                                                <td style="">{{ $request->id }}</td>
                                                <td style="">
                                                    {{ app()->getLocale() == 'ar' ? $request->request_ar : $request->request_en }}
                                                </td>
                                                <td style="">{{ '# ' . $request->order_id }}</td>
                                                <td style="">{{ $request->balance }}
                                                    {{ ' ' . $user->country->currency }}
                                                </td>
                                                <td style="">{{ $request->created_at }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>


                            <div class="row mt-3"> {{ $requests->appends(request()->query())->links() }}</div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>


        </div>


        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search" placeholder="{{ __('Search ...') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('All Status') }}</option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('pending') }}</option>
                                <option value="recieved"
                                    {{ request()->status == 'confirmrecieveded' ? 'selected' : '' }}>
                                    {{ __('recieved') }}</option>
                                <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                    {{ __('confirmed') }}</option>
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


                        <h3 class="card-title">{{ __('Withdrawals Requests') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($withdrawals->count() > 0)
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>

                                        <th>
                                            {{ __('Order No') }}
                                        </th>
                                        <th>
                                            {{ __('Total') }}
                                        </th>
                                        <th>
                                            {{ __('Order Date') }}
                                        </th>
                                        <th>
                                            {{ __('Order status') }}
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdraw)
                                        <tr>

                                            <td style="">{{ $withdraw->id }}</td>
                                            <td style="">{{ $withdraw->amount }} {{ ' ' . $user->country->currency }}
                                            </td>
                                            <td style="">{{ $withdraw->created_at }}</td>
                                            <td style="">

                                                @switch($withdraw->status)
                                                    @case('pending')
                                                        <span
                                                            class="badge badge-primary badge-lg">{{ __('Awaiting review from management') }}</span>
                                                    @break

                                                    @case('recieved')
                                                        <span
                                                            class="badge badge-info badge-lg">{{ __('Your request has been received and is being reviewed for a deposit') }}</span>
                                                    @break

                                                    @case('confirmed')
                                                        <span
                                                            class="badge badge-success badge-lg">{{ __('The amount has been deposited into your account') }}</span>
                                                    @break

                                                    @case('canceled')
                                                        <span
                                                            class="badge badge-danger badge-lg">{{ __('Request rejected Please contact customer service to find out the reason') }}</span>
                                                    @break

                                                    @default
                                                @endswitch


                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="row mt-3"> {{ $withdrawals->appends(request()->query())->links() }}</div>

                        @else <h6 class="p-4">{{ __('You have no recorded profit withdrawal requests') }}
                            </h6>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>


        </div>

        </div>



    </section>
    <!-- /.content -->



@endsection
