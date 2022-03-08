@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>orders</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">orders</li>
                <li class="breadcrumb-item active">Add New orders</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Categories') }}</div>

                <div class="card-body">



                    @foreach ($categories as $category)


                    <div class="panel-group">

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#{{'div-' . $category->id}}">{{ $category->name_ar }}</a>
                                </h4>
                            </div>

                            <div id="{{'div-' . $category->id}}" class="panel-collapse collapse">

                                <div class="panel-body">

                                    @if ($category->products->count() > 0)

                                        <table class="table table-hover">
                                            <tr>
                                                <th>product</th>
                                                <th>stock</th>
                                                <th>price</th>
                                                <th>add</th>
                                            </tr>

                                            @foreach ($category->products as $product)
                                                <tr>
                                                    <td>{{ $product->name_en }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ number_format($product->sale_price, 2) . ' ' . $product->country->currency }}</td>

                                                        <td>
                                                            @if ($product->stock > '0')

                                                            <a href=""
                                                            id="product-{{ $product->id }}"
                                                            data-name="{{ $product->name_en }}"
                                                            data-currency="{{ $product->country->currency }}"
                                                            data-id="{{ $product->id }}"
                                                            data-price="{{ $product->sale_price }}"
                                                            data-type="{{$product->type}}"
                                                            data-shipping="{{$product->country->shipping}}"
                                                            class="btn btn-success btn-sm add-product-btn">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            @else
                                                            {{__('Stock Empty')}}
                                                            @endif

                                                        </td>


                                                </tr>
                                            @endforeach

                                        </table><!-- end of table -->

                                    @else
                                        <h5>No Data To Show</h5>
                                    @endif

                                </div><!-- end of panel body -->

                            </div><!-- end of panel collapse -->

                        </div><!-- end of panel primary -->

                    </div><!-- end of panel group -->

                @endforeach
                </div>
            </div>
        </div>


        <div class="col-md-6">


            {{-- <div class="card">
                <div class="card-header">{{ __('Select orderaddress') }}</div>
                <div class="box-body">
                </div><!-- end of box body -->
            </div><!-- end of box --> --}}




            <div class="card">
                <div class="card-header">{{ __('Shopping Cart') }}</div>
                <div class="box-body">

                    <form action="{{ route('orders.store',  ['lang'=>app()->getLocale() , 'user'=>$user->id]) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        {{-- @include('partials._errors') --}}

                        <h4 style="padding:10px">Select order address</h4>

                        <select class="form-control form-control-lg" id="address_id" name="address_id" required>
                            @foreach ($user->addresses as $address)
                            <option value="{{$address->id}}">{{$address->country->name . '-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}</option>
                            @endforeach
                        </select>


                        <h4 style="padding:10px">order status</h4>

                        @php
                        $order_status = ['recieved' , 'processing' , 'shipped' , 'completed']
                        @endphp

                        <select class="form-control form-control-lg" id="status" name="status" required>
                            @foreach ($order_status as $order_status)

                            @switch($order_status)
                                @case('recieved')
                                <option value="{{$order_status}}">{{__('Awaiting review from management')}}</option>
                                    @break
                                @case("processing")
                                <option value="{{$order_status}}">{{__('Your order is under review')}}</option>
                                @break
                                @case("shipped")
                                <option value="{{$order_status}}">{{__('Your order has been shipped')}}</option>
                                @break
                                @case("completed")
                                <option value="{{$order_status}}">{{__('You have successfully received your request')}}</option>
                                @break
                                @default
                            @endswitch
                            @endforeach
                        </select>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>product</th>
                                <th>quantity</th>
                                <th>price</th>
                                <th>action</th>

                            </tr>
                            </thead>

                            <tbody class="order-list">


                            </tbody>

                        </table><!-- end of table -->
                        <div class="row">
                            <div class="col-md-12 text-right pr-3">

                                <h4 style="font-size: 15px; direction:rtl">{{ __('Shipping Fee : ') }}
                                    <span style="font-size: 15px; direction:rtl" class="shipping_fee">0</span> <span style="font-size: 15px"> {{' ' . $product->country->currency}}</span>
                                </h4>


                                <h4 style="padding:10px; direction:rtl">{{__('Total : ')}}<span class="total-price">0</span>{{' ' . $product->country->currency }}</h4>

                            </div>
                        </div>





                        <button class="btn btn-primary btn-block disabled" id="add-order-form-btn"><i class="fa fa-plus"></i> Add order</button>

                    </form>

                </div><!-- end of box body -->

            </div><!-- end of box -->

            @if ($user->orders->count() > 0)

                <div class="card">

                    <div class="card-header">

                        <h3 class="box-title" style="margin-bottom: 10px">All orders for {{$user-> name}}
                            <small>{{ '( ' . $orders->total() . ' )' }}</small>
                        </h3>

                    </div><!-- end of box header -->

                    <div class="box-body">

                        @foreach ($orders as $order)

                            <div class="panel-group">

                                <div class="panel panel-success">

                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#div-order-{{ $order->id }}">{{ $order->created_at }}</a>
                                        </h4>
                                    </div>

                                    <div id="div-order-{{ $order->id }}" class="panel-collapse collapse">

                                        <div class="panel-body">

                                            <ul class="list-group">
                                                @foreach ($order->products as $product)
                                                    <li class="list-group-item">{{ $product->name_en }}</li>
                                                @endforeach
                                            </ul>

                                        </div><!-- end of panel body -->

                                    </div><!-- end of panel collapse -->

                                </div><!-- end of panel primary -->

                            </div><!-- end of panel group -->

                        @endforeach

                        <div class="row mt-3"> {{ $orders->appends(request()->query())->links() }}</div>


                    </div><!-- end of box body -->

                </div><!-- end of box -->

                @endif

            </div>
        </div>
    </div>
</div>






  @endsection
