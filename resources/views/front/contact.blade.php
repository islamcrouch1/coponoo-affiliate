@extends('layouts.front.app')

@section('content')
    <div class="breadcrumb-area water-effect jquery-ripples">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h1 class="page-title">{{ __('Contact') }}</h1>
                        <ul class="page-list">
                            <li><a href="{{ route('home.front', app()->getLocale()) }}">{{ __('Home') }}</a><i
                                    class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                            <li>{{ __('Contact') }}</li>
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
                <div class="col-lg-3 align-self-center">
                    <div class="contact-touch">
                        <div class="title">
                            {{ __('Phone Number') }}
                        </div>
                        <span style="direction: ltr !important">+20 109 466 6865</span>
                        <div class="title">
                            {{ __('Email') }}
                        </div>
                        <span>Info@Sonoo.com</span>
                        <div class="title">
                            {{ __('Address') }}
                        </div>
                        <span
                            class="mb-0">{{ __('3, 26th of July Street, second floor, Flat 25, in front of Al-Hawari, Lebanon Square, above the pharmacy, Dr. Amira, Al-Muhandseen') }}</span>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-3">
                    <!-- Sectop - Map -->
                    <div class="contact-map">
                        <div class="embed-responsive embed-responsive-21by9">
                            <div class="embed-responsive-item d-flex flex-column justify-content-center">
                                <iframe id="mapcanvas"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.449033681021!2d31.2432972149728!3d30.052660781879318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145840960a775b41%3A0xfd2f355c9fc375f3!2zMyAyNiDZitmI2YTZitmI2IwgT3JhYnksIEFiZGVlbiwgQ2Fpcm8gR292ZXJub3JhdGU!5e0!3m2!1sen!2seg!4v1637431424568!5m2!1sen!2seg"></iframe>
                            </div>
                        </div>
                    </div>
                    <!-- Sectop - Map -->
                </div>
                <div class="col-lg-12">
                    <div class="blog-comment-form">
                        <div class="title">
                            {{ __('Send Message') }}
                        </div>
                        <form class="text-center">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="{{ __('Name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="{{ __('Email') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="{{ __('Website') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="{{ __('Your Message') }}" rows="8"></textarea>
                            </div>

                            <button type="submit" class="common-btn">{{ __('Send') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
