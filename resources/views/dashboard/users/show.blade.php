@extends('layouts.dashboard.app')

@section('adminContent')



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
                                <p>{{ __('Available balance') }}</p>

                                <h3 style="color: red">
                                    {{ $user->balance->available_balance . ' ' . $user->country->currency }}</h3>
                                <p style="color: red">{{ __('real Available balance') }}</p>
                            @else
                                <h3>{{ $user->balance->available_balance . ' ' . $user->country->currency }}</h3>
                                <p>{{ __('Available balance') }}</p>
                            @endif


                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
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
                            <i class="ion ion-pie-graph"></i>
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
                            <i class="ion ion-pie-graph"></i>
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
                            <i class="ion ion-pie-graph"></i>
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
            <div class="row">
                <div class="col-md-3 m-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline" style="direction: ltr">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/images/users/' . $user->profile) }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                <span>{{ '#' . $user->id . ' : ' }}</span>{{ $user->name }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $user->hasRole('affiliate') ? __('Affiliate') : __('Vendor') }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email : </b> <a class="float-right">{{ $user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Country : </b> <a class="float-right">{{ $user->country->name_en }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone : </b> <a class="float-right">{{ $user->phone }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gender : </b> <a class="float-right">{{ $user->gender }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Verification Code : </b> <a
                                        class="float-right">{{ $user->verification_code }}</a>
                                </li>

                                <li class="list-group-item">
                                    <b>Created At : </b> <a class="float-right">{{ $user->created_at }}</a>
                                </li>

                                <li class="list-group-item">
                                    <b>Updated At : </b> <a class="float-right">{{ $user->updated_at }}</a>
                                </li>
                            </ul>

                            <a href="{{ route('users.edit', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                                class="btn btn-primary btn-block"><b>Edit</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-8 m-3">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    {{ __('Notes') }}
                                </div>
                                <ul class="list-group list-group-flush">
                                    @if ($user->notes->count() > 0)
                                        @foreach ($user->notes as $note)
                                            <li class="list-group-item">

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="image">
                                                            <a
                                                                href="{{ route('users.show', [app()->getLocale(), $note->admin_id]) }}">
                                                                <img src="{{ asset('storage/images/users/' . $note->profile) }}"
                                                                    class="img-circle elevation-2" alt="User Image"
                                                                    style="width:20%;">
                                                                @php
                                                                    $admin1 = \App\User::find($note->admin_id);
                                                                @endphp
                                                                {{ $admin1->name }}
                                                            </a>


                                                            @php
                                                                $date = Carbon\Carbon::now();
                                                                $interval = $note->created_at->diffForHumans($date);
                                                            @endphp

                                                            <br>

                                                            {{-- <span style="direction: ltr !important"
                                                                class="badge badge-success">{{ $interval }}</span> --}}
                                                            {{ $note->created_at }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        {{ $note->note }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item">
                                            {{ __('There are currently no notes for this user') }}
                                        </li>
                                    @endif


                                    <li class="list-group-item">
                                        <form method="POST"
                                            action="{{ route('add.note', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf

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


                                            <div class="form-group row mb-0">
                                                <div class="col-md-10 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Add Note') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>

                                </ul>
                            </div>

                        </div>
                        <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" name="search" autofocus
                                                        placeholder="{{ __('Search ...') }}" class="form-control"
                                                        value="{{ request()->search }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-control" name="status" style="display:inline-block">
                                                    <option value="" selected>{{ __('All Status') }}</option>
                                                    <option value="pending"
                                                        {{ request()->status == 'pending' ? 'selected' : '' }}>
                                                        {{ __('pending') }}</option>
                                                    <option value="recieved"
                                                        {{ request()->status == 'confirmrecieveded' ? 'selected' : '' }}>
                                                        {{ __('recieved') }}</option>
                                                    <option value="confirmed"
                                                        {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                                        {{ __('confirmed') }}</option>
                                                    <option value="canceled"
                                                        {{ request()->status == 'canceled' ? 'selected' : '' }}>
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
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                    data-toggle="tooltip" title="Collapse">
                                                    <i class="fas fa-minus"></i></button>
                                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                                    data-toggle="tooltip" title="Remove">
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
                                                                <td style="">{{ $withdraw->amount }}
                                                                    {{ ' ' . $user->country->currency }}</td>
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

                                                <div class="row mt-3">
                                                    {{ $withdrawals->appends(request()->query())->links() }}</div>
                                            @else
                                                <h3 class="p-4">
                                                    {{ __('You have no recorded profit withdrawal requests') }}</h3>
                                            @endif
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->



                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <section class="content-header">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">{{ __('Financial Operations Archive') }}</h3>
                            </div>

                            <div class="card-body p-0 table-responsive">
                                @if ($user->requests->count() == 0)
                                    <div style="padding:20px" class="row">
                                        <div class="col-md-6 pt-3">
                                            <h6>{{ __('There are no previous transactions performed on your balance') }}
                                            </h6>
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
                                                            {{ ' ' . $user->country->currency }}</td>
                                                        <td style="">{{ $request->created_at }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="row mt-3"> {{ $requests->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->



                    </div>


                </div>
            </section>


            @if ($user->hasRole('vendor'))

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ __('products') }}</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol
                                    class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                                    <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('products') }}</li>
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
                                            <input type="text" name="search" autofocus placeholder="{{ __('Search..') }}"
                                                class="form-control" value="{{ request()->search }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="category_id" style="display:inline-block">
                                            <option value="" selected>All Categories</option>
                                            @foreach ($categories as $category)
                                                @if ($category->parent == 'null')
                                                    <optgroup
                                                        label="{{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}">
                                                        <option value="{{ $category->id }}"
                                                            {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}
                                                        </option>
                                                        @foreach ($categories->where('parent', $category->id) as $category1)
                                                            <option value="{{ $category1->id }}"
                                                                {{ request()->category_id == $category1->id ? 'selected' : '' }}>
                                                                {{ app()->getLocale() == 'ar'? $category1->name_ar . ' - ' . $category1->country->name_ar: $category1->name_en . ' - ' . $category1->country->name_en }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="country_id" style="display:inline-block">
                                            <option value="" selected>All Countries</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status" style="display:inline-block">
                                            <option value="" selected>{{ __('status') }}</option>
                                            <option value="pending"
                                                {{ request()->status == 'pending' ? 'selected' : '' }}>
                                                {{ __('pending') }}</option>
                                            <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                                {{ __('active') }}</option>
                                            <option value="rejected"
                                                {{ request()->status == 'rejected' ? 'selected' : '' }}>
                                                {{ __('rejected') }}</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                                        @if (auth()->user()->hasPermission('products-create'))
                                            <a href="{{ route('products.create', app()->getLocale()) }}"> <button
                                                    type="button"
                                                    class="btn btn-primary">{{ __('Create product') }}</button></a>
                                        @else
                                            <a href="#" aria-disabled="true"> <button type="button"
                                                    class="btn btn-primary">{{ __('Create product') }}</button></a>
                                        @endif

                                    </div>
                                    <div class="col-md-2">

                                        @if (auth()->user()->hasPermission('users-read'))
                                            <a href="{{ route('products.export', app()->getLocale()) }}"> <button
                                                    type="button" class="btn btn-info">{{ __('Export Products') }}
                                                    <i class="fas fa-file-excel"></i>
                                                </button></a>
                                        @else
                                            <a href="#" disabled> <button type="button"
                                                    class="btn btn-primary">{{ __('Export Products') }}
                                                    <i class="fas fa-file-excel"></i>
                                                </button></a>
                                        @endif
                                    </div>

                                </div>
                            </form>

                            <form action="{{ route('products.import', ['lang' => app()->getLocale()]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <input style="width: 200px" type="file" name="file"
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                        required />

                                    <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>



                    <div class="card">
                        <div class="card-header">




                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif

                            @if (session()->has('failures'))
                                <table class="table table-danger">
                                    <tr>
                                        <th>Row</th>
                                        <th>Attribute</th>
                                        <th>Errors</th>
                                        <th>Value</th>
                                    </tr>

                                    @foreach (session()->get('failures') as $validation)
                                        <tr>
                                            <td>{{ $validation->row() }}</td>
                                            <td>{{ $validation->attribute() }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($validation->errors() as $e)
                                                        <li>{{ $e }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $validation->values()[$validation->attribute()] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif



                            {{-- <h3 class="card-title">products</h3> --}}

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                    data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">




                            <form class="select-form" id="select-form" method="POST"
                                action="{{ route('products-change-status-all', ['lang' => app()->getLocale()]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')


                                <div class="row">

                                    <div class="col-md-1">
                                        <select class="form-control" name="status" style="display:inline-block">
                                            <option value="pending" selected>{{ __('pending') }}</option>
                                            <option value="active">{{ __('active') }}</option>
                                            <option value="rejected">{{ __('rejected') }}</option>

                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button id="select-button"
                                            class="btn btn-info ">{{ __('Change Products Status') }}</button>
                                    </div>


                                </div>

                                @if ($products->count() > 0)
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>

                                                <th style="padding-bottom: 34px ;"><input class="form-check-input"
                                                        type="checkbox" value="" id="checkall"></th>
                                                <th>#id</th>
                                                <th>SKU</th>
                                                <th>{{ __('Image') }}</th>
                                                @if (app()->getLocale() == 'ar')
                                                    <th>{{ __('Arabic Name') }}</th>
                                                @else
                                                    <th>{{ __('English Name') }}</th>
                                                @endif
                                                <th>{{ __('Vendor price') }}</th>
                                                <th>{{ __('Min price') }}</th>
                                                <th>{{ __('Max price') }}</th>
                                                <th>{{ __('stock') }}</th>
                                                <th>{{ __('status') }}</th>
                                                <th>{{ __('Created At') }}</th>
                                                <th>{{ __('Updated At') }}</th>

                                                <?php if ($products !== null) {
                                                    $product = $products[0];
                                                } ?>
                                                @if ($product->trashed())
                                                    <th>{{ __('Deleted At') }}</th>
                                                @endif
                                                <th style="" class="">{{ __('Actions') }}</th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>

                                                @foreach ($products as $product)
                                                    <td style="padding-bottom: 34px ;"><input class="form-check-input"
                                                            type="checkbox" value="{{ $product->id }}"
                                                            class="cb-element" name="checkAll[]"></td>
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ $product->SKU }}</td>
                                                    <td><img alt="Avatar" class="table-avatar"
                                                            src="{{ asset('storage/images/products/' . $product->images[0]->url) }}">
                                                    </td>
                                                    @if (app()->getLocale() == 'ar')
                                                        <td><small>{{ $product->name_ar }}</small></td>
                                                    @else
                                                        <td><small>{{ $product->name_en }}</small></td>
                                                    @endif
                                                    <td><small> <b>
                                                                {{ $product->vendor_price . ' ' . $product->country->currency }}</b></small>
                                                    </td>
                                                    <td><small><b>{{ $product->min_price . ' ' . $product->country->currency }}</b></small>
                                                    </td>
                                                    <td><small><b>{{ $product->max_price . ' ' . $product->country->currency }}</b></small>
                                                    </td>
                                                    @php
                                                        $stock1 = 0;
                                                    @endphp
                                                    @foreach ($product->stocks as $stock)
                                                        @php
                                                            $stock1 = $stock1 + $stock->stock;
                                                        @endphp
                                                    @endforeach
                                                    <td><small>{{ $stock1 }}</small></td>
                                                    <td>

                                                        @if ($product->status == 'pending')
                                                            <span
                                                                class='badge badge-warning'>{{ __($product->status) }}</span>
                                                        @elseif ($product->status == 'rejected')
                                                            <span
                                                                class='badge badge-danger'>{{ __($product->status) }}</span>
                                                        @elseif ($product->status == 'active')
                                                            <span
                                                                class='badge badge-success'>{{ __($product->status) }}</span>
                                                        @endif

                                                        @if ($product->limits()->where('product_id', $product->id)->get()->count() != 0)
                                                            <span
                                                                class='badge badge-danger'>{{ __('Unlimited') }}</span>
                                                        @endif

                                                    </td>
                                                    <td><small>{{ $product->created_at }}</small></td>
                                                    <td><small>{{ $product->updated_at }}</small></td>

                                                    @if ($product->trashed())
                                                        <td><small>{{ $product->deleted_at }}</small></td>
                                                    @endif

                                                    <td class="project-actions">



                                                        <a class="btn btn-primary btn-sm"
                                                            href="{{ route('users.show', [app()->getLocale(), $product->user->id]) }}">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                            {{ __('Vendor Info') }}
                                                        </a>

                                                        @if ($product->vendor_id == null)
                                                            <a class="btn btn-secondary btn-sm" href="#">
                                                                <i class="fas fa-pencil-alt">
                                                                </i>
                                                                {{ __('Not reviewed') }}
                                                            </a>
                                                        @else
                                                            <a class="btn btn-secondary btn-sm"
                                                                href="{{ route('users.show', [app()->getLocale(), $product->vendor_id]) }}">
                                                                <i class="fas fa-pencil-alt">
                                                                </i>
                                                                {{ __('Admin Info') }}
                                                            </a>
                                                        @endif

                                                        @if (!$product->trashed())
                                                            @if (auth()->user()->hasPermission('products-update'))
                                                                <a class="btn btn-info btn-sm"
                                                                    href="{{ route('products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                    {{ __('Edit') }}
                                                                </a>

                                                                <a class="btn btn-info btn-sm"
                                                                    href="{{ route('products.color', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                    <i class="fas fa-color">
                                                                    </i>
                                                                    {{ __('Add color') }}
                                                                </a>



                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-primary-{{ $product->id }}">
                                                                    {{ __('Change Product Status') }}
                                                                </button>
                                                            @else
                                                                <a class="btn btn-info btn-sm" href="#"
                                                                    aria-disabled="true">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                    {{ __('Edit') }}
                                                                </a>

                                                                <a class="btn btn-info btn-sm" href="#"
                                                                    aria-disabled="true">
                                                                    <i class="fas fa-color">
                                                                    </i>
                                                                    {{ __('Add color') }}
                                                                </a>
                                                            @endif
                                                        @else
                                                            @if (auth()->user()->hasPermission('products-restore'))
                                                                <a class="btn btn-info btn-sm"
                                                                    href="{{ route('products.restore', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                    {{ __('Restore') }}
                                                                </a>
                                                            @else
                                                                <a class="btn btn-info btn-sm" href="#"
                                                                    aria-disabled="true">
                                                                    <i class="fas fa-pencil-alt">
                                                                    </i>
                                                                    {{ __('Restore') }}
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if (auth()->user()->hasPermission('products-delete') |
    auth()->user()->hasPermission('products-trash'))
                                                            <a href="{{ route('products.destroy.new', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                                class="btn btn-danger btn-sm delete">
                                                                <i class="fas fa-trash">
                                                                </i>
                                                                @if ($product->trashed())
                                                                    {{ __('Delete') }}
                                                                @else
                                                                    {{ __('Trash') }}
                                                                @endif
                                                            </a>
                                                        @else
                                                            <button class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash">
                                                                </i>
                                                                @if ($product->trashed())
                                                                    {{ __('Delete') }}
                                                                @else
                                                                    {{ __('Trash') }}
                                                                @endif
                                                            </button>
                                                        @endif


                                                    </td>
                                            </tr>
                                @endforeach


                                </tbody>
                                </table>
                            </form>

                            <div class="row mt-3"> {{ $products->appends(request()->query())->links() }}</div>
                        @else
                            <h3 class="pl-2">{{ __('No products To Show') }}</h3>
            @endif
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


    @foreach ($products as $product)
        <div class="modal fade" id="modal-primary-{{ $product->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">{{ __('Change Product Status') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('products.update.order', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-5 col-form-label">{{ __('Select Product Status') }}</label>
                                <div class="col-md-7">

                                    <select style="height: 50px;"
                                        class=" form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required autocomplete="status">

                                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                            {{ __('active') }}</option>
                                        <option value="rejected" {{ $product->status == 'rejected' ? 'selected' : '' }}>
                                            {{ __('rejected') }}</option>

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


    @endif


    @if ($user->hasRole('affiliate'))


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
                                <select class="form-control" name="country_id" style="display:inline-block">
                                    <option value="" selected>{{ __('All Countries') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="status" style="display:inline-block">
                                    <option value="" selected>{{ __('All Status') }}</option>
                                    <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                        {{ __('pending') }}</option>
                                    <option value="confirmed" {{ request()->status == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('confirmed') }}</option>
                                    <option value="on the way"
                                        {{ request()->status == 'on the way' ? 'selected' : '' }}>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                    data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            @if ($orders->count() > 0)
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>

                                            <th>#id</th>
                                            <th>{{ __('affiliate Name') }}</th>
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
                                        <tr>

                                            @foreach ($orders as $order)
                                                <td>{{ $order->id }}</td>

                                                <td><small>{{ $order->user_name }}</small></td>
                                                <td><small>{{ $order->client_name }}</small></td>
                                                <td><small>{{ $order->client_phone }}</small></td>
                                                <td>

                                                    @switch($order->status)
                                                        @case('pending')
                                                            <span
                                                                class="badge badge-warning badge-lg">{{ __('pending') }}</span>
                                                        @break

                                                        @case('confirmed')
                                                            <span
                                                                class="badge badge-primary badge-lg">{{ __('confirmed') }}</span>
                                                        @break

                                                        @case('on the way')
                                                            <span
                                                                class="badge badge-info badge-lg">{{ __('on the way') }}</span>
                                                        @break

                                                        @case('delivered')
                                                            <span
                                                                class="badge badge-success badge-lg">{{ __('delivered') }}</span>
                                                        @break

                                                        @case('canceled')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('canceled') }}</span>
                                                        @break

                                                        @case('in the mandatory period')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('in the mandatory period') }}</span>
                                                        @break

                                                        @case('returned')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('returned') }}</span>
                                                        @break

                                                        @case('RTO')
                                                            <span class="badge badge-danger badge-lg">{{ __('RTO') }}</span>
                                                        @break

                                                        @default
                                                    @endswitch

                                                </td>
                                                <td><small>{{ $order->total_price . ' ' . $order->user->country->currency }}</small>
                                                </td>
                                                <td><small>{{ $order->total_commission . ' ' . $order->user->country->currency }}</small>
                                                </td>
                                                <td><small>{{ $order->created_at }}</small></td>
                                                <td><small>{{ $order->updated_at }}</small></td>


                                                <td class="project-actions">



                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('users.show', [app()->getLocale(), $order->user->id]) }}">
                                                        {{ __('Affiliate Info') }}
                                                    </a>


                                                    <a style="color:#ffffff" class="btn btn-primary btn-sm"
                                                        href="{{ route('orders.order.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        {{ __('Order Display') }}
                                                    </a>




                                                    @if ($order->status != 'canceled' && $order->status != 'returned' && $order->status != 'RTO')
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
                                        <option value="delivered"
                                            {{ $order->status == 'compdeliveredleted' ? 'selected' : '' }}>
                                            {{ __('delivered') }}</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                            {{ __('canceled') }}</option>
                                        <option value="in the mandatory period"
                                            {{ $order->status == 'in the mandatory period' ? 'selected' : '' }}>
                                            {{ __('in the mandatory period') }}</option>
                                        <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>
                                            {{ __('returned') }}</option>
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


    @endif


    @if ($user->hasRole('vendor'))


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
                                    <option value="on the way"
                                        {{ request()->status == 'on the way' ? 'selected' : '' }}>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                    data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            @if ($vorders->count() > 0)
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>

                                            <th>#id</th>
                                            <th>{{ __('Order Status') }}</th>
                                            <th class="text-center">{{ __('Total Amount') }}</th>
                                            <th> {{ __('Created At') }}</th>
                                            <th>{{ __('Updated At') }}</th>
                                            <th style="" class="">{{ __('Actions') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vorders as $order)
                                            <tr>

                                                <td>{{ $order->id }}</td>

                                                <td>

                                                    @switch($order->status)
                                                        @case('pending')
                                                            <span
                                                                class="badge badge-warning badge-lg">{{ __('pending') }}</span>
                                                        @break

                                                        @case('confirmed')
                                                            <span
                                                                class="badge badge-primary badge-lg">{{ __('confirmed') }}</span>
                                                        @break

                                                        @case('on the way')
                                                            <span
                                                                class="badge badge-info badge-lg">{{ __('on the way') }}</span>
                                                        @break

                                                        @case('delivered')
                                                            <span
                                                                class="badge badge-success badge-lg">{{ __('delivered') }}</span>
                                                        @break

                                                        @case('canceled')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('canceled') }}</span>
                                                        @break

                                                        @case('in the mandatory period')
                                                            <span
                                                                class="badge badge-info badge-lg">{{ __('in the mandatory period') }}</span>
                                                        @break

                                                        @case('returned')
                                                            <span
                                                                class="badge badge-danger badge-lg">{{ __('returned') }}</span>
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
                                                <td><small>{{ $order->created_at }}</small></td>
                                                <td><small>{{ $order->updated_at }}</small></td>


                                                <td class="project-actions">

                                                    <a style="color:#ffffff" class="btn btn-primary btn-sm"
                                                        href="{{ route('vendor.order.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}">
                                                        {{ __('Order Display') }}
                                                    </a>



                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                <div class="row mt-3"> {{ $vorders->appends(request()->query())->links() }}</div>
                            @else
                                <h3 class="pl-2">{{ __('You do not have orders to view') }}</h3>
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


    @endif



    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header">
                {{ __('Messages') }}
            </div>
            <ul class="list-group list-group-flush">
                @if ($user->messages->count() > 0)
                    @foreach ($user->messages as $message)
                        <li class="list-group-item">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="image">
                                        <a href="{{ route('users.show', [app()->getLocale(), $message->sender_id]) }}">
                                            <img src="{{ asset('storage/images/users/' . $message->profile) }}"
                                                class="img-circle elevation-2" alt="User Image"
                                                style="width:20%; margin:5px">
                                        </a>
                                        @php
                                            $date = Carbon\Carbon::now();
                                            $interval = $message->created_at->diffForHumans($date);
                                        @endphp
                                        <span style="direction: ltr !important"
                                            class="badge badge-success">{{ $interval }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p style="padding-top: 18px">
                                        {{ $message->message }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-sm btn-danger"
                                        href="{{ route('messages.delete', ['lang' => app()->getLocale(), 'message' => $message->id]) }}">{{ __('Delete') }}</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li class="list-group-item">
                        {{ __('There are no messages at the moment') }}
                    </li>
                @endif


                <li class="list-group-item">
                    <form method="POST"
                        action="{{ route('messages.admin.send', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="message"
                                class="col-md-2 col-form-label text-md-right">{{ __('Message') }}</label>

                            <div class="col-md-10">
                                <input id="message" type="text" class="form-control @error('message') is-invalid @enderror"
                                    name="message" value="{{ old('message') }}" required autocomplete="message"
                                    autofocus>

                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-10 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Message') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </li>

            </ul>
        </div>
    </div>

    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->







    </section>
    <!-- /.content -->








@endsection
