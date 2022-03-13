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

        <!-- Default box -->

        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="search" placeholder="{{ __('Search ...') }}" class="form-control"
                                    value="{{ request()->search }}">
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
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('All Status') }}</option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('pending') }}</option>
                                <option value="recieved" {{ request()->status == 'confirmrecieveded' ? 'selected' : '' }}>
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

        <form method="POST"
            action="{{ route('withdrawals.export', ['lang' => app()->getLocale(),'from' => request()->from,'to' => request()->to]) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-md-2 mb-2">
                    <select class="form-control" name="status" style="display:inline-block">
                        <option value="all" selected>{{ __('All Status') }}</option>
                        <option value="pending">{{ __('pending') }}</option>
                        <option value="recieved">{{ __('recieved') }}</option>
                        <option value="confirmed">{{ __('confirmed') }}</option>
                        <option value="canceled">{{ __('canceled') }}</option>
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
                    <div class="card-body p-0 table-responsive">
                        @if ($withdrawals->count() > 0)
                            <table class="table table-striped projects">
                                <thead>
                                    <tr>

                                        <th>
                                            {{ __('Order No') }}
                                        </th>
                                        <th>
                                            {{ __('Name') }}
                                        </th>
                                        <th>
                                            {{ __('Type') }}
                                        </th>
                                        <th>
                                            {{ __('Payment Type') }}
                                        </th>
                                        <th>
                                            {{ __('Payment data') }}
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
                                        <th>
                                            {{ __('Actions') }}
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdraw)
                                        <tr>

                                            <td style="">{{ $withdraw->id }}</td>
                                            <td style="">
                                                <a
                                                    href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $withdraw->user->id]) }}">
                                                    {{ $withdraw->user_name }}
                                                </a>
                                            </td>
                                            <td style="">
                                                {{ $withdraw->user->HasRole('affiliate') ? __('Affiliate') : __('Vendor') }}
                                            </td>
                                            <td style="">
                                                @if ($withdraw->type == '1')
                                                    {{ __('Vodafone Cash') }}
                                                @endif
                                            </td>
                                            <td style="">{{ $withdraw->data }}</td>

                                            <td style="">{{ $withdraw->amount }}
                                                {{ ' ' . $withdraw->user->country->currency }}</td>
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


                                            <td class="project-actions">


                                                @if ($withdraw->status != 'confirmed' && $withdraw->status != 'canceled')
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#modal-primary-{{ $withdraw->id }}">
                                                        {{ __('Change Request Status') }}
                                                    </button>
                                                @endif


                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="row mt-3"> {{ $withdrawals->appends(request()->query())->links() }}</div>
                        @else
                            <h3 class="p-4">{{ __('You have no recorded profit withdrawal requests') }}</h3>
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

    @foreach ($withdrawals as $withdraw)
        <div class="modal fade" id="modal-primary-{{ $withdraw->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">
                            {{ __('Change Request Status for - ') . $withdraw->user->name }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('withdrawals.update.requset', ['lang' => app()->getLocale(), 'withdrawal' => $withdraw->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                                <div class="col-md-8">

                                    <select style="height: 50px;"
                                        class=" form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required autocomplete="status">

                                        <option value="pending" {{ $withdraw->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="recieved" {{ $withdraw->status == 'recieved' ? 'selected' : '' }}>
                                            {{ __('recieved') }}</option>
                                        <option value="confirmed" {{ $withdraw->status == 'confirmed' ? 'selected' : '' }}>
                                            {{ __('confirmed') }}</option>
                                        <option value="canceled" {{ $withdraw->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>
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



@endsection
