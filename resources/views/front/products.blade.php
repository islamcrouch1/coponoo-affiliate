@extends('layouts.front.app')

@section('content')
    <div class="breadcrumb-area water-effect jquery-ripples">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h1 class="page-title">{{ __('Our Products') }}</h1>
                        <ul class="page-list">
                            <li><a href="{{ route('home.front', app()->getLocale()) }}">{{ __('Home') }}</a><i
                                    class="fa fa-angle-double-right" aria-hidden="true"></i></li>
                            <li>{{ __('Our Products') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Banner area end-->

    <div class="bg-image-3" style="background: url({{ asset('storage/img/other/9.png') }});">
        <div style="padding-bottom:120px" class="product-area pd-top-145">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-10">
                        <div class=" mb-0 pb-5 text-center">
                            <h3 class="title">{{ __('We Have Many Products You Can Choose From There') }}</h3>
                            {{-- <p>Delay rapid joy share allow age manor six. Went why far saw many knew.</p> --}}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">

                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-product-inner">
                                <div style="height: 356px" class="thumb text-center">
                                    <img style="width:100%; height:100%;"
                                        src="{{ asset('storage/images/products/' . $product->images[0]->url) }}"
                                        alt="img">
                                </div>
                                <div class="details">
                                    <a class="product-title"
                                        href="#">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</a>
                                    <div class="row mt-2">
                                        <div class="col-8 align-self-center">
                                            @auth
                                                @if (Auth::user()->hasRole('affiliate'))
                                                    <a class="product-order"
                                                        href="{{ route('products.affiliate.view', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"><i
                                                            class="fa fa-shopping-cart"></i>{{ __('View product') }}</a>
                                                @else
                                                    <a class="product-order" href="#"><i
                                                            class="fa fa-shopping-cart"></i>{{ __('View product') }}</a>
                                                @endif
                                            @endauth
                                            @guest
                                                <a class="product-order"
                                                    href="{{ route('login', ['lang' => app()->getLocale()]) }}"><i
                                                        class="fa fa-shopping-cart"></i>{{ __('View product') }}</a>
                                            @endguest
                                        </div>
                                        <div class="col-4 text-end">
                                            @php
                                                $sPrice = ceil(($product->min_price * setting('commission')) / 100);
                                                $sPrice = $sPrice + $product->min_price;
                                            @endphp
                                            <p class="amount"><span
                                                    style="font-size: 25px">{{ $sPrice }}</span>
                                                {{ ' ' . $product->country->currency }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>


                <div class="row m-3"> {{ $products->appends(request()->query())->links() }}</div>


            </div>
        </div>

    </div>
@endsection
