@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Slides') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Slides') }}</li>
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
                            @if (auth()->user()->hasPermission('slides-create'))
                                <a href="{{ route('slides.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create Slide') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create Slide') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Slides') }}</h3>

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
                @if ($slides->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('Slide ID') }}
                                </th>
                                <th>
                                    {{ __('image') }}
                                </th>
                                <th>
                                    {{ __('URL') }}
                                </th>

                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <th>
                                    {{ __('Updated At') }}
                                </th>
                                <?php if ($slides !== null) {
                                    $slide = $slides[0];
                                } ?>
                                @if ($slide->trashed())
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

                                @foreach ($slides->reverse() as $slide)
                                    <td>
                                        {{ $slide->id }}
                                    </td>
                                    <td>
                                        {{ $slide->slide_id }}
                                    </td>
                                    <td>

                                        <img alt="Avatar" class="table-avatar"
                                            src="{{ asset('storage/' . $slide->image) }}">

                                    </td>
                                    <td> <a href="{{ $slide->url }}">
                                            <small>
                                                {{ __('URL') }}
                                            </small></a>
                                    </td>

                                    <td>
                                        <small>
                                            {{ $slide->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $slide->updated_at }}
                                        </small>
                                    </td>
                                    @if ($slide->trashed())
                                        <td>
                                            <small>
                                                {{ $slide->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">

                                        @if (!$slide->trashed())
                                            @if (auth()->user()->hasPermission('slides-update'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('slides.edit', ['lang' => app()->getLocale(), 'slide' => $slide->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    {{ __('Edit') }}
                                                </a>
                                            @else
                                                <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    {{ __('Edit') }}
                                                </a>
                                            @endif
                                        @else
                                            @if (auth()->user()->hasPermission('slides-restore'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('slides.restore', ['lang' => app()->getLocale(), 'slide' => $slide->id]) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    {{ __('Restore') }}
                                                </a>
                                            @else
                                                <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    {{ __('Restore') }}
                                                </a>
                                            @endif
                                        @endif

                                        @if (auth()->user()->hasPermission('slides-delete') |
    auth()->user()->hasPermission('slides-trash'))
                                            <form method="POST"
                                                action="{{ route('slides.destroy', ['lang' => app()->getLocale(), 'slide' => $slide->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($slide->trashed())
                                                        {{ __('Delete') }}
                                                    @else
                                                        {{ __('Trash') }}
                                                    @endif
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash">
                                                </i>
                                                @if ($slide->trashed())
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

                <div class="row mt-3"> {{ $slides->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No slides To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
