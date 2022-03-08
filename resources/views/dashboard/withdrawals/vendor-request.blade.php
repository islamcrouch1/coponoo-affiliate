@extends('layouts.dashboard.app')

@section('adminContent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('New withdrawal request') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Withdrawals Requests') }}</li>
                        <li class="breadcrumb-item active">{{ __('New withdrawal request') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-6">
                    <!-- small box -->

                    <div class="alert alert-danger" role="alert">
                        {{ __('Please note that the minimum withdrawal amount is 200') . ' ' . $user->country->currency }}
                    </div>
                </div>

                <br>

                <div class="col-md-6">
                    <!-- small box -->

                    <div class="alert alert-primary" role="alert">
                        {{ __('Available balance for withdrawal in your account : ') .($user->balance->available_balance + $user->balance->bonus) .' ' .$user->country->currency }}
                    </div>
                </div>

            </div>
        </div>

    </section>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('New withdrawal request') }}</div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('withdrawals.vendor.store', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="amount" class="col-md-2 col-form-label">{{ __('Amount') }}</label>

                                <div class="col-md-10">
                                    <input id="amount" type="number" min="200"
                                        max="{{ $user->balance->available_balance + $user->balance->bonus }}"
                                        class="form-control @error('amount') is-invalid @enderror" name="amount" value="200"
                                        autocomplete="name" autofocus>

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-2 col-form-label">{{ __('Payment Type') }}</label>

                                <div class="col-md-10">
                                    <select class=" form-control @error('type') is-invalid @enderror" id="type" name="type"
                                        value="{{ old('type') }}" required autocomplete="type">
                                        <option value="1">{{ __('Vodafone Cash') }}</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="data" class="col-md-2 col-form-label">{{ __('Payment data') }}</label>

                                <div class="col-md-10">
                                    <input id="data" type="text"
                                        placeholder="{{ __('Please write your payment information correctly. We are not responsible for any error in the data ..............') }}"
                                        class="form-control @error('data') is-invalid @enderror" name="data"
                                        value="{{ old('data') }}" autocomplete="name" autofocus>

                                    @error('data')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="code" class="col-md-2 col-form-label">

                                    <button id="send-conf"
                                        data-url="{{ route('send.conf', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                                        type="submit" class="btn btn-primary btn-sm">

                                        <span id="loader-conf" style="display:none; color:#ffffff; padding:5px "
                                            class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </span>

                                        {{ __('Send Confirmation Code') }}

                                        (<span class="counter_down"></span>)

                                    </button>

                                </label>

                                <div class="col-md-10">
                                    <input id="code" type="text"
                                        placeholder="{{ __('Please enter the confirmation code') }}"
                                        class="form-control @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code') }}" autocomplete="code" required autofocus>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>






                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
