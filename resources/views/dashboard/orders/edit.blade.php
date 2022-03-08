@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Edit order for {{$user->name}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">orders</li>
                <li class="breadcrumb-item active">Edit Order</li>
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
                                                    <td>{{ $product->name_ar }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ number_format($product->sale_price, 2) }}</td>
                                                    <td>
                                                        @if ($product->stock > '0')

                                                        <a href=""
                                                           id="product-{{ $product->id }}"
                                                           data-name="{{ $product->name_en }}"
                                                           data-id="{{ $product->id }}"
                                                           data-price="{{ $product->sale_price }}"
                                                           class="btn  btn-sm {{ in_array($product->id, $order->products->pluck('id')->toArray()) ? 'btn-default disabled' : 'btn-success add-product-btn' }}">
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
            <div class="card">
                <div class="card-header">{{ __('Shopping Cart') }}</div>
                <div class="box-body">

                    <form action="{{ route('orders.update',  ['lang'=>app()->getLocale() , 'user'=>$user->id , 'order'=>$order->id]) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        {{-- @include('partials._errors') --}}

                        <h4 style="padding:10px">Select order address</h4>

                        <select class="form-control form-control-lg" id="address_id" name="address_id" required>
                            @foreach ($user->addresses as $address)
                            <option value="{{$address->id}}" {{ ($address->id == $order->address->id) ? 'selected' : '' }}>{{$address->country->name . '-' .  $address->province . '-' . $address->city . '-' . $address->district . '-' . $address->street . '-' . $address->building . '-' . $address->phone . '-' . $address->notes . '-' }}</option>
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
                                <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Awaiting review from management')}}</option>
                                    @break
                                @case("processing")
                                <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Your order is under review')}}</option>
                                @break
                                @case("shipped")
                                <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('Your order has been shipped')}}</option>
                                @break
                                @case("completed")
                                <option value="{{$order_status}}" {{ ($order_status == $order->status) ? 'selected' : '' }}>{{__('You have successfully received your request')}}</option>
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


                                @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $product->name_en }}</td>
                                    <td><input type="number" name="products[{{ $product->id }}][quantity]" data-stock="{{$product->stock}}" data-price="{{ number_format($product->sale_price, 2) }}" class="form-control input-sm product-quantity" min="1" value="{{ $product->pivot->quantity }}"></td>
                                    <td class="product-price">{{ number_format($product->sale_price * $product->pivot->quantity, 2) }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-product-btn" data-id="{{ $product->id }}"><span class="fa fa-trash"></span></button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table><!-- end of table -->

                        <h4 style="padding:10px">Total : <span class="total-price">{{ number_format($order->total_price, 2) }}</span></h4>

                        <button class="btn btn-primary btn-block" id="add-order-form-btn"><i class="fa fa-plus"></i> Edit order</button>

                    </form>

                </div><!-- end of box body -->

            </div><!-- end of box -->

            {{-- @if ($user->orders->count() > 0)

                <div class="box box-primary">

                    <div class="box-header">

                        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.previous_orders')
                            <small>{{ $orders->total() }}</small>
                        </h3>

                    </div><!-- end of box header -->

                    <div class="box-body">

                        @foreach ($orders as $order)

                            <div class="panel-group">

                                <div class="panel panel-success">

                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#{{ $order->created_at->format('d-m-Y-s') }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                        </h4>
                                    </div>

                                    <div id="{{ $order->created_at->format('d-m-Y-s') }}" class="panel-collapse collapse">

                                        <div class="panel-body">

                                            <ul class="list-group">
                                                @foreach ($order->products as $product)
                                                    <li class="list-group-item">{{ $product->name }}</li>
                                                @endforeach
                                            </ul>

                                        </div><!-- end of panel body -->

                                    </div><!-- end of panel collapse -->

                                </div><!-- end of panel primary -->

                            </div><!-- end of panel group -->

                        @endforeach

                        {{ $orders->links() }}

                    </div><!-- end of box body -->

                </div><!-- end of box -->

                @endif --}}

            </div>
        </div>
    </div>
</div>



<div style="z-index: 10000000000000000 !important" class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Alert')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{__("The required quantity is not available in stock .. The quantity available for order now is:")}} <span class="available-quantity"></span>
        </div>
      </div>
    </div>
  </div>




  @endsection
