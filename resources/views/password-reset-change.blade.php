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
                    <div class="card-header">{{__('Enter the new password')}}</div>
                    <div class="card-body">

                        <div class="d-flex justify-content-center">
                            <div class="col-8">
                                <form method="post" action="{{ route('password.reset.confirm.password' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id , 'user'=> $user->id] ) }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-8">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-8">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
