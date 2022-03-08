@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>addresses</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">addresses</li>
                <li class="breadcrumb-item active">Edit addresses</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add addresses') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('addresses.update' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-12 col-form-label">Country : {{ $user->country->name_en }}</label>
                        </div>

                        <div class="form-group row">
                            <label for="province" class="col-md-2 col-form-label">{{ __('province') }}</label>

                            <div class="col-md-10">
                                <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ $address->province }}"  autocomplete="name" autofocus>

                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-md-2 col-form-label">{{ __('city') }}</label>

                            <div class="col-md-10">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $address->city }}"  autocomplete="name" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="district" class="col-md-2 col-form-label">{{ __('district') }}</label>

                            <div class="col-md-10">
                                <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ $address->district }}"  autocomplete="description">

                                @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="street" class="col-md-2 col-form-label">{{ __('street') }}</label>

                            <div class="col-md-10">
                                <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $address->street }}"  autocomplete="description">

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="building" class="col-md-2 col-form-label">{{ __('building number') }}</label>

                            <div class="col-md-10">
                                <input id="building" type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ $address->building }}"  autocomplete="description">

                                @error('building')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label">{{ __('phone number') }}</label>

                            <div class="col-md-10">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $address->phone }}"  autocomplete="description">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="notes" class="col-md-2 col-form-label">{{ __('notes') }}</label>

                            <div class="col-md-10">
                                <input id="notes" type="text" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ $address->notes }}"  autocomplete="description">

                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit address') }}
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
