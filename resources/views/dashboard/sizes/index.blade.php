@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Sizes') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Sizes') }}</li>
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
                            @if (auth()->user()->hasPermission('sizes-create'))
                                <a href="{{ route('sizes.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create Sizes') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create size') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Sizes') }}</h3>

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
                @if ($sizes->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('Size_ar') }}
                                </th>
                                <th>
                                    {{ __('Size_en') }}
                                </th>
                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <th>
                                    {{ __('Updated At') }}
                                </th>
                                <?php if ($sizes !== null) {
                                    $size = $sizes[0];
                                } ?>
                                @if ($size->trashed())
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

                                @foreach ($sizes->reverse() as $size)
                                    <td>
                                        {{ $size->id }}
                                    </td>

                                    <td>
                                        <small>
                                            {{ $size->size_ar }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $size->size_en }}
                                        </small>
                                    </td>

                                    <td>
                                        <small>
                                            {{ $size->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $size->updated_at }}
                                        </small>
                                    </td>
                                    @if ($size->trashed())
                                        <td>
                                            <small>
                                                {{ $size->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">
                                        <div class="row">


                                        @if (!$size->trashed())
                                            @if (auth()->user()->hasPermission('sizes-update'))
                                            <div class="col-md-6">

                                                <a class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title=" {{ __('Edit') }}"
                                                    href="{{ route('sizes.edit', ['lang' => app()->getLocale(), 'size' => $size->id]) }}">
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
                                            @if (auth()->user()->hasPermission('sizes-restore'))
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Restore') }}"
                                                    href="{{ route('sizes.restore', ['lang' => app()->getLocale(), 'size' => $size->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title=" {{ __('Restore') }}" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                   
                                                </a>
                                            </div>
                                            @endif
                                        @endif

                                        @if (auth()->user()->hasPermission('sizes-delete') |
    auth()->user()->hasPermission('sizes-trash'))
                                            <form method="POST"
                                                action="{{ route('sizes.destroy', ['lang' => app()->getLocale(), 'size' => $size->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                            
                                                    @if ($size->trashed())

                                                    <div class="col-md-6">
                                                      
                                                <button type="submit" class="btn btn-danger btn-sm delete"data-toggle="tooltip" data-placement="top" title=" {{ __('Delete') }}" >
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </button>
                                                    </div>
                                                
                                                    @else
                                                    <div class="col-md-6">
                                                <button type="submit" class="btn btn-danger btn-sm delete"data-toggle="tooltip" data-placement="top" title=" {{ __('Trash') }}" >
                                                        <i class="fas fa-trash">
                                                        </i>
                                                </button>
                                                    </div>
                                                    @endif
                                                
                                            </form>
                                        @else
                                            
                                                @if ($size->trashed())
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Delete') }}" >
                                                    <i class="fas fa-trash">
                                                    </i> 
                                                </button>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                <button class="btn btn-danger btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Trash') }}" >
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

                <div class="row mt-3"> {{ $sizes->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No Sizes To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
