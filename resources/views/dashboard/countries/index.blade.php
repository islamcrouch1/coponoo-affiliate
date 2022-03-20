@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Countries') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Countries') }}</li>
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
                                <input type="text" name="search" autofocus placeholder="{{ __('Search..') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                            @if (auth()->user()->hasPermission('countries-create'))
                                <a href="{{ route('countries.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create Country') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create Country') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Countries') }}</h3>

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
                @if ($countries->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('image') }}
                                </th>
                                <th>
                                    {{ __('Arabic Name') }}
                                </th>
                                <th>
                                    {{ __('English Name') }}
                                </th>
                                <th>
                                    {{ __('Country Code') }}
                                </th>
                                <th>
                                    {{ __('Currency') }}
                                </th>
                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <th>
                                    {{ __('Updated At') }}
                                </th>
                                <?php if ($countries !== null) {
                                    $country = $countries[0];
                                } ?>
                                @if ($country->trashed())
                                    <th>
                                        {{ __('Deleted At') }}
                                    </th>
                                @endif
                                <th style="" class="">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($countries->reverse() as $country)
                                    <td>
                                        {{ $country->id }}
                                    </td>
                                    <td>

                                        <img alt="Avatar" class="table-avatar"
                                            src="{{ asset('storage/' . $country->image) }}">

                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->name_ar }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->name_en }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->code }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->currency }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $country->updated_at }}
                                        </small>
                                    </td>
                                    @if ($country->trashed())
                                        <td>
                                            <small>
                                                {{ $country->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">
                                        <div class="row">

                                        @if (!$country->trashed())
                                            @if (auth()->user()->hasPermission('countries-update'))
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}"
                                                    href="{{ route('countries.edit', ['lang' => app()->getLocale(), 'country' => $country->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Edit') }}" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @endif
                                        @else
                                            @if (auth()->user()->hasPermission('countries-restore'))
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Restore') }}"
                                                    href="{{ route('countries.restore', ['lang' => app()->getLocale(), 'country' => $country->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                   
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @endif
                                        @endif

                                        @if (auth()->user()->hasPermission('countries-delete') |
    auth()->user()->hasPermission('countries-trash'))
                                            <form method="POST"
                                                action="{{ route('countries.destroy', ['lang' => app()->getLocale(), 'country' => $country->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                
                                    
                                            
                                                    @if ($country->trashed())
                                                    <div class="col-md-6">
                                                    <button type="submit" class="btn btn-danger btn-sm delete"data-toggle="tooltip" data-placement="top" title=" {{ __('Delete') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button>
                                                    </div>

                                                    @else
                                                    <div class="col-md-6">
                                                    <button type="submit" class="btn btn-danger btn-sm delete"data-toggle="tooltip" data-placement="top" title=" {{ __('Trash') }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </button> 
                                                    </div>
                                                    @endif
                                               
                                            </form>
                                        @else
                                            
                                                @if ($country->trashed())
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Delete') }}" >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button> 
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="  {{ __('Trash') }}" >
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

                <div class="row mt-3"> {{ $countries->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No Countries To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
