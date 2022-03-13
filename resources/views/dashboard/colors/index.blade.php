@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Colors') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Colors') }}</li>
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
                            @if (auth()->user()->hasPermission('colors-create'))
                                <a href="{{ route('colors.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create color') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create color') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Colors') }}</h3>

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
                @if ($colors->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>

                                <th>
                                    {{ __('Color') }}
                                </th>
                                <th>
                                    {{ __('Color Arabic Name') }}
                                </th>
                                <th>
                                    {{ __('Color English Name') }}
                                </th>

                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <th>
                                    {{ __('Updated At') }}
                                </th>
                                <?php if ($colors !== null) {
                                    $color = $colors[0];
                                } ?>
                                @if ($color->trashed())
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

                                @foreach ($colors->reverse() as $color)
                                    <td>
                                        {{ $color->id }}
                                    </td>


                                    <td
                                        style="width:60px; height:100%; background-color:{{ $color->hex }}; margin:10px; border-radius:10px;">

                                    </td>

                                    <td>
                                        <small>
                                            {{ $color->color_ar }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $color->color_en }}
                                        </small>
                                    </td>

                                    <td>
                                        <small>
                                            {{ $color->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $color->updated_at }}
                                        </small>
                                    </td>
                                    @if ($color->trashed())
                                        <td>
                                            <small>
                                                {{ $color->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">

                                        @if (!$color->trashed())
                                            @if (auth()->user()->hasPermission('colors-update'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('colors.edit', ['lang' => app()->getLocale(), 'color' => $color->id]) }}">
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
                                            @if (auth()->user()->hasPermission('colors-restore'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('colors.restore', ['lang' => app()->getLocale(), 'color' => $color->id]) }}">
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

                                        @if (auth()->user()->hasPermission('colors-delete') |
    auth()->user()->hasPermission('colors-trash'))
                                            <form method="POST"
                                                action="{{ route('colors.destroy', ['lang' => app()->getLocale(), 'color' => $color->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($color->trashed())
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
                                                @if ($color->trashed())
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

                <div class="row mt-3"> {{ $colors->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No Colors To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
