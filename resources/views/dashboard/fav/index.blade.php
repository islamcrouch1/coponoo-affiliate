@extends('layouts.dashboard.app')

@section('adminContent')




    <div class="container page__container" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 0px' : 'margin-left: 0px'}}">



</div>

    <!-- Main content -->
    <section class="content">


        <div class="page-separator pt-3 pb-3">
                <div class="page-separator__text">{{ __('Favourites') }}</div>
        </div>


        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">

        @if ($user->fav->count() == 0)


        <div class="col-md-12">
            <p>{{__('You have no products in favourites')}}</p>
        </div>


        @else





        @foreach ($favs as $favorite)


        @php
        $stocks = 0;
        @endphp

        @foreach ($favorite->product->stocks as $stock)

        @php
            $stocks += $stock->stock
        @endphp

        @endforeach


        @if ($stocks != 0)




        <div class="col-md-3 mb-4">


            <div class="p-1" style="border: 1px solid #ddd; border-radius:5px">
                <div class="card-container d-flex flex-column justify-content-between">

                    <a class="product-a" href="{{route('products.affiliate.view' , ['lang' => app()->getLocale() , 'product'=> $favorite->product->id] )}}">
                        <img style="width:100%; height:100%;" src="{{ asset('storage/images/products/' . $favorite->product->images[0]->url) }}" alt="">
                    </a>

                </div>

                <div>
                    <p style="font-size: 27px; height:60px" class="text-lg m-1 mb-4">{{ app()->getLocale() == 'ar' ? substr($favorite->product->name_ar,0,100) . '...'  : substr($favorite->product->name_en,0,100) . '...' }}</p>
                </div>

                <div class="row m-1">
                    @php
                    $sPrice = ceil($favorite->product->min_price * 10 / 100);
                    $sPrice = $sPrice + $favorite->product->min_price ;
                    @endphp
                    <div class="col-md-6">
                        <span style="font-size: 25px">{{$sPrice}}</span> {{ ' ' . $favorite->product->country->currency}}
                    </div>
                    <div style="text-align:left" class="col-md-6">
                        {{__('Profit ') . ': ' }} <span style="font-size: 23px; color:#007bff; ">{{($sPrice - $favorite->product->min_price)}}</span>
                    </div>
                </div>

                <div style="width: 100; text-align:center" class="p-2 mt-4 mb-1">
                    <a style="width: 80%; border-radius:50px" class="btn btn-primary" href="{{route('products.affiliate.view' , ['lang' => app()->getLocale() , 'product'=> $favorite->product->id] )}}">{{__('View product')}} </a>
                    <a class="add-fav" href="#" style="width: 20%; margin:7px" data-id="{{$favorite->product->id}}" data-url="{{ route('fav.add',['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'product'=> $favorite->product->id] ) }}"><i style="font-size:29px" class="{{'fav-' . $favorite->product->id}} {{ Auth::user()->fav()->where('product_id', $favorite->product->id)->where('user_id', Auth::id())->get()->count() == 0 ? 'far' : 'fas' }} fa-heart fa-lg"></i></a>

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

        <div class="row m-3"> {{ $favs->appends(request()->query())->links() }}</div>


      </section>
      <!-- /.content -->


  @endsection
