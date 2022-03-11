@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Shipping Rates') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Shipping Rates') }}</li>
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
                        <div class="col-md-2">
                            <select class="form-control" name="country_id" style="display:inline-block">
                                <option value="" selected>All countries</option>
                                @foreach ($shipping_rates as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                            @if (auth()->user()->hasPermission('shipping_rates-create'))
                                <a href="{{ route('shipping_rates.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create shipping rate') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create shipping_rate') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Shipping Rates') }}</h3>

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
                @if ($shipping_rates->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('City Arabic Name') }}
                                </th>
                                <th>
                                    {{ __('City English Name') }}
                                </th>
                                <th>
                                    {{ __('Shipping Rate') }}
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
                                <?php if ($shipping_rates !== null) {
                                    $shipping_rate = $shipping_rates[0];
                                } ?>
                                @if ($shipping_rate->trashed())
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

                                @foreach ($shipping_rates->reverse() as $shipping_rate)
                                    <td>
                                        {{ $shipping_rate->id }}
                                    </td>

                                    <td>
                                        <small>
                                            {{ $shipping_rate->city_ar }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->city_en }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->cost }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->country->currency }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->updated_at }}
                                        </small>
                                    </td>
                                    @if ($shipping_rate->trashed())
                                        <td>
                                            <small>
                                                {{ $shipping_rate->deleted_at }}
                                            </small>
                                        </td>
                                    @endif
                                    <td class="project-actions">

                                        @if (!$shipping_rate->trashed())
                                            @if (auth()->user()->hasPermission('shipping_rates-update'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('shipping_rates.edit', ['lang' => app()->getLocale(), 'shipping_rate' => $shipping_rate->id]) }}">
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
                                            @if (auth()->user()->hasPermission('shipping_rates-restore'))
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route('shipping_rates.restore', ['lang' => app()->getLocale(), 'shipping_rate' => $shipping_rate->id]) }}">
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

                                        @if (auth()->user()->hasPermission('shipping_rates-delete') |
    auth()->user()->hasPermission('shipping_rates-trash'))
                                            <form method="POST"
                                                action="{{ route('shipping_rates.destroy', ['lang' => app()->getLocale(), 'shipping_rate' => $shipping_rate->id]) }}"
                                                enctype="multipart/form-data" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($shipping_rate->trashed())
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
                                                @if ($shipping_rate->trashed())
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

                <div class="row mt-3"> {{ $shipping_rates->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No shipping rates To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
