@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>addresses for user - {{ $user->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">addresses</li>
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
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('addresses-create'))
                <a href="{{route('addresses.create', ['lang'=>app()->getLocale() , 'user'=>$user->id]  )}}"> <button type="button" class="btn btn-primary">Create address</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create address</button></a>

                @endif
                @if (auth()->user()->hasPermission('addresses-read'))
                <a href="{{route('addresses.trashed' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}"> <button type="button" class="btn btn-primary">addresses trash</button></a>
                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">addresses trash</button></a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">addresses</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($addresses->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                        country
                    </th>
                      <th>
                           province
                      </th>
                      <th>
                        city
                      </th>
                      <th>
                        district
                      </th>
                      <th>
                        street
                      </th>
                      <th>
                        building number
                      </th>
                      <th>
                        phone
                      </th>
                      <th>
                        notes
                      </th>
                      <th>
                       {{__('Created At')}}
                    </th>
                    <th>
                     {{__('Updated At')}}
                  </th>
                  <?php if($addresses !== Null){$address = $addresses[0];} ?>
                  @if ($address->trashed())
                  <th>
                   {{__('Deleted At')}}
                  </th>
                  @endif
                      <th style="" class="">
                        {{__('Actions')}}
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($addresses->reverse() as $address)
                    <td>
                        {{ $address->id }}
                    </td>
                    <td>

                        {{ $user->country->name_en }}

                  </td>
                    <td>
                        <small>
                            {{ $address->province }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $address->city }}
                      </small>
                  </td>
                  <td>
                    {{ $address->district }}
                  </td>

                  <td>
                    {{ $address->street }}
                  </td>
                  <td>
                    {{ $address->building }}
                  </td>
                  <td>
                    {{ $address->phone }}
                  </td>
                  <td>
                    {{ $address->notes }}
                  </td>
                    <td>
                        <small>
                            {{ $address->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $address->updated_at }}
                      </small>
                  </td>
                  @if ($address->trashed())
                  <td>
                    <small>
                        {{ $address->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$address->trashed())
                        @if (auth()->user()->hasPermission('addresses-update'))
                        <a class="btn btn-info btn-sm" href="{{route('addresses.edit' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                           {{__('Edit')}}
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                         {{__('Edit')}}
                      </a>
                      @endif
                        @else
                        @if (auth()->user()->hasPermission('addresses-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('addresses.restore' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                         {{__('Restore')}}
                      </a>
                      @else
                      <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                        <i class="fas fa-pencil-alt">
                        </i>
                       {{__('Restore')}}
                    </a>
                    @endif
                                @endif

                                @if ((auth()->user()->hasPermission('addresses-delete'))| (auth()->user()->hasPermission('addresses-trash')))

                                    <form method="POST" action="{{route('addresses.destroy' , ['lang'=>app()->getLocale() , 'address'=>$address->id , 'user'=>$user->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($address->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button  class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($address->trashed())
                                      {{ __('Delete') }}
                                      @else
                                      {{ __('Trash') }}
                                      @endif
                                  </button>
                                  @endif


                    </td>
                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $addresses->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No addresses To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
