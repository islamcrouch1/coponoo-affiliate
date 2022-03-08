@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Marketers - total balances')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Marketers - total balances')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">

                    <form action="">

                        <div class="row">

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
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search ml-2 mr-2"></i>{{__('Search')}}</button>
                            </div>

                        </div>



                    </form>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-info">
                    <div class="inner">

                        @php


                            $favailable_balance = 0 ;
                            $foutstanding_balance = 0;
                            $fpending_withdrawal_requests = 0;
                            $fcompleted_withdrawal_requests = 0;


                        @endphp

                        @foreach ($users as $user)

                        @if ($user->hasRole('affiliate'))

                            @php



                            $favailable_balance += $user->balance->available_balance ;
                            $foutstanding_balance += $user->balance->outstanding_balance ;
                            $fpending_withdrawal_requests += $user->balance->pending_withdrawal_requests ;
                            $fcompleted_withdrawal_requests += $user->balance->completed_withdrawal_requests ;

                            $currency = $user->country->currency;

                            @endphp

                        @endif


                        @endforeach


                      <h3>{{$favailable_balance . ' ' . $currency}}</h3>
                      <p>{{__('Available balance')}}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$foutstanding_balance . ' ' . $currency}}</h3>

                      <p>{{__('Outstanding balance')}}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$fpending_withdrawal_requests . ' ' . $currency}}</h3>

                      <p>{{__('Pending withdrawal requests')}}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                  <!-- small box -->
                  <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$fcompleted_withdrawal_requests . ' ' . $currency}}</h3>
                      <p>{{__('Completed withdrawal requests')}}</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-pie-graph"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
              <!-- Main row -->

              <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>



            <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Vendors - total balances')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active">{{__('Vendors - total balances')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">

                          @php


                              $vavailable_balance = 0 ;
                              $voutstanding_balance = 0;
                              $vpending_withdrawal_requests = 0;
                              $vcompleted_withdrawal_requests = 0;


                          @endphp

                        @foreach ($users as $user)

                        @if ($user->hasRole('vendor'))

                            @php




                            $vavailable_balance += $user->balance->available_balance ;
                            $voutstanding_balance += $user->balance->outstanding_balance ;
                            $vpending_withdrawal_requests += $user->balance->pending_withdrawal_requests ;
                            $vcompleted_withdrawal_requests += $user->balance->completed_withdrawal_requests ;

                            $currency = $user->country->currency;

                            @endphp

                        @endif


                        @endforeach


                        <h3>{{$vavailable_balance . ' ' . $currency}}</h3>
                        <p>{{__('Available balance')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{$voutstanding_balance . ' ' . $currency}}</h3>

                        <p>{{__('Outstanding balance')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{$vpending_withdrawal_requests . ' ' . $currency}}</h3>

                        <p>{{__('Pending withdrawal requests')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{$vcompleted_withdrawal_requests . ' ' . $currency}}</h3>
                        <p>{{__('Completed withdrawal requests')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
              </div><!-- /.container-fluid -->
          </section>




            <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Total orders by case')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item active">{{__('Total orders by case')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

          <!-- Main content -->
          <section class="content">
              <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">

                          @php



                              $aorders_pending = 0 ;
                              $aorders_confirmed = 0;
                              $aorders_onway = 0;
                              $aorders_mandatory = 0;
                              $aorders_delivered = 0;
                              $aorders_canceled = 0;
                              $aorders_returned= 0;

                              $pcount = $orders_pending->count();
                              $ncount = $orders_confirmed->count();
                              $ocount = $orders_onway->count();
                              $mcount = $orders_mandatory->count();
                              $dcount = $orders_delivered->count();
                              $ccount = $orders_canceled->count();
                              $rcount = $orders_returned->count();


                              $orders_pending_p = 0 ;
                              $orders_confirmed_P = 0;
                              $orders_onway_p = 0;
                              $orders_mandatory_p = 0;
                              $orders_delivered_p = 0;
                              $orders_canceled_p = 0;
                              $orders_returned_p = 0;

                              $dOrders_profit = 0;
                              $mOrders_profit = 0;


                          @endphp

                        @foreach ($orders_pending as $order)
                            @php
                            $aorders_pending += $order->total_price ;
                            $currency = $user->country->currency;
                            @endphp
                        @endforeach



                        @foreach ($orders_confirmed as $order)
                            @php
                            $aorders_confirmed += $order->total_price ;
                            $currency = $user->country->currency;
                            @endphp
                        @endforeach



                        @foreach ($orders_onway as $order)
                            @php
                            $aorders_onway += $order->total_price ;
                            $currency = $user->country->currency;
                            @endphp
                        @endforeach



                        @foreach ($orders_mandatory as $order)
                            @php
                            $aorders_mandatory += $order->total_price ;
                            $currency = $user->country->currency;
                            $mOrders_profit += $order->total_profit;

                            @endphp
                        @endforeach



                        @foreach ($orders_delivered as $order)
                            @php
                            $aorders_delivered += $order->total_price ;
                            $currency = $user->country->currency;
                            $dOrders_profit += $order->total_profit;
                            @endphp
                        @endforeach



                        @foreach ($orders_canceled as $order)
                            @php
                            $aorders_canceled += $order->total_price ;
                            $currency = $user->country->currency;
                            @endphp
                        @endforeach



                        @foreach ($orders_returned as $order)
                            @php
                            $aorders_returned+= $order->total_price ;
                            $currency = $user->country->currency;

                            @endphp
                        @endforeach


                        <h3>{{$aorders_pending . ' ' . $currency}}</h3>
                        <p>{{__('Total pending orders')  . ' : ' . $pcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{$aorders_confirmed . ' ' . $currency}}</h3>

                        <p>{{__('Total confirmed orders')  . ' : ' . $ncount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                          <h3>{{$aorders_onway . ' ' . $currency}}</h3>

                        <p>{{__('Total orders being delivered') . ' : ' . $ocount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{$aorders_mandatory . ' ' . $currency}}</h3>
                        <p>{{__('Total requests in the mandatory period')  . ' : ' . $mcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{$aorders_delivered . ' ' . $currency}}</h3>
                        <p>{{__('Total orders delivered') . ' : ' . $dcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{$aorders_canceled . ' ' . $currency}}</h3>
                        <p>{{__('Total canceled orders')  . ' : ' . $ccount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                          <h3>{{$aorders_returned. ' ' . $currency}}</h3>
                        <p>{{__('Total Returns') . ' : ' . $rcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->

                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{$dOrders_profit . ' ' . $currency}}</h3>
                        <p>{{__('Total profits from orders delivered') . ' : ' . $dcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->

                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                          <h3>{{$mOrders_profit . ' ' . $currency}}</h3>
                        <p>{{__('Total profits from orders in the mandatory period') . ' : ' . $mcount . __(' Order')}}</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->

                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
              </div><!-- /.container-fluid -->
          </section>



      @endsection
