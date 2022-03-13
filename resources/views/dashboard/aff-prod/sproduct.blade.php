@extends('layouts.dashboard.app')

@section('adminContent')







    <!-- Main content -->
    <section class="content">

        @php
            $stocks = 0;
        @endphp

        @foreach ($product->astocks->where('order_id', $order->id) as $stock)
            @php
                $stocks += $stock->stock;
            @endphp
        @endforeach


        @if ($stocks != 0)


            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-right' : 'float-sm-left' }}">
                                <li class="breadcrumb-item"> <a
                                        href="{{ route('products.affiliate', app()->getLocale()) }}">{{ __('All Products') }}</a>
                                </li>


                                @php
                                    $cats = [];
                                    
                                @endphp

                                @if ($product->categories()->first()->parent != 'null')
                                    @php
                                        $cat = \App\Category::where('id', $product->categories()->first()->id)->first();
                                    @endphp


                                    @while ($cat->parent != 'null')
                                        @php
                                            array_push($cats, $cat->parent);
                                            $cat = \App\Category::where('id', intval($cat->parent))->first();
                                        @endphp
                                    @endwhile

                                    @foreach (array_reverse($cats) as $cat)
                                        @php
                                            $cat = \App\Category::where('id', intval($cat))->first();
                                        @endphp
                                        <li class="breadcrumb-item"> <a
                                                href="{{ route('products.affiliate.cat', ['lang' => app()->getLocale(), 'category' => $cat->id]) }}">{{ app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en }}</a>
                                        </li>
                                    @endforeach

                                    @php
                                        $cat = \App\Category::where('id', request()->parent)->first();
                                    @endphp

                                    <li class="breadcrumb-item active"> <a
                                            href="{{ route('products.affiliate.cat', ['lang' => app()->getLocale(),'category' => $product->categories()->first()->id]) }}">{{ app()->getLocale() == 'ar'? $product->categories()->first()->name_ar: $product->categories()->first()->name_en }}</a>
                                    </li>
                                    <li class="breadcrumb-item"> <a
                                            href="">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item active"> <a
                                            href="{{ route('products.affiliate.cat', ['lang' => app()->getLocale(),'category' => $product->categories()->first()->id]) }}">{{ app()->getLocale() == 'ar'? $product->categories()->first()->name_ar: $product->categories()->first()->name_en }}</a>
                                    </li>
                                    <li class="breadcrumb-item"> <a
                                            href="">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</a>
                                    </li>
                                @endif

                            </ol>
                        </div>


                        @if ($product->images->count() != 0)
                            @php
                                $url = $product->images[0]->url;
                            @endphp
                        @else
                            @php
                                $url = 'place-holder.png';
                            @endphp
                        @endif


                        <div class="col-12 col-sm-6">
                            <h3 class="my-3 mr-2 ml-2">
                                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h3>
                            <h3 class="d-inline-block d-sm-none">
                                {{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}</h3>
                            <div class="col-10"
                                style="height: 400px; border: 1px solid #dcdbdb; border-radius:10px">
                                <img id="pruduct-image{{ $product->id }}" style="width: 100%; height:100%"
                                    src="{{ asset('storage/images/products/' . $url) }}"
                                    class="rounded product-image product-id-{{ $product->id }}" alt="Product Image">
                            </div>

                            <div class="col-10 product-image-thumbs">

                                <div id="allImages" style="width: 100%; " class="row">

                                    @foreach ($product->images as $index => $image)
                                        <div class="col-md-2"
                                            style="margin-top: 5px; padding-right: 3px ; padding-left:3px">
                                            <div id="image-{{ $image->url }}"
                                                style="width: 100%; height:100%; margin-right:0px"
                                                class="product-image-thumb product-{{ $product->id }} active"
                                                data-id="{{ $product->id }}"><img
                                                    src="{{ asset('storage/images/products/' . $image->url) }}"
                                                    alt="Product Image"></div>

                                        </div>
                                    @endforeach


                                    @foreach ($product->astocks->where('order_id', $order->id) as $stock)
                                        @php
                                            $stocks = $product->astocks
                                                ->where('order_id', $order->id)
                                                ->unique('color_id')
                                                ->values();
                                        @endphp
                                    @endforeach

                                    @foreach ($stocks as $stock)
                                        @if ($stock->image != null)
                                            <div class="col-md-2" style="margin-top: 5px">
                                                <div id="image-{{ $stock->color->color_en }}"
                                                    style="width: 100%; height:100%; margin-right:0px"
                                                    class="product-image-thumb product-{{ $stock->product->id }} active"
                                                    data-id="{{ $stock->product->id }}"><img
                                                        src="{{ asset('storage/images/products/' . $stock->image) }}"
                                                        alt="Product Image"></div>

                                            </div>
                                        @endif
                                    @endforeach

                                </div>



                            </div>


                            <div style="width: 100%; text-align:center" class="col-10 p-2 mt-4">
                                <button onclick="downloadAll()" style="width: 80%; border-radius:50px"
                                    class="btn btn-primary">{{ __('Download all product images') }} </a>
                            </div>




                        </div>
                        <div class="col-12 col-sm-6" style="margin-top: 60px">

                            <h5>{{ __('Available Colors') }}</h5>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                @foreach ($product->astocks->where('order_id', $order->id) as $stock)
                                    @php
                                        $stocks = $product->astocks
                                            ->where('order_id', $order->id)
                                            ->unique('color_id')
                                            ->values();
                                    @endphp
                                @endforeach


                                @foreach ($stocks as $stock)
                                    @if ($stock->image != null)
                                        <label class="btn btn-default text-center labl">
                                            <input type="radio" class="color-select"
                                                data-url="{{ asset('storage/images/products/' . $stock->image) }}"
                                                data-image="{{ $stock->color->color_en }}"
                                                data-stock="{{ $stock->stock }}" data-stock_id="{{ $stock->id }}"
                                                data-color="{{ $stock->color_id }}" data-id="{{ $product->id }}"
                                                type="radio" name="stock1-select-{{ $product->id }}"
                                                value="{{ $stock->id }}" id="stock-{{ $stock->id }}">
                                            {{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}
                                            <br>
                                            <i style="color:{{ $stock->color->hex }}" class="fas fa-circle fa-2x"></i>
                                        </label>
                                    @else
                                        <label class="btn btn-default text-center labl">
                                            <input type="radio" class="color-select"
                                                data-url="{{ asset('storage/images/products/' . $url) }}"
                                                data-image="{{ $stock->color->color_en }}"
                                                data-stock="{{ $stock->stock }}" data-stock_id="{{ $stock->id }}"
                                                data-color="{{ $stock->color_id }}" data-id="{{ $product->id }}"
                                                type="radio" name="stock1-select-{{ $product->id }}"
                                                value="{{ $stock->id }}" id="stock-{{ $stock->id }}">
                                            {{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}
                                            <br>
                                            <i style="color:{{ $stock->color->hex }}" class="fas fa-circle fa-2x"></i>
                                        </label>
                                    @endif
                                @endforeach

                            </div>

                            <h5 class="mt-3">{{ __('Available Sizes') }}</h5>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                @foreach ($product->astocks->where('order_id', $order->id) as $stock)
                                    <label
                                        class="btn btn-default text-center labl-size labl-size1-{{ $product->id }} p-{{ $product->id }}-{{ $stock->color_id }}"
                                        style="{{ $stock->color_id == $stocks[0]->color_id ? 'display:inline-block;' : 'display:none' }}">
                                        <input class="stock-select" data-locale="{{ app()->getLocale() }}"
                                            data-limit={{ $product->limits()->where('product_id', $product->id)->get()->count() != 0? 'unlimited': 'limited' }}
                                            data-stock="{{ $stock->stock }}" data-stock_id="{{ $stock->id }}"
                                            data-id="{{ $product->id }}" type="radio"
                                            name="stock-select-{{ $product->id }}" value="{{ $stock->id }}"
                                            id="stock-{{ $stock->id }}">
                                        <span
                                            class="">{{ app()->getLocale() == 'ar' ? $stock->size->size_ar : $stock->size->size_en }}</span>
                                        <br>
                                        <b>{{ __('Available Quantity: ') }}<span
                                                class="av-qu-{{ $product->id }}-{{ $stock->id }}"></span></b>
                                    </label>
                                @endforeach

                            </div>


                            <h5 class="mt-3">{{ __('Enter the quantity') }}</h5>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                <div class="col-md-12">
                                    <input id="quantity" type="number" min="1" max="100"
                                        class="form-control quantity-{{ $product->id }} @error('quantity') is-invalid @enderror"
                                        name="quantity" value="1">

                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="bg-primary py-2 px-3 mt-4">
                                <h6 class="mb-0">
                                    {{ __('Minimum Price : ') .$product->min_price .' ' .$product->country->currency .' - ' .__('Maximum Price : ') .$product->max_price .' ' .$product->country->currency }}
                                </h6>
                                <br>
                                <h4 class="mt-0">
                                    <div class="form-group row">
                                        <label for="max_price" class="col-md-4">
                                            <small>{{ __('Suggested selling price') }}</small> </label>

                                        @php
                                            $sPrice = ceil(($product->min_price * setting('commission')) / 100);
                                            $sPrice = $sPrice + $product->min_price;
                                        @endphp

                                        <div class="col-md-4">
                                            <input data-locale="{{ app()->getLocale() }}" id="max_price" type="number"
                                                data-max="{{ $product->max_price }}"
                                                data-min="{{ $product->min_price }}" min="{{ $product->min_price }}"
                                                max="{{ $product->max_price }}" data-id="{{ $product->id }}"
                                                class="price-{{ $product->id }} product-price form-control @error('max_price') is-invalid @enderror"
                                                name="price-{{ $product->id }}" value="{{ $sPrice }}">

                                            @error('max_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="">
                                            <small class="m-2">{{ __('Commission') . ': ' }} <span
                                                    id="aff_comm{{ $product->id }}">{{ $sPrice - $product->min_price }}</span>
                                                {{ ' ' . $product->country->currency }} </small>
                                        </div>





                                    </div>
                                </h4>
                            </div>

                            <div style="display:none" class="m-3 alert alert-danger alarm-{{ $product->id }}"
                                role="alert">

                            </div>

                            <div style="display:none" class="m-3 alert alert-success alarm-success-{{ $product->id }}"
                                role="alert">

                            </div>

                            <div class="row">
                                @if ($order->status == 'confirmed')
                                    <div class="col-md-4">
                                        <div class="mt-4">
                                            <div class="btn btn-primary btn-lg btn-flat">


                                                <a id="cart-{{ $product->id }}" class="add-to-cart add-cart" href="#"
                                                    style="color:#ffffff"
                                                    @if (Auth::check()) data-url="{{ route('cart.add', ['lang' => app()->getLocale(), 'user' => Auth::id(), 'product' => $product->id]) }}" @endif
                                                    data-method="get" data-price="{{ $product->vendor_price }}"
                                                    data-locale="{{ app()->getLocale() }}"
                                                    data-product_country="{{ $product->country->id }}"
                                                    data-type="{{ $order->id }}"
                                                    data-user_country="{{ Auth::check() ? Auth::user()->country->id : '' }}"
                                                    data-product="loader-{{ $product->id }}"
                                                    data-cart="cart-{{ $product->id }}"
                                                    data-productid="{{ $product->id }}">
                                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> {{ __('Add to cart') }}
                                                    <div id="loader-{{ $product->id }}"
                                                        style="display:none; color:#ffffff " class="spinner-border"
                                                        role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>







                        </div>

                    </div>

                    <div class="row mt-4">
                        <nav class="w-100">
                            <div class="nav nav-tabs" id="product-tab" role="tablist">
                                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab"
                                    href="#product-desc" role="tab" aria-controls="product-desc"
                                    aria-selected="true">{{ __('Product Description') }}</a>
                            </div>
                        </nav>
                        <div class="tab-content p-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                                aria-labelledby="product-desc-tab">
                                <p>
                                    @if (app()->getLocale() == 'ar')
                                        {!! $product->description_ar !!}
                                    @else
                                        {!! $product->description_en !!}
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

        @endif




    </section>
    <!-- /.content -->


@endsection
