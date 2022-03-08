@extends('layouts.front.app')



@section('content')


<div class="page-section border-bottom-2"  style="margin-top: 100px">
    <div class="container page__container">
        {{-- <div class="page-separator pt-1 pb-1">
            <div class="page-separator__text">{{ __('Mobile Number Verification') }}</div>
        </div> --}}

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{__('Verify your phone')}}</div>
                    <div class="card-body">
                        <p>{{__('Thanks for registering with our platform. We will send you to verify your phone number. Provide the code below.')}}</p>

                        <div class="d-flex justify-content-center">
                            <div class="col-8">
                                <form method="post" action="{{ route('phoneverification.verify' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id] ) }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" type="text" placeholder="{{__('Verification Code')}}" required autofocus>
                                        @if ($errors->has('code'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary">{{__('Verify Phone')}}</button>
                                    </div>
                                </form>
                                <a class="resend" style="pointer-events:none" href="{{route('resend-code' , ['lang'=>app()->getLocale() , 'country'=>$scountry->id , 'user'=>Auth::id()])}}">{{__('Resend Code')}} (<span class="counter_down"></span>) </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection





@push('scripts-front')

    <script>







    </script>

@endpush
