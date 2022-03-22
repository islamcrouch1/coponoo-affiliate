@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('products') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('products') }}
                        </li>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="search" autofocus placeholder="{{ __('Search..') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="category_id" style="display:inline-block">
                                <option value="" selected>All Categories</option>
                                @foreach ($categories as $category)
                                    @if ($category->parent == 'null')
                                        <optgroup
                                            label="{{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}">
                                            <option value="{{ $category->id }}"
                                                {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                {{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}
                                            </option>
                                            @foreach ($categories->where('parent', $category->id) as $category1)
                                                <option value="{{ $category1->id }}"
                                                    {{ request()->category_id == $category1->id ? 'selected' : '' }}>
                                                    {{ app()->getLocale() == 'ar'? $category1->name_ar . ' - ' . $category1->country->name_ar: $category1->name_en . ' - ' . $category1->country->name_en }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="country_id" style="display:inline-block">
                                <option value="" selected>All Countries</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="" selected>{{ __('status') }}
                                </option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                                    {{ __('pending') }}</option>
                                <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                    {{ __('active') }}</option>
                                <option value="rejected" {{ request()->status == 'rejected' ? 'selected' : '' }}>
                                    {{ __('rejected') }}</option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                            @if (auth()->user()->hasPermission('products-create'))
                                <a href="{{ route('products.create', app()->getLocale()) }}">
                                    <button type="button" class="btn btn-primary">{{ __('Create product') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create product') }}</button></a>
                            @endif

                        </div>
                        <div class="col-md-2">

                            @if (auth()->user()->hasPermission('users-read'))
                                <a
                                    href="{{ route('products.export', ['lang' => app()->getLocale(),'category' => request()->category_id,'status' => request()->status]) }}">
                                    <button type="button" class="btn btn-info">{{ __('Export Products') }}
                                        <i class="fas fa-file-excel"></i>
                                    </button></a>
                            @else
                                <a href="#" disabled> <button type="button"
                                        class="btn btn-primary">{{ __('Export Products') }}
                                        <i class="fas fa-file-excel"></i>
                                    </button></a>
                            @endif
                        </div>

                    </div>
                </form>

                <form action="{{ route('products.import', ['lang' => app()->getLocale()]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <input style="width: 200px" type="file" name="file"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />

                        <button type="submit" class="btn btn-primary">{{ __('Import') }}</button>
                    </div>
                </form>

            </div>
        </div>



        <div class="card">
            <div class="card-header">




                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                @if (session()->has('failures'))
                    <table class="table table-danger">
                        <tr>
                            <th>Row</th>
                            <th>Attribute</th>
                            <th>Errors</th>
                            <th>Value</th>
                        </tr>

                        @foreach (session()->get('failures') as $validation)
                            <tr>
                                <td>{{ $validation->row() }}</td>
                                <td>{{ $validation->attribute() }}</td>
                                <td>
                                    <ul>
                                        @foreach ($validation->errors() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{ $validation->values()[$validation->attribute()] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif



                {{-- <h3 class="card-title">products</h3> --}}
                <div class="row mt-3">
                    {{ $products->appends(request()->query())->links() }}</div>

                {{-- <div class="card-tools">

                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div> --}}
            </div>
            <div class="card-body p-0 table-responsive">




                <form class="select-form" id="select-form" method="POST"
                    action="{{ route('products-change-status-all', ['lang' => app()->getLocale()]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')


                    <div class="row">

                        <div class="col-md-1">
                            <select class="form-control" name="status" style="display:inline-block">
                                <option value="pending" selected>
                                    {{ __('pending') }}</option>
                                <option value="active">{{ __('active') }}
                                </option>
                                <option value="rejected">{{ __('rejected') }}
                                </option>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="select-button" class="btn btn-info ">{{ __('Change Products Status') }}</button>
                        </div>


                    </div>

                    @if ($products->count() > 0)
                        <table class="table table-striped projects">
                            <thead>
                                <tr>

                                    <th style="padding-bottom: 34px ;"><input class="form-check-input" type="checkbox"
                                            value="" id="checkall"></th>
                                    <th>#id</th>
                                    <th>SKU</th>
                                    <th>{{ __('Image') }}</th>
                                    @if (app()->getLocale() == 'ar')
                                        <th>{{ __('Arabic Name') }}</th>
                                    @else
                                        <th>{{ __('English Name') }}</th>
                                    @endif
                                    <th>{{ __('Vendor ID') }}</th>
                                    <th>{{ __('Vendor price') }}</th>
                                    <th>{{ __('Min price') }}</th>
                                    <th>{{ __('Max price') }}</th>
                                    <th>{{ __('stock') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Updated At') }}</th>

                                    <?php if ($products !== null) {
                                        $product = $products[0];
                                    } ?>
                                    @if ($product->trashed())
                                        <th>{{ __('Deleted At') }}</th>
                                    @endif
                                    <th style="" class="">
                                        {{ __('Actions') }}</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $product)
                                    <tr>

                                        @if ($product->images->count() != 0)
                                            @php
                                                $url = $product->images[0]->url;
                                            @endphp
                                        @else
                                            @php
                                                $url = 'place-holder.png';
                                            @endphp
                                        @endif

                                        <td style="padding-bottom: 34px ;"><input class="form-check-input" type="checkbox"
                                                value="{{ $product->id }}" class="cb-element" name="checkAll[]"
                                                style="margin-right: 11px;
                                                                                                                                                            margin-left: 11px;">
                                        </td>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->SKU }}</td>
                                        <td><img alt="Avatar" class="table-avatar"
                                                src="{{ asset('storage/images/products/' . $url) }}">
                                        </td>
                                        @if (app()->getLocale() == 'ar')
                                            <td><small>{{ $product->name_ar }}
                                                    @if ($product->categories()->count() > 1)
                                                        <span
                                                            class="badge badge-secondary">{{ __('multiple categories') }}</span>
                                                    @endif
                                                </small></td>
                                        @else
                                            <td><small>{{ $product->name_en }}
                                                    @if ($product->categories()->count() > 1)
                                                        <span
                                                            class="badge badge-secondary">{{ __('multiple categories') }}</span>
                                                    @endif
                                                </small></td>
                                        @endif

                                        <td>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('users.show', [app()->getLocale(), $product->user->id]) }}">
                                                <small>{{ $product->user_id }}</small>
                                            </a>
                                        </td>
                                        <td><small> <b>
                                                    {{ $product->vendor_price . ' ' . $product->country->currency }}</b></small>
                                        </td>
                                        <td><small><b>{{ $product->min_price . ' ' . $product->country->currency }}</b></small>
                                        </td>
                                        <td><small><b>{{ $product->max_price . ' ' . $product->country->currency }}</b></small>
                                        </td>
                                        @php
                                            $stock1 = 0;
                                        @endphp
                                        @foreach ($product->stocks as $stock)
                                            @php
                                                $stock1 = $stock1 + $stock->stock;
                                            @endphp
                                        @endforeach
                                        <td><small>{{ $stock1 }}</small></td>
                                        <td>

                                            @if ($product->status == 'pending')
                                                <span class='badge badge-warning'>{{ __($product->status) }}</span>
                                            @elseif($product->status == 'rejected')
                                                <span class='badge badge-danger'>{{ __($product->status) }}</span>
                                            @elseif($product->status == 'active')
                                                <span class='badge badge-success'>{{ __($product->status) }}</span>
                                            @endif

                                            @if ($product->limits()->where('product_id', $product->id)->get()->count() != 0)
                                                <span class='badge badge-danger'>{{ __('Unlimited') }}</span>
                                            @endif

                                        </td>
                                        <td><small>{{ $product->created_at }}</small>
                                        </td>
                                        <td><small>{{ $product->updated_at }}</small>
                                        </td>

                                        @if ($product->trashed())
                                            <td><small>{{ $product->deleted_at }}</small>
                                            </td>
                                        @endif

                                        <td class="project-actions">
                                            <div style="width:120px" class="row">


                                                {{-- <a class="btn btn-primary btn-sm btnn" href="{{route('users.show' , [app()->getLocale() , $product->user->id])}}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                    {{__('Vendor Info')}}
                                                    </a> --}}


                                                <div class="col-md-6">
                                                    <a class="btn btn-primary btn-sm btnn" data-toggle="tooltip"
                                                        data-placement="top" title=" {{ __('Show Product') }} "
                                                        href="{{ route('products.show', [app()->getLocale(), $product->id]) }}">
                                                        <i class="fas fa-eye">
                                                        </i>

                                                    </a>

                                                </div>

                                                @if ($product->vendor_id == null)
                                                    <div class="col-md-6">
                                                        <a class="btn btn-secondary btn-sm btnn" data-toggle="tooltip"
                                                            data-placement="top" title=" {{ __('Not reviewed') }}"
                                                            href="#">
                                                            <i class="fas fa-pencil-alt">
                                                            </i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <a class="btn btn-secondary btn-sm btnn" data-toggle="tooltip"
                                                            data-placement="top" title=" {{ __('Admin Info') }}"
                                                            href="{{ route('users.show', [app()->getLocale(), $product->vendor_id]) }}">
                                                            <i class=" fas fa-solid fa-user"></i>
                                                        </a>
                                                    </div>
                                                @endif


                                                @if (!$product->trashed())
                                                    @if (auth()->user()->hasPermission('products-update'))
                                                        <div class="col-md-6">
                                                            <a class="btn btn-info btn-sm btnn" data-toggle="tooltip"
                                                                data-placement="top" title="{{ __('Edit') }}"
                                                                href="{{ route('products.edit', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                <i class="fas fa-pencil-alt">
                                                                </i>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">

                                                            <a class="btn btn-info btn-sm btnn" data-toggle="tooltip"
                                                                data-placement="top" title="{{ __('Add color') }}"
                                                                href="{{ route('products.color', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                <i class="fas fa-solid fa-brush"></i>
                                                            </a>

                                                        </div>
                                                        <div class="col-md-6">

                                                            <button type="button" class="btn btn-primary btn-sm btnn"
                                                                data-toggle="modal"
                                                                data-target="#modal-primary-{{ $product->id }}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title=" {{ __('Change Product Status') }}">
                                                                <i class="fas fa-calendar-check">
                                                                </i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="col-md-6">
                                                            <a class="btn btn-info btn-sm btnn" href="#"
                                                                aria-disabled="true">
                                                                <i class="fas fa-pencil-alt">
                                                                </i>
                                                                {{ __('Edit') }}
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">

                                                            <a class="btn btn-info btn-sm btnn" href="#"
                                                                aria-disabled="true">
                                                                <i class="fas fa-color">
                                                                </i>
                                                                {{ __('Add color') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (auth()->user()->hasPermission('products-restore'))
                                                        <div class="col-md-6">
                                                            <a class="btn btn-info btn-sm btnn" data-toggle="tooltip"
                                                                data-placement="top" title=" {{ __('Restore') }}"
                                                                href="{{ route('products.restore', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                                <i class="fas fa-trash-restore">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="col-md-6">


                                                            <a class="btn btn-info btn-sm btnn" href="#"
                                                                aria-disabled="true" data-toggle="tooltip"
                                                                data-placement="top" title=" {{ __('Restore') }}">
                                                                <i class="fas fa-trash-restore">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif



                                                @if (auth()->user()->hasPermission('products-delete') ||
    auth()->user()->hasPermission('products-trash'))
                                                    <div class="col-md-6">
                                                        <a href="{{ route('products.destroy.new', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                                                            class="btn btn-danger btn-sm delete btnn" data-toggle="tooltip"
                                                            data-placement="top" title=" {{ __('Delete') }}">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            @if ($product->trashed())
                                                            @else
                                                            @endif
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <button class="btn btn-danger btn-sm btnn">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                            @if ($product->trashed())
                                                                {{ __('Delete') }}
                                                            @else
                                                                {{ __('Trash') }}
                                                            @endif
                                                        </button>
                                                    </div>
                                                @endif



                                            </div>









                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                </form>

                <div class="row mt-3">
                    {{ $products->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No products To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


    @foreach ($products as $product)
        <div class="modal fade" id="modal-primary-{{ $product->id }}">
            <div class="modal-dialog">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h4 style="direction: rtl;" class="modal-title">
                            {{ __('Change Product Status') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST"
                        action="{{ route('products.update.order', ['lang' => app()->getLocale(), 'product' => $product->id]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-5 col-form-label">{{ __('Select Product Status') }}</label>
                                <div class="col-md-7">

                                    <select style="height: 50px;"
                                        class=" form-control @error('status') is-invalid @enderror" name="status"
                                        value="{{ old('status') }}" required autocomplete="status">

                                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                            {{ __('active') }}</option>
                                        <option value="rejected" {{ $product->status == 'rejected' ? 'selected' : '' }}>
                                            {{ __('rejected') }}</option>

                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light"
                                data-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-outline-light">{{ __('Save changes') }}</button>
                        </div>

                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endforeach


@endsection
