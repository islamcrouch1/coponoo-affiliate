@extends('layouts.dashboard.app')

@section('adminContent')





    <div class="container page__container" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 0px' : 'margin-left: 0px'}}">



    <div class="content-gummla">



        <div class="page-separator pt-3 pb-3">
                <div class="page-separator__text">{{ __('My stock products') }}</div>
        </div>


    </div>




</div>



    <!-- Main content -->
    <section class="content">


        <div class="page-separator pt-3 pb-3">
                <div class="page-separator__text">{{ __('Products') }}</div>
        </div>


        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">


                @if ($orders->count() == 0)


                <div class="col-md-12">
                    <p>{{__('There are currently no products to display in this section... Please check back later')}}</p>
                </div>


                @else





        @foreach ($orders as $order)


        @php
        $stocks = 0;
        @endphp

        @foreach ($order->product->stocks as $stock)

        @php
            $stocks += $stock->stock
        @endphp

        @endforeach


        @if ($stocks != 0)




        <div class="col-md-3 mb-4">


            @if ($order->product->images->count() != 0 )
            @php
                $url = $order->product->images[0]->url;
            @endphp

            @else
                @php
                    $url = 'place-holder.png';
                @endphp
            @endif

            <div class="p-1" style="border: 1px solid #ddd; border-radius:5px">
                <div class="card-container d-flex flex-column justify-content-between">

                    <a class="product-a" href="{{route('mystock.product' , ['lang' => app()->getLocale() , 'product' => $order->product->id , 'order' => $order->id] ) }}">
                        <img style="width:100%; height:100%;" src="{{ asset('storage/images/products/' . $url) }}" alt="">
                    </a>

                </div>

                <div>
                    <p style="font-size: 27px; height:60px" class="text-lg m-1 mb-4">{{ app()->getLocale() == 'ar' ? substr($order->product->name_ar,0,100) . '...'  : substr($order->product->name_en,0,100) . '...' }}</p>
                </div>

                <div class="row m-1">
                    @php
                    $sPrice = ceil($order->product->min_price * 10 / 100);
                    $sPrice = $sPrice + $order->product->min_price ;
                    @endphp
                    <div class="col-md-6">
                        <span style="font-size: 25px">{{$sPrice}}</span> {{ ' ' . $order->product->country->currency}}
                    </div>
                    <div style="text-align:left" class="col-md-6">
                        {{__('Profit ') . ': ' }} <span style="font-size: 23px; color:#007bff; ">{{($sPrice - $order->product->min_price)}}</span>
                    </div>
                </div>

                @switch($order->status)
                @case('pending')
                <span class="badge badge-warning badge-lg">{{__('pending')}}</span>
                    @break
                @case("confirmed")
                <span class="badge badge-primary badge-lg">{{__('confirmed')}}</span>
                @break
                @case("rejected")
                <span class="badge badge-info badge-lg">{{__('rejected')}}</span>
                @break
                @case("canceled")
                <span class="badge badge-danger badge-lg">{{__('canceled')}}</span>
                @break
                @default
                @endswitch

                <div style="text-align:center" class="p-2 mt-4 mb-1">

                    <a style="width: 70%; border-radius:50px" class="btn btn-primary" href="{{route('mystock.product' , ['lang' => app()->getLocale() , 'product' => $order->product->id , 'order' => $order->id] ) }}">{{__('View product')}} </a>

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

        <div class="row m-3"> {{ $orders->appends(request()->query())->links() }}</div>

      </section>
      <!-- /.content -->



  @endsection
