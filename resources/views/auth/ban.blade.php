@extends('layouts.front.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>



                @isset($status)
                <div class="alert alert-danger" role="alert">
                    {{$status}}
                </div>
                @endisset


            </div>
        </div>
    </div>
</div>
@endsection
