@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('My stock orders')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('My stock orders')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="row">
        <div class="col-md-12">
          <form action="">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search by client name or phone')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="status" style="display:inline-block">
                  <option value="" selected>{{__('All Status')}}</option>
                    <option value="pending" {{request()->status == 'pending' ? 'selected' : ''}}>{{__('pending')}}</option>
                    <option value="confirmed" {{request()->status == 'confirmed' ? 'selected' : ''}}>{{__('confirmed')}}</option>
                    <option value="rejected" {{request()->status == 'rejected' ? 'selected' : ''}}>{{__('rejected')}}</option>
                    <option value="canceled" {{request()->status == 'canceled' ? 'selected' : ''}}>{{__('canceled')}}</option>
                </select>
              </div>

              <div class="col-md-1" style="text-align: center">
                <label for="from" class="col-md-2 col-form-label">{{ __('From') }}</label>
              </div>

              <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="{{request()->from}}">
              </div>



              <div class="col-md-1" style="text-align: center">
                <label for="to" class="col-md-2 col-form-label">{{ __('To') }}</label>
              </div>

              <div class="col-md-2">
                <input type="date" name="to"  class="form-control" value="{{request()->to}}">
              </div>

              <div class="col-md-2">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
              </div>
            </div>
          </form>
        </div>
      </div>


      <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">


                <h3 class="card-title">{{__('Orders')}}</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fas fa-times"></i></button>
                  </div>
                </div>
                <div class="card-body p-0">

                    <div class="row">

                        <div class="col-md-12">
                            <a class="btn btn-info" href="{{route('stock.orders' , ['lang' => app()->getLocale() ,  'status' => 'pending'])}}">{{__('pending') . ' ( ' . \App\Aorder::where('status' , 'pending')->count() . ' )'}}</a>
                            <a class="btn btn-info" href="{{route('stock.orders' , ['lang' => app()->getLocale() ,  'status' => 'confirmed'])}}">{{__('confirmed') . ' ( ' . \App\Aorder::where('status' , 'confirmed')->count() . ' )'}}</a>
                            <a class="btn btn-info" href="{{route('stock.orders' , ['lang' => app()->getLocale() ,  'status' => 'rejected'])}}">{{__('rejected') . ' ( ' . \App\Aorder::where('status' , 'rejected')->count() . ' )'}}</a>
                            <a class="btn btn-info" href="{{route('stock.orders' , ['lang' => app()->getLocale() ,  'status' => 'canceled'])}}">{{__('canceled') . ' ( ' . \App\Aorder::where('status' , 'canceled')->count() . ' )'}}</a>
                        </div>

                    </div>

                  @if($orders->count() > 0)



                  <table class="table table-striped projects">
                      <thead>
                          <tr>

                              <th>#id</th>
                              <th>{{__('Order Status')}}</th>
                              <th>{{__('Affiliate Name')}}</th>
                              <th>{{__('Product Name')}}</th>
                              <th >{{__('Total Amount')}}</th>
                              <th> {{__('Created At')}}</th>
                              <th>{{__('Updated At')}}</th>
                              <th style="" class="">{{__('Actions')}}</th>

                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($orders as $order)

                          <tr>

                                <td>{{ $order->id }}</td>

                                <td>

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

                                </td>
                                <td>
                                    <a href="{{route('users.show' , [app()->getLocale() , $order->user_id])}}">
                                        <small>
                                            {{$order->user_name}}
                                        </small>
                                    </a>

                                </td>
                                <td>
                                    <small>
                                        {{app()->getLocale() == 'ar' ? $order->product->name_ar : $order->product->name_en}}
                                    </small>
                                </td>
                                <td><small>{{ $order->total_price . ' ' . $order->user->country->currency }}</small></td>
                                <td><small>


                                    @php
                                      $date =  Carbon\Carbon::now();
                                      $interval = $order->created_at->diffForHumans($date );
                                    @endphp

                                    <span style="direction: ltr !important" class="badge badge-success">{{$interval}}</span>

                                </small></td>
                                <td><small>

                                    @php
                                    $date =  Carbon\Carbon::now();
                                    $interval = $order->updated_at->diffForHumans($date );
                                    @endphp

                                    <span style="direction: ltr !important" class="badge badge-success">{{$interval}}</span>

                                </small></td>


                                <td class="project-actions">

                                    <a style="color:#ffffff"  class="btn btn-primary btn-sm" href="{{route('mystock.product' , ['lang' => app()->getLocale() , 'product' => $order->product->id , 'order' => $order->id] ) }}">
                                        {{__('Show product')}}
                                    </a>


                                    @if (($order->status != 'canceled') && ($order->status != 'rejected'))

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-primary-{{$order->id}}">
                                        {{__('Change Request Status')}}
                                    </button>


                                    @endif





                                </td>
                            </tr>

                        @endforeach

                      </tbody>
                  </table>

                  <div class="row mt-3"> {{ $orders->appends(request()->query())->links() }}</div>

                  @else <h3 class="p-4">{{__('You do not have orders to view')}}</h3>
                  @endif
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



        </div>


        </div>

      </div>



    </section>
    <!-- /.content -->


    @foreach ($orders as $order)


    <div class="modal fade" id="modal-primary-{{$order->id}}">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 style="direction: rtl;" class="modal-title">{{__('Change Request Status for - ') . $order->user->name}}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <form method="POST" action="{{route('stock.orders.change', ['lang'=> app()->getLocale() , 'order'=>$order->id ])}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label">{{ __('Select Status') }}</label>
                        <div class="col-md-8">

                            <select style="height: 50px;" class=" form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required autocomplete="status">

                                <option value="pending" {{$order->status == 'pending' ? 'selected' : ''}}>{{__('pending')}}</option>
                                <option value="confirmed" {{$order->status == 'confirmed' ? 'selected' : ''}}>{{__('confirmed')}}</option>
                                <option value="rejected" {{$order->status == 'rejected' ? 'selected' : ''}}>{{__('rejected')}}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-outline-light">{{__('Save changes')}}</button>
                </div>

            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    @endforeach

  @endsection
