
@extends('layouts.front.app')

@section('content')

<div class="breadcrumb-area water-effect jquery-ripples">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner text-center">
                    <h1 class="page-title">{{__('Terms and Conditions')}}</h1>
                    <ul class="page-list">
                        <li><a href="{{route('home.front' , app()->getLocale())}}">{{__('Home')}}</a><i class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                        <li>{{__('Terms and Conditions')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner area end-->

<div class="contact-page pd-bottom-100">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-sm-12">
                <div class="section-title mb-0 pb-5 {{app()->getLocale() == 'ar' ? 'text-align:right' : 'text-align:left'}} ">
                    <h2 class="title">{{__('Terms and Conditions')}}</h2>
                    <p>
                    @if (app()->getLocale() == 'ar')
                    {!!setting('terms_ar')!!}
                    @else
                    {!!setting('terms_en')!!}
                    @endif
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>




@endsection
