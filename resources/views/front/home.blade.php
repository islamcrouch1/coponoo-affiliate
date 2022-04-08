@extends('layouts.front.app')

@section('content')



    <!-- Banner Area Start-->
    <section class="banner-area-3" style="background-image: url({{ asset('storage/img/banner/bg-3.png') }});">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="{{ asset('storage/images/1.png') }}" alt="img">
                </div>
                <div class="col-lg-5 offset-lg-1 col-sm-10 align-self-center">
                    <div class="banner-inner">
                        <h1 style="font-size: 34px">{{ __('A new beginning for your personal project.') }} <br>
                            {{ __('Increase your income from any where. ') }} <br>
                            {{ __('We are specialists in e-commerce and affiliate marketing.') }} <br>
                            {{ __('Your commission with us is guaranteed! And you won\'t need to work twice! ') }} </h1>
                        <p>{{ __('Sonoo is an affiliate marketing platform with integrated services (we provide you with the right products, warehousing, shipping, and fulfillment)') }}
                        </p>
                        {{-- <a href="index.html" class="btn btn-app"><img src="{{ asset('storage/img/btn/goggle-btn-transparent.png') }}" alt="img"></a>
                        <a class="btn btn-app active m-0" href="index.html"><img src="{{ asset('storage/img/btn/app-store-btn-transparent.png') }}" alt="img"></a> --}}

                        <a href="{{ route('register', ['lang' => app()->getLocale()]) }}"
                            class="btn btn-app  m-0 active">{{ __('Join us now') }}</a>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- featured-Area Start-->
    <div class="featured-area pd-top-150">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 offset-xl-1 col-lg-5 align-self-center align-self-xl-start d-none d-lg-block">
                    <div class="thumb me-5 span3 wow rollIn">
                        <img src="{{ asset('storage/img/featured/1.png') }}" alt="img">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-8 col-md-10 col-sm-11">
                    <div class="section-title">
                        <h2 class="title">{{ __('Why Sonoo?') }}</h2>
                        <p>{{ __('The power of your trade mark is our main goal! With no extra commission and no conditions that would prevent the product from running easliy. ') }}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="single-featured-wrap">
                                <div class="thumb text-al">
                                    <img src="{{ asset('storage/img/featured/1i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4 class="text-al">{{ __('Ask and leave the rest for us! ') }}</h4>
                                    <p class="text-al">
                                        {{ __('Ask and let Sonoo\'s team do their magic until your order is delivered to your customer.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="single-featured-wrap">
                                <div class="thumb text-al">
                                    <img src="{{ asset('storage/img/featured/2i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4 class="text-al">{{ __('You will not need capital. ') }}</h4>
                                    <p class="text-al">
                                        {{ __('With no risk or many complications...Start Marketing for a product of your own choice! ') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="single-featured-wrap">
                                <div class="thumb text-al">
                                    <img src="{{ asset('storage/img/featured/3i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4 class="text-al">{{ __('Way higher commission. ') }}</h4>
                                    <p class="text-al">
                                        {{ __('You will get a satisfying commission with every product sold! ') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="single-featured-wrap">
                                <div class="thumb text-al">
                                    <img src="{{ asset('storage/img/featured/4i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4 class="text-al">{{ __('We will train you in new ways! ') }}</h4>
                                    <p class="text-al">
                                        {{ __('Our goal is to make marketing easy for you! Because you are a member of Sonoo...You are one of our team.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="single-featured-wrap d-1400-none display-lg-block">
                                <div class="thumb">
                                    <img src="{{ asset('storage/img/featured/5i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4>Users Forum</h4>
                                    <p>Led all cottage met enabled attempt through talking delight.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="single-featured-wrap d-1400-none display-lg-block">
                                <div class="thumb">
                                    <img src="{{ asset('storage/img/featured/6i.png') }}" alt="img">
                                </div>
                                <div class="featured-wrap-details">
                                    <h4>24/7 Support</h4>
                                    <p>Led all cottage met enabled attempt through talking delight.</p>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- featured-Area End-->

    <!-- upcoming-featured-Area Start-->
    <div class="upcoming-featured-area pd-top-120 pd-bottom-120">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 offset-md-1 col-md-6 col-sm-10 align-self-center">
                    <div class="ps-5 ms-5">
                        <div class="section-title">
                            <h2 class="title">{{ __('Fully integrated E-commerce platform. ') }}</h2>
                            {{-- <p>{{__('Kobono is an e-platform with integrated services for merchants (providing the right product, storage, shipping, and delivery to the customer)')}}</p> --}}
                        </div>
                        <ul class="pl-list-inner style-1">
                            <li><i class="fa fa-check"></i>{{ __('Easy to use control panel') }}</li>
                            <li><i class="fa fa-check"></i>{{ __('Easily monitor your commission and income. ') }}</li>
                            <li><i class="fa fa-check"></i>{{ __('Easy to track your orders. ') }}</li>
                            <li><i class="fa fa-check"></i>{{ __('Monitor the stock and add products.') }}</li>
                            <li><i class="fa fa-check"></i>{{ __('Submit orders in easy and simple steps. ') }}</li>
                            <li><i
                                    class="fa fa-check"></i>{{ __('Fully integrated notification system to follow up with your orders.') }}
                            </li>
                            <li><i class="fa fa-check"></i>{{ __('Live customer service team.') }}</li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 d-none d-md-block align-self-center">
                    <div class="thumb me-5 span3 wow rollInRight">
                        <img src="{{ asset('storage/img/featured/2.png') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- upcoming-featured-Area End-->

    <!-- intro-Area Start-->
    <section class="intro-area text-center pd-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-intro-wrap">
                        <div class="thumb">
                            <img src="{{ asset('storage/img/intro/1.png') }}" alt="img">
                        </div>
                        <h4><a href="#">{{ __('Start for free') }}</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-intro-wrap">
                        <div class="thumb">
                            <img src="{{ asset('storage/img/intro/2.png') }}" alt="img">
                        </div>
                        <h4><a href="#">{{ __('Easy to use') }}</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-intro-wrap">
                        <div class="thumb">
                            <img src="{{ asset('storage/img/intro/3.png') }}" alt="img">
                        </div>
                        <h4><a href="#">{{ __('Manage products and orders') }}</a></h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-intro-wrap">
                        <div class="thumb">
                            <img src="{{ asset('storage/img/intro/4.png') }}" alt="img">
                        </div>
                        <h4><a href="#">{{ __('Continuous updates') }}</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- intro-Area End-->

    <!-- fact-count-Area start-->
    {{-- <section class="fact-count-area text-center">
        <div class="container">
            <div class="fact-inner">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-fact-inner">
                            <h2><span class="counter">50</span>K</h2>
                            <h4>Happy Users</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-fact-inner">
                            <h2 class="counter">5462</h2>
                            <h4>Awesome Design</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-fact-inner">
                            <h2><span class="counter">75</span>K</h2>
                            <h4>Downloads</h4>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-fact-inner">
                            <h2 class="counter">4.6</h2>
                            <h4>App Rating</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- fact-count-Area End-->

    <!--Screenshot-area-->
    {{-- <section class="screenshot-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <h2 class="title">Our App Screenshots</h2>
                        <p>Delay rapid joy share allow age manor six. Went why far saw many knew.</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="screenshot-slider slick-carousel ps-4 pe-4">
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/01.png" alt="app">
                            </div>
                        </div>
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/02.png" alt="app">
                            </div>
                        </div>
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/03.png" alt="app">
                            </div>
                        </div>
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/04.png" alt="app">
                            </div>
                        </div>
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/05.png" alt="app">
                            </div>
                        </div>
                        <div class="item">
                            <div class="screenshot-thumb">
                                <img src="img/screenshot/04.png" alt="app">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--Screenshot-area end-->

    <!-- video-Area start-->

    {{-- <div class="video-inner">
                        <img src="{{ asset('storage/img/other/video.png') }}" alt="img">
                        <a class="play-btn" href="https://www.youtube.com/embed/Wimkqo8gDZ0" data-effect="mfp-zoom-in"><img src="{{ asset('storage/img/icon/play.png') }}" alt="img"></a>
                    </div> --}}



    @if ($slides->count() != 0)
        <section class="video-area text-center pd-bottom-120 mt-ng-105"
            style="background: url({{ asset('storage/img/other/2.png') }}); margin-top:30px">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-10">
                        <div style="text-align: center !important" class="section-title mb-0 pb-5 text-center">
                            <h2 style="text-align: center !important" class="title">{{ __('Sonoo Platform') }}
                            </h2>
                            <p style="text-align: center !important">
                                {{ __('Sonoo..Everything your work needs, All the facilities to convince your customers.') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-11">

                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($slides as $key => $slide)
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"
                                        aria-current="{{ $key == 0 ? 'true' : '' }}"
                                        aria-label="Slide {{ $key + 1 }}"></button>
                                @endforeach
                            </div>

                            <div style="height:600px" class="carousel-inner">
                                @foreach ($slides as $key => $slide)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <a target="_blank" href="{{ url('//' . $slide->url) }}">
                                            <img style="width: 100% ; height:600px"
                                                src="{{ asset('storage/' . $slide->image) }}" class="d-block w-100"
                                                alt="{{ $slide->url }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif





    <!-- video-Area End-->

    <!--Pricing-area-->
    {{-- <section class="pricing-area text-center pd-top-140 pd-bottom-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section-title">
                        <h2 class="title">Pricing Plans</h2>
                        <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single-price">
                        <h4 class="pricing-title">Free</h4>
                        <div class="thumb">
                            <img src="img/pricing/price-1.png" alt="img">
                        </div>
                        <ul class="pricing-list text-start">
                            <li><a href="#"><i class="fa fa-check"></i> Total Users1</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Unlimitted Styles</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Advanced Protection</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Cloud Storage</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> 24/7 Customer Service</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Backup Service</a></li>
                        </ul>
                        <a class="btn btn-blue" href="index.html"><i class="fa fa-shopping-cart"></i>ORDER NOW</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-price style-1">
                        <h4 class="pricing-title">Basic</h4>
                        <div class="thumb">
                            <img src="img/pricing/price-2.png" alt="img">
                        </div>
                        <ul class="pricing-list text-start">
                            <li><a href="#"><i class="fa fa-check"></i> Total Users1</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Unlimitted Styles</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Advanced Protection</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Cloud Storage</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> 24/7 Customer Service</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Backup Service</a></li>
                        </ul>
                        <a class="btn btn-orange" href="index.html"><i class="fa fa-shopping-cart"></i>ORDER NOW</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-price style-2">
                        <h4 class="pricing-title">Premium</h4>
                        <div class="thumb">
                            <img src="img/pricing/price-3.png" alt="img">
                        </div>
                        <ul class="pricing-list text-start">
                            <li><a href="#"><i class="fa fa-check"></i> Total Users1</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Unlimitted Styles</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Advanced Protection</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Cloud Storage</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> 24/7 Customer Service</a></li>
                            <li><a href="#"><i class="fa fa-check"></i> Backup Service</a></li>
                        </ul>
                        <a class="btn btn-blue" href="index.html"><i class="fa fa-shopping-cart"></i>ORDER NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!--Pricing-area end-->

    <!-- network-Area Start-->
    {{-- <section class="network-area pd-top-140">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 d-none d-md-block align-self-end">
                    <div class="thumb me-5 span3 wow rollIn">
                        <img src="img/other/3.png" alt="img">
                    </div>
                </div>
                <div class="col-lg-5 col-md-8 col-sm-10 align-self-center">
                    <div class="section-title mb-0 pb-5 text-center text-lg-start">
                        <h2 class="title">Its Easily Work With Faster Wireless 5G Network</h2>
                        <p>Delay rapid joy share allow age manor six. Went why far saw many. On disposal of as landlord horrible. Afraid at highly months do.</p>
                    </div>
                    <ul class="pl-list-inner style-1 text-center text-lg-start">
                        <li><i class="fa fa-check"></i>Delay rapid joy share allow age manor six.</li>
                        <li><i class="fa fa-check"></i>Exquisite excellent son gentleman acuteness her.</li>
                        <li><i class="fa fa-check"></i>Went why far saw many knew.</li>
                        <li><i class="fa fa-check"></i>Friendly as stronger speedily by recurred.</li>
                        <li><i class="fa fa-check"></i>Son interest wandered sir addition end say.</li>
                    </ul>
                </div>
                <div class="col-lg-2 d-none d-xl-block align-self-end">
                    <div class="thumb span3 wow rollInRight">
                        <img src="img/other/4.png" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- network-Area End-->

    <!-- testimonial-Area Start-->
    {{-- <div class="testimonial-area pd-top-140">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-11">
                    <div class="section-title text-center">
                        <h2 class="title">50K+ Happy Clients <br>All Around The World</h2>
                        <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-slider slick-carousel">
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/1.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Theodor Baldwin</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/02.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Bryson Durham</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/3.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Emrys Rosas</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/1.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Theodor Baldwin</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/02.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Bryson Durham</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-testimonial-inner text-center">
                        <div class="thumb">
                            <img src="img/testimonial/3.png" alt="img">
                        </div>
                        <div class="details">
                            <img class="quote-icon" src="img/testimonial/2.png" alt="img">
                            <p>Delay rapid joy share allow age manor six. Went why far saw many knew. Exquisite excellent son gentleman acuteness her.</p>
                            <div class="rating-inner">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h6>Emrys Rosas</h6>
                            <span class="date">JULY 28, 2020</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- testimonial-Area End-->





    <!-- Modal -->
    <div style="{{ app()->getLocale() == 'ar' ? 'direction: rtl; text-align: right' : '' }}" class="modal fade"
        id="frontModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ setting('modal_1_title') }}</h5>
                    <button style="{{ app()->getLocale() == 'ar' ? 'margin:0' : '' }}" type="button"
                        class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    {{ setting('modal_1_body') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


@endsection
