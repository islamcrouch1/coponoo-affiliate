@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Logs')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Logs')}}</li>
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
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="{{__('Search..')}}" class="form-control" value="{{request()->search}}">
                </div>
              </div>

              <div class="col-md-2">
                <select class="form-control"  name="user_type" style="display:inline-block">
                  <option value="" selected>{{__('All uesr types')}}</option>
                  <option value="admin" {{ request()->user_type == "admin" ? 'selected' : ''}}>{{__("admin")}}</option>
                  <option value="affiliate" {{ request()->user_type == "affiliate" ? 'selected' : ''}}>{{__("affiliate")}}</option>
                  <option value="vendor" {{ request()->user_type == "vendor" ? 'selected' : ''}}>{{__("vendor")}}</option>
                </select>
              </div>


              <div class="col-md-2">
                <select class="form-control"  name="log_type" style="display:inline-block">
                  <option value="" selected>{{__('All log types')}}</option>
                  <option value="orders" {{ request()->log_type == "orders" ? 'selected' : ''}}>{{__("orders")}}</option>
                  <option value="users" {{ request()->log_type == "users" ? 'selected' : ''}}>{{__("users")}}</option>
                  <option value="products" {{ request()->log_type == "products" ? 'selected' : ''}}>{{__("products")}}</option>
                  <option value="exports" {{ request()->log_type == "exports" ? 'selected' : ''}}>{{__("exports")}}</option>
                  <option value="imports" {{ request()->log_type == "imports" ? 'selected' : ''}}>{{__("imports")}}</option>
                </select>
              </div>



              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Logs')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($logs->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                           {{__('User name')}}
                      </th>
                      <th>
                        {{__('User ID')}}
                   </th>
                      <th>
                        {{__('User Type')}}
                   </th>
                   <th>
                    {{__('Log Type')}}
                    </th>
                    <th>
                        {{__('Description')}}
                        </th>
                    <th>
                      {{__('Created At')}}
                  </th>


                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($logs as $log)
                    <td>
                        {{ $log->id }}
                    </td>

                    <td>
                         <a href="{{ route('users.show' , [ 'lang' => app()->getLocale() , 'user' => $log->user->id ]) }}">
                            {{ $log->user->name }}
                        </a>

                    </td>
                    <td>
                        {{$log->user_id}}
                    </td>

                    <td>
                        @if ($log->user_type == 'admin')
                        <span class='badge badge-warning'>{{__($log->user_type)}}</span>
                        @elseif ($log->user_type == 'affiliate')
                        <span class='badge badge-danger'>{{__($log->user_type)}}</span>
                        @elseif ($log->user_type == 'vendor')
                        <span class='badge badge-success'>{{__($log->user_type)}}</span>
                        @endif
                    </td>


                    <td>
                        @if ($log->log_type == 'orders')
                        <span class='badge badge-warning'>{{__($log->log_type)}}</span>
                        @elseif ($log->log_type == 'users')
                        <span class='badge badge-danger'>{{__($log->log_type)}}</span>
                        @elseif ($log->log_type == 'products')
                        <span class='badge badge-success'>{{__($log->log_type)}}</span>
                        @elseif ($log->log_type == 'exports')
                        <span class='badge badge-info'>{{__($log->log_type)}}</span>
                        @elseif ($log->log_type == 'imports')
                        <span class='badge badge-primary'>{{__($log->log_type)}}</span>
                        @endif
                    </td>


                    <td>
                        {{ app()->getLocale() == 'ar' ? $log->description_ar : $log->description_en }}
                    </td>


                    <td>
                        @php
                        $date =  Carbon\Carbon::now();
                        $interval = $log->created_at->diffForHumans($date );
                        @endphp

                        <span style="direction: ltr !important" class="badge badge-success">{{$interval}}</span>
                    </td>

                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $logs->appends(request()->query())->links() }}</div>

          @else <h3 class="p-2">{{__('No logs To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
