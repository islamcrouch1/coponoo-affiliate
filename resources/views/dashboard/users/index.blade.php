@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Users') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Users') }}</li>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="search" autofocus
                                    placeholder="{{ __('Search by phone or email or name..') }}" class="form-control"
                                    value="{{ request()->search }}">
                            </div>
                        </div>

                        <div class="col-md-1" style="text-align: center">
                            <label for="from" class="col-md-2 col-form-label">{{ __('From') }}</label>
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="from" class="form-control" value="{{ request()->from }}">
                        </div>



                        <div class="col-md-1" style="text-align: center">
                            <label for="to" class="col-md-2 col-form-label">{{ __('To') }}</label>
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="to" class="form-control" value="{{ request()->to }}">
                        </div>

                        <div class="col-md-2">
                            <select class="form-control" name="role_id" style="display:inline-block">
                                <option value="" selected>{{ __('All Roles') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ request()->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('All Status') }}</option>
                                <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                    {{ __('avtive') }}</option>
                                <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>
                                    {{ __('inactive') }}</option>
                                <option value="blocked" {{ request()->status == 'blocked' ? 'selected' : '' }}>
                                    {{ __('blocked') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="country_id" style="display:inline-block">
                                <option value="" selected>{{ __('All Countries') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                            @if (auth()->user()->hasPermission('users-create'))
                                <a href="{{ route('users.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create user') }}
                                    </button></a>
                            @else
                                <a href="#" disabled> <button type="button"
                                        class="btn btn-primary">{{ __('Create user') }}</button></a>
                            @endif
                            @if (auth()->user()->hasPermission('users-read'))
                                <a href="{{ route('users.export', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-info">{{ __('Export User') }}
                                        <i class="fas fa-file-excel"></i>
                                    </button></a>
                            @else
                                <a href="#" disabled> <button type="button"
                                        class="btn btn-primary">{{ __('Export User') }}
                                        <i class="fas fa-file-excel"></i>
                                    </button></a>
                            @endif
                        </div>
                        {{-- <div class="col-md-3">
                    @if (auth()->user()->hasPermission('wallet-read'))
                        <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#modal-danger">
                            {{__('Add Wallet Balance To All Users')}}
                        </button>
                    @endif
              </div> --}}
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Users') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                @if ($users->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('Name') }}
                                </th>
                                <th>
                                    {{ __('Profile') }}
                                </th>
                                <th>
                                    {{ __('user country') }}
                                </th>
                                <th>
                                    {{ __('user Roles') }}
                                </th>
                                {{-- <th>
                        {{__('Orders')}}
                    </th> --}}
                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <?php if ($users !== null) {
                                    $user = $users[0];
                                } ?>
                                @if ($user->trashed())
                                    <th>
                                        {{ __('Deleted At') }}
                                    </th>
                                @endif
                                <th style="" class="text-center">
                                    {{ __('Status') }}
                                </th>
                                <th style="" class="">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($users as $user)
                                    <td>
                                        {{ $user->id }}
                                    </td>
                                    <td>
                                        <small>
                                            <a
                                                href="{{ route('users.show', [app()->getLocale(), $user->id]) }}">{{ $user->name }}</a>

                                        </small>
                                    </td>
                                    <td>

                                        <a href="{{ route('users.show', [app()->getLocale(), $user->id]) }}">
                                            <img alt="Avatar" class="table-avatar"
                                                src="{{ asset('storage/images/users/' . $user->profile) }}">

                                        </a>

                                    </td>

                                    <td>
                                        <small>
                                            {{ app()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{-- {{ implode(', ' , $user->roles->pluck('name')->toArray()) }} --}}
                                            @foreach ($user->roles as $role)
                                                <h5 style="display: inline-block"><span
                                                        class="badge badge-primary">{{ $role->name }}</span></h5>
                                            @endforeach
                                        </small>
                                    </td>
                                    {{-- <td>
                    <small>
                        @if (auth()->user()->hasPermission('orders-read'))
                        <a href="{{route('orders.create' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">{{__('add order')}}</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">{{__('add order')}}</a>

                        @endif
                    </small>
                    <small>
                        @if (auth()->user()->hasPermission('addresses-read'))
                        <a href="{{route('addresses.index' , ['lang' => app()->getLocale() , 'user' => $user->id])}}" class="btn btn-sm btn-primary">{{__('add address')}}</a>
                        @else
                        <a href="#" class="btn btn-sm btn-primary disabled">{{__('add address')}}</a>

                        @endif
                    </small>
                </td> --}}
                                    <td>
                                        <small>
                                            {{ $user->created_at }}
                                        </small>
                                    </td>
                                    @if ($user->trashed())
                                        <td>
                                            <small>
                                                {{ $user->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-state">
                                        @if ($user->status == 'active')
                                            <span class='badge badge-success'>{{ __('Active') }}</span>
                                        @elseif ($user->status == 'inactive')
                                            <span class='badge badge-danger'>{{ __('Not Active') }}</span>
                                        @elseif ($user->status == 'blocked')
                                            <span class='badge badge-danger'>{{ __('blocked') }}</span>
                                        @endif
                                    </td>
                                    <td class="project-actions">
                                        <div class="row">

                                        @if (!$user->trashed())
                                            @if (auth()->user()->hasPermission('homeworks_monitor-read'))
                                                @if ($user->hasRole('administrator'))
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"data-toggle="tooltip" data-placement="top" title=" {{ __('Permissions') }}"
                                                        data-target="#modal-primary-{{ $user->id }}">
                                                       
                                                    </button>
                                                </div>
                                                @endif
                                            @endif


                                            {{-- @if (auth()->user()->hasPermission('wallet-read'))
                            @if (!$user->hasRole('administrator'))
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"data-toggle="tooltip" data-placement="top" title=" {{__('Add Wallet Balance')}}" 
                                data-target="#modal-info-{{$user->id}}">
                                   
                                </button>
                            </div>
                            @endif
                        @endif --}}



                                            @if (auth()->user()->hasPermission('users-read'))
                                            <div class="col-md-3">
                                                <a class="btn btn-primary btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('View') }}"
                                                    href="{{ route('users.show', [app()->getLocale(), $user->id]) }}">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-3">
                                                <a class="btn btn-primary btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('View') }}"
                                                 href="#" aria-disabled="true">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                   
                                                </a>
                                            </div>
                                            @endif
                                            @if (auth()->user()->hasPermission('users-update'))
                                            <div class="col-md-3">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"
                                                    href="{{ route('users.edit', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-3">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" 
                                                href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @endif
                                            @if (auth()->user()->hasPermission('users-update') && $user->status !== 'blocked')
                                                @if ($user->hasVerifiedPhone())
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Deactivate') }}"
                                                        href="{{ route('users.deactivate', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    </a>
                                                </div>
                                                @else
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Activate') }}"
                                                        href="{{ route('users.activate', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                        <i class=" fas fa-solid fa-file-slash"></i>
                                                    </a>
                                                </div>
                                                @endif
                                            @elseif(!auth()->user()->hasPermission('users-update') && $user->status !== 'blocked')
                                                @if ($user->hasVerifiedPhone())
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Deactivate') }}" 
                                                    href="#">
                                                    
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    </a>
                                                </div>
                                                @else
                                                <div class="col-md-3">
    
                                                     <a class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('Activate') }}"
                                                     href="#">
                                                     <i class=" fas fa-solid fa-file-slash"></i>
                                                    </a>
                                                </div>
                                                @endif
                                            @endif

                                            @if (auth()->user()->hasPermission('users-update'))
                                                @if ($user->status == 'active')
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Block') }}"
                                                        href="{{ route('users.block', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                        <i class=" fas fa-solid fa-ban"></i>
                                                    </a>
                                                </div> 
                                                @else
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Unblock') }}"
                                                        href="{{ route('users.activate', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                        
                                                    </a>
                                                </div>
                                                @endif
                                            @else
                                                @if ($user->status == 'active')
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Block') }}"
                                                     href="#">
                                                        
                                                    </a>
                                                </div>
                                                @else
                                                <div class="col-md-3">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Unblock') }}"
                                                     href="#">
                                                       
                                                    </a>
                                                </div>
                                                @endif
                                            @endif
                                        @else
                                            @if (auth()->user()->hasPermission('users-restore'))
                                            <div class="col-md-3">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}"
                                                    href="{{ route('users.restore', ['lang' => app()->getLocale(), 'user' => $user->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-3">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Restore') }}"
                                                 href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                   
                                                </a>
                                            </div>
                                            @endif
                                        @endif

                                        @if (auth()->user()->hasPermission('users-delete') |
    auth()->user()->hasPermission('users-trash'))
                                            <form method="POST"
                                                action="{{ route('users.destroy', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')

                                               
                                                    @if ($user->trashed())
                                                    <div class="col-md-3">
                                                    <button type="submit" class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-placement="top" title="  {{ __('Delete') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button>
                                                    </div>
                                                    @else
                                                    <div class="col-md-3">
                                                    <button type="submit" class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-placement="top" title="   {{ __('Trash') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button>
                                                    </div>
                                                       
                                                    @endif
                                               
                                            </form>
                                        @else
                                           
                                                @if ($user->trashed())
                                                <div class="col-md-3">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="  {{ __('Delete') }}" >
                                                    <i class="fas fa-trash">
                                                    </i> 
                                                </button>
                                                </div>
                                                @else
                                                <div class="col-md-3">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="   {{ __('Trash') }}" >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button>
                                                </div>
                                                   
                                                @endif
                                            
                                        @endif



                                    </div>            

                                    </td>
                            </tr>
                @endforeach

                </tbody>
                </table>

                <div class="row mt-3"> {{ $users->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No Users To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->





@endsection
