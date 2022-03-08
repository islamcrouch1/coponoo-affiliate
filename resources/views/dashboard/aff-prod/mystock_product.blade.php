@extends('layouts.dashboard.app')

@section('adminContent')







    <!-- Main content -->
    <section class="content">

        @php
        $stocks = 0;
        @endphp

        @foreach ($product->stocks as $stock)

        @php
            $stocks += $stock->stock
        @endphp

        @endforeach


        @if ($stocks != 0)


                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-right' : 'float-sm-left' }}">
                                    <li class="breadcrumb-item"> <a href="{{route('products.affiliate' , app()->getLocale())}}">{{__('All Products')}}</a></li>


                                    @php
                                    $cats = [] ;

                                    @endphp

                                    @if ($product->category->parent != 'null')


                                    @php
                                    $cat = \App\Category::where('id' , $product->category->id)->first();
                                    @endphp


                                      @while ($cat->parent != 'null')
                                      @php
                                        array_push($cats, $cat->parent);
                                        $cat = \App\Category::where('id' , intval($cat->parent))->first();
                                      @endphp
                                      @endwhile

                                      @foreach (array_reverse($cats) as $cat)
                                          @php
                                          $cat = \App\Category::where('id' , intval($cat))->first();
                                          @endphp
                                          <li class="breadcrumb-item"> <a href="{{ route('products.affiliate.cat' , [ 'lang'=>app()->getLocale() , 'category'=>$cat->id]) }}">{{app()->getLocale() == 'ar' ? $cat->name_ar : $cat->name_en}}</a></li>
                                      @endforeach

                                      @php
                                      $cat = \App\Category::where('id' , request()->parent)->first();
                                      @endphp

                                      <li class="breadcrumb-item active"> <a href="{{ route('products.affiliate.cat', [ 'lang'=>app()->getLocale() , 'category'=>$product->category->id] ) }}">{{ app()->getLocale() == 'ar' ? $product->category->name_ar : $product->category->name_en}}</a></li>
                                      <li class="breadcrumb-item"> <a href="">{{app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></li>


                                    @else

                                    <li class="breadcrumb-item active"> <a href="{{ route('products.affiliate.cat', [ 'lang'=>app()->getLocale() , 'category'=>$product->category->id] ) }}">{{ app()->getLocale() == 'ar' ? $product->category->name_ar : $product->category->name_en}}</a></li>
                                    <li class="breadcrumb-item"> <a href="">{{app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</a></li>


                                    @endif

                                  </ol>
                            </div>


                            @if ($product->images->count() != 0 )
                            @php
                                $url = $product->images[0]->url;
                            @endphp

                            @else
                                @php
                                    $url = 'place-holder.png';
                                @endphp
                            @endif


                            <div class="col-12 col-sm-6">
                                <h3 class="my-3 mr-2 ml-2">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</h3>
                                <h3 class="d-inline-block d-sm-none">{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en}}</h3>
                                <div class="col-10" style="height: 400px; border: 1px solid #dcdbdb; border-radius:10px">
                                    <img id="pruduct-image{{$product->id}}" style="width: 100%; height:100%" src="{{ asset('storage/images/products/' . $url ) }}" class="rounded product-image product-id-{{$product->id}}" alt="Product Image">
                                </div>

                                <div class="col-10 product-image-thumbs">

                                    <div id="allImages" style="width: 100%; " class="row">

                                        @foreach ($product->images as $index => $image)

                                        <div class="col-md-2" style="margin-top: 5px; padding-right: 3px ; padding-left:3px">
                                            <div id="image-{{$image->url}}" style="width: 100%; height:100%; margin-right:0px" class="product-image-thumb product-{{$product->id}} active" data-id="{{$product->id}}"><img src="{{ asset('storage/images/products/' . $image->url) }}" alt="Product Image"></div>

                                        </div>

                                        @endforeach


                                        @foreach ($product->stocks as $stock)

                                        @php
                                            $stocks = $product->stocks->unique('color_id');
                                        @endphp

                                        @endforeach

                                        @foreach ($stocks as $stock)
                                        @if ($stock->image != Null)


                                        <div class="col-md-2" style="margin-top: 5px">
                                            <div id="image-{{$stock->color->color_en}}" style="width: 100%; height:100%; margin-right:0px" class="product-image-thumb product-{{$stock->product->id}} active" data-id="{{$stock->product->id}}"><img src="{{ asset('storage/images/products/' . $stock->image) }}" alt="Product Image"></div>

                                        </div>

                                        @endif
                                        @endforeach

                                    </div>



                                </div>


                                <div style="width: 100%; text-align:center" class="col-10 p-2 mt-4">
                                    <button onclick="downloadAll()" style="width: 80%; border-radius:50px" class="btn btn-primary" >{{__('Download all product images')}} </a>
                                </div>




                            </div>
                            <div class="col-12 col-sm-6" style="margin-top: 60px">


                                @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                                @endif

                                <form method="POST" action="{{route('mystock.order' , ['lang' => app()->getLocale() , 'product' =>$product->id , 'price' => $product->vendor_price])}}">
                                    @csrf

                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Select the required quantities')}}</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                                <table class="table table-head-fixed text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('Color')}}</th>
                                                        <th>{{__('Size')}}</th>
                                                        <th>{{__('Available quantity')}}</th>
                                                        <th>{{__('Quantity')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @foreach ($product->stocks as $stock)

                                                        <tr>
                                                        <td>{{ app()->getLocale() == 'ar' ? $stock->color->color_ar :  $stock->color->color_en}}</td>
                                                        <td>{{ app()->getLocale() == 'ar' ? $stock->size->size_ar :  $stock->size->size_ar}}</td>
                                                        <td>{{ $stock->stock . ' ' . __('Piece') }}</td>
                                                        <td>
                                                            <input id="quantity" data-price="{{$product->min_price}}" data-stock="{{$stock->stock}}" type="number" min="0" max="{{$stock->stock}}" class="form-control product-quantity-stock quant-{{$product->id}} @error('quantity') is-invalid @enderror" name="quantity[]" value="0" onkeypress="return event.charCode >= 48">
                                                        </td>
                                                        </tr>

                                                    @endforeach


                                                </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                        <!-- /.row -->


                                    <div class="bg-primary py-2 px-3 mt-4">
                                        <h6 class="mb-0">
                                        {{__('Product Price : ') . $product->min_price . ' ' . $product->country->currency }}
                                        </h6>
                                        <h6 class="mb-1 mt-2">
                                            {{__('Total order : ') }} <span id="total_order">0</span>  {{ ' ' . $product->country->currency }}
                                        </h6>
                                    </div>


                                    <div class="form-group row mt-2">
                                        <label for="payment" class="col-md-4 col-form-label text-md-right">{{ __('Select Payment method') }}</label>
                                        <div class="col-md-8">
                                            <select class=" form-control @error('payment') is-invalid @enderror" id="payment" name="payment" required>
                                            <option value="1" >{{ __('Manually') }}</option>
                                            </select>
                                            @error('payment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg btn-flat">
                                                        {{__('Add New Order')}}
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                </form>





                            </div>

                        </div>

                        <div class="row mt-4">
                            <nav class="w-100">
                              <div class="nav nav-tabs" id="product-tab" role="tablist">
                                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">{{__('Product Description')}}</a>
                              </div>
                            </nav>
                            <div class="tab-content p-3" id="nav-tabContent">
                              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
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
