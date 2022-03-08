@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2"  style="margin-top: 100px">
    <div class="container page__container">
        {{-- <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Password Reset Request') }}</div>
        </div> --}}

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{__('Enter the mobile number')}}</div>
                    <div class="card-body">
                        <p>{{__('Please enter the mobile number that you registered with')}}</p>

                        <div class="d-flex justify-content-center">
                            <div class="col-8">
                                <form method="post" action="{{ route('password.reset.verify' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id] ) }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                        <div class="col-md-8">
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row" style="display:none">
                                        <label for="phone_hide" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                        <div class="col-md-6">
                                            <input id="phone_hide" type="text" class="form-control @error('phone_hide') is-invalid @enderror" name="phone_hide" value="{{ old('phone_hide') }}" required autofocus>

                                            @error('phone_hide')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">{{__('Change the password')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
