@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('Roles')}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
              <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
              <li class="breadcrumb-item active">{{__('Roles')}}</li>
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
                <input type="text" name="search" autofocus placeholder="Search by role name.." class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>{{__('Search')}}</button>
                @if (auth()->user()->hasPermission('roles-create'))
                <a href="{{route('roles.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">{{__('Create Role')}}</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">{{__('Create Role')}}</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">{{__('Roles')}}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($roles->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                          {{__('Role Name')}}
                      </th>
                      <th>
                          {{__('Role Description')}}
                      </th>
                      <th>
                        {{__('permissions')}}
                    </th>
                    <th>
                      {{__('Users Count')}}
                  </th>
                      <th>
                        {{__('Created At')}}
                    </th>
                    <th>
                      {{__('Updated At')}}
                  </th>
                  <?php if($roles !== Null){$role = $roles[0];} ?>
                  @if ($role->trashed())
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

                      @foreach ($roles->reverse() as $role)
                    <td>
                        {{ $role->id }}
                    </td>
                    <td>
                        <small>
                            {{ $role->name }}
                        </small>
                    </td>
                    <td>

                      {{ $role->description }}

                    </td>
                    <td>

                      @foreach ($role->permissions as $permission)
                      <h5 style="display: inline-block"><span class="badge badge-info">{{$permission->name}}</span></h5>

                      @endforeach

                    </td>
                    <td>

                      {{-- {{ $role->users()->count() }} --}}
                      {{ $role->users_count }}

                    </td>
                    <td>
                        <small>
                            {{ $role->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $role->updated_at }}
                      </small>
                  </td>
                  @if ($role->trashed())
                  <td>
                    <small>
                        {{ $role->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$role->trashed())
                        @if (auth()->user()->hasPermission('roles-update'))
                        <a class="btn btn-info btn-sm" href="{{route('roles.edit' , ['lang'=>app()->getLocale() , 'role'=>$role->id])}}">
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
                        @if (auth()->user()->hasPermission('roles-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('roles.restore' , ['lang'=>app()->getLocale() , 'role'=>$role->id])}}">
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

                                @if ((auth()->user()->hasPermission('roles-delete'))| (auth()->user()->hasPermission('roles-trash')))

                                    <form method="POST" action="{{route('roles.destroy' , ['lang'=>app()->getLocale() , 'role'=>$role->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($role->trashed())
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
                                      @if ($role->trashed())
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

          <div class="row mt-3"> {{ $roles->appends(request()->query())->links() }}</div>

          @else <h3>{{__('No Roles To Show')}}</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
