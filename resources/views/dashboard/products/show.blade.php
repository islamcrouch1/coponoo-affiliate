@extends('layouts.dashboard.app')

@section('adminContent')







    <!-- Main content -->
    <section class="content">

        @php
            $stocks = 0;
        @endphp

        @foreach ($product->stocks as $stock)
            @php
                $stocks += $stock->stock;
            @endphp
        @endforeach


        @if ($stocks != 0)
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">


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
                            <div class="col-10" style="height: 400px; border: 1px solid #dcdbdb; border-radius:10px">
                                <img id="pruduct-image{{ $product->id }}" style="width: 100%; height:100%"
                                    src="{{ asset('storage/images/products/' . $url) }}"
                                    class="rounded product-image product-id-{{ $product->id }}" alt="Product Image">

                                <div style="position: absolute; bottom:0; right: 0; margin:8px;">
                                    <h3><span class="badge badge-primary">{{ 'SKU: ' . $product->SKU }}</span></h3>
                                </div>
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


                                    @foreach ($product->stocks as $stock)
                                        @php
                                            $stocks = $product->stocks->unique('color_id');
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

                                @foreach ($product->stocks as $stock)
                                    @php
                                        $stocks = $product->stocks->unique('color_id');
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

                                @foreach ($product->stocks as $stock)
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
