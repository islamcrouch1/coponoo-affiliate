@extends('layouts.dashboard.app')

@section('adminContent')

    <section class="content">


        @if ($slides1->count() != 0)
            <div class="row p-2">
                <div class="col-md-12">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides1 as $key => $slide)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($slides1 as $key => $slide)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <a target="_blank" href="{{ url('//' . $slide->url) }}">
                                        <img class="d-block w-100" src="{{ asset('storage/' . $slide->image) }}"
                                            alt="{{ $slide->url }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </section>


    <div class="container page__container" style="">



        <div class="content-gummla">



            <div class="page-separator pt-3 pb-3">
                @if (!isset($scategory))
                    <div style="text-align: center" class="page-separator__text">
                        <h2>
                            {{ __('Products Categories') }}
                        </h2>
                    </div>
                @else
                    <div style="text-align: center" class="page-separator__text">
                        <h2>
                            {{ __('Subcategories : ') }}
                            {{ app()->getLocale() == 'ar' ? $scategory->name_ar : $scategory->name_en }}
                        </h2>

                    </div>
                @endif
            </div>

            <div class="row card-group-row Sonoo">



                @foreach ($categories as $category)
                    <div style="" class="col-md-2 col-sm-4 col-3 card-group-row__col">


                        <div style="text-align: center" class="card">
                            <a
                                href="{{ route('products.affiliate.cat', ['lang' => app()->getLocale(), 'category' => $category->id]) }}">
                                <img style="width:100%;"
                                    src="{{ asset('storage/images/categories/' . $category->image) }}"
                                    alt="{{ app()->getLocale() == 'ar' ? $category->description_ar : $category->description_en }}"
                                    class=" p-2 img-responsive center-block d-block mx-auto"></a>

                            <div class="cat-title">

                                <div style="text-align: center" class="mb-1">
                                    <a
                                        href="{{ route('products.affiliate.cat', ['lang' => app()->getLocale(), 'category' => $category->id]) }}">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</a>
                                </div>
                            </div>
                        </div>


                    </div>
                @endforeach

            </div>




        </div>




    </div>


    <section class="content">


        @if ($slides2->count() != 0)
            <div class="row p-2">
                <div class="col-md-12">

                    <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides2 as $key => $slide)
                                <li data-target="#carouselExampleIndicators1" data-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($slides2 as $key => $slide)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <a target="_blank" href="{{ url('//' . $slide->url) }}">
                                        <img class="d-block w-100" src="{{ asset('storage/' . $slide->image) }}"
                                            alt="{{ $slide->url }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="page-separator pt-3 pb-3">
            <div style="text-align: center" class="page-separator__text">
                <h2>
                    {{ __('Products') }}
                </h2>
            </div>
        </div>


        <div class="row mb-2">
            <div class="col-md-12 col-sm-12">
                <form id="search-form" action="">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <a href="#" class="search-form-a">
                                <span style="border-radius:0" class="input-group-text"
                                    id="inputGroup-sizing-default">{{ __('Search') }}</span>
                            </a>
                        </div>
                        <input style="border-radius:0" type="text" name="search"
                            placeholder="{{ __('Search by product name, description, or SKU...') }}"
                            value="{{ request()->search }}" class="form-control" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default">
                    </div>
                </form>
            </div>
        </div>


        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">

                    @if ($products->count() == 0)
                        <div class="col-md-12">
                            <p>{{ __('There are currently no products to display in this section... Please check back later') }}
                            </p>
                        </div>
                    @else
                        @foreach ($products as $product)
                            @php
                                $stocks = 0;
                            @endphp

                            @foreach ($product->stocks as $stock)
                                @php
                                    $stocks += $stock->stock;
                                @endphp
                            @endforeach


                            @if ($stocks != 0)
                                <div class="col-md-3 mb-4">

                                    @if ($product->images->count() != 0)
                                        @php
                                            $url = $product->images[0]->url;
                                        @endphp
                                    @else
                                        @php
                                            $url = 'place-holder.png';
                                        @endphp
                                    @endif

                                    <div class="p-1" style="border: 1px solid #ddd; border-radius:5px">
                                        <div class="card-container d-flex flex-column justify-content-between">

                                            <a style="position: relative" class="product-a"
                                                href="{{ route('products.affiliate.view', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                <img style="width:100%; height:100%;"
                                                    src="{{ asset('storage/images/products/' . $url) }}" alt="">

                                                <div style="position: absolute; bottom:0; right: 0; margin:3px">
                                                    <span
                                                        class="badge badge-primary">{{ 'SKU: ' . $product->SKU }}</span>
                                                </div>
                                            </a>

                                        </div>

                                        <div>
                                            <p style="font-size: 27px; height:60px" class="text-lg m-1 mb-4">
                                                {{ app()->getLocale() == 'ar'? substr($product->name_ar, 0, 100) . '...': substr($product->name_en, 0, 100) . '...' }}
                                            </p>
                                        </div>

                                        <div class="row m-1">
                                            @php
                                                $sPrice = ceil(($product->min_price * setting('commission')) / 100);
                                                $sPrice = $sPrice + $product->min_price;
                                            @endphp
                                            <div class="col-md-6">
                                                <span style="font-size: 25px">{{ $sPrice }}</span>
                                                {{ ' ' . $product->country->currency }}
                                            </div>
                                            <div style="text-align:left" class="col-md-6">
                                                {{ __('Profit ') . ': ' }} <span
                                                    style="font-size: 23px; color:#007bff; ">{{ $sPrice - $product->min_price }}</span>
                                            </div>
                                        </div>

                                        <div style="text-align:center" class="p-2 mt-4 mb-1">

                                            <a style="width: 70%; border-radius:50px" class="btn btn-primary"
                                                href="{{ route('products.affiliate.view', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">{{ __('View product') }}
                                            </a>
                                            <a class="add-fav" href="" style="width: 20%; margin:7px"
                                                data-id="{{ $product->id }}"
                                                data-url="{{ route('fav.add', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'product' => $product->id]) }}"><i
                                                    style="font-size:29px"
                                                    class="{{ 'fav-' . $product->id }} {{ Auth::user()->fav()->where('product_id', $product->id)->where('user_id', Auth::id())->get()->count() == 0? 'far': 'fas' }} fa-heart fa-lg"></i></a>

                                        </div>

                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

        <div class="row m-3"> {{ $products->appends(request()->query())->links() }}</div>

    </section>
    <!-- /.content -->

    <section class="content">

        @if ($slides3->count() != 0)
            <div class="row p-2">
                <div class="col-md-12">

                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides3 as $key => $slide)
                                <li data-target="#carouselExampleIndicators2" data-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($slides3 as $key => $slide)
                                <div style="height: 45%" class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <a target="_blank" href="{{ url('//' . $slide->url) }}">
                                        <img class="d-block w-100" src="{{ asset('storage/' . $slide->image) }}"
                                            alt="{{ $slide->url }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </section>

@endsection
