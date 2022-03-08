@extends('layouts.dashboard.app')

@section('adminContent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Bonus') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Bonus') }}</li>
                        <li class="breadcrumb-item active">{{ __('Create bonus') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create bonus') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url(app()->getLocale() . '/dashboard/bonus') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="amount" class="col-md-2 col-form-label">{{ __('Amount') }}</label>

                                <div class="col-md-10">
                                    <input id="amount" type="number"
                                        class="form-control @error('amount') is-invalid @enderror" name="amount"
                                        value="{{ old('amount') }}" autocomplete="name" required>

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city_en" class="col-md-2 col-form-label">{{ __('End date') }}</label>

                                <div class="col-md-10">
                                    <input type="date" name="date" class="form-control" value="" required>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="type" class="col-md-2 col-form-label">{{ __('type select') }}</label>
                                <div class="col-md-10">
                                    <select class=" form-control @error('type') is-invalid @enderror" id="type" name="type"
                                        required>
                                        <option value="all">{{ __('All') }}</option>
                                        <option value="affiliate">{{ __('Affiliate') }}</option>
                                        <option value="vendor">{{ __('Vendor') }}</option>

                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add bonus') }}
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
