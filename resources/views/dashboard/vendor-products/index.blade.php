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
                        <li class="breadcrumb-item active">{{ __('products') }}</li>
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
                                    <option value="{{ $category->id }}"
                                        {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                        {{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}
                                    </option>
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
                                <option value="" selected>{{ __('status') }}</option>
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
                            @if (auth()->user()->HasRole('vendor'))
                                <a href="{{ route('vendor-products.create', app()->getLocale()) }}"> <button
                                        type="button" class="btn btn-primary">{{ __('Create product') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create product') }}</button></a>
                            @endif
                        </div>
                        <div class="col-md-2">

                            @if (auth()->user()->HasRole('vendor'))
                                <a href="{{ route('products.export.vendor', app()->getLocale()) }}"> <button
                                        type="button" class="btn btn-info">{{ __('Export Products') }}
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

                <form action="{{ route('products.import.vendor', ['lang' => app()->getLocale()]) }}" method="post"
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
                @if ($products->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>

                                <th>#id</th>
                                <th>SKU</th>
                                <th>{{ __('Image') }}</th>
                                @if (app()->getLocale() == 'ar')
                                    <th>{{ __('Arabic Name') }}</th>
                                @else
                                    <th>{{ __('English Name') }}</th>
                                @endif
                                <th>{{ __('Vendor price') }}</th>
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
                                <th style="" class="">{{ __('Actions') }}</th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr>

                                @foreach ($products->reverse() as $product)
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->SKU }}</td>
                                    <td><img alt="Avatar" class="table-avatar"
                                            src="{{ asset('storage/images/products/' . $product->images[0]->url) }}">
                                    </td>
                                    @if (app()->getLocale() == 'ar')
                                        <td><small>{{ $product->name_ar }}</small></td>
                                    @else
                                        <td><small>{{ $product->name_en }}</small></td>
                                    @endif
                                    <td><small>{{ $product->vendor_price . ' ' . $product->country->currency }}</small>
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
                                        @elseif ($product->status == 'rejected')
                                            <span class='badge badge-danger'>{{ __($product->status) }}</span>
                                        @elseif ($product->status == 'active')
                                            <span class='badge badge-success'>{{ __($product->status) }}</span>
                                        @endif

                                    </td>
                                    <td><small>{{ $product->created_at }}</small></td>
                                    <td><small>{{ $product->updated_at }}</small></td>

                                    @if ($product->trashed())
                                        <td><small>{{ $product->deleted_at }}</small></td>
                                    @endif

                                    <td class="project-actions">

                                        @if ($product->status == 'pending')
                                            @if (!$product->trashed())
                                                @if (auth()->user()->HasRole('vendor'))
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('vendor-products.edit', ['lang' => app()->getLocale(), 'vendor_product' => $product->id]) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        {{ __('Edit') }}
                                                    </a>

                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('vendor-products.color', ['lang' => app()->getLocale(), 'product' => $product->id]) }}">
                                                        <i class="fas fa-color">
                                                        </i>
                                                        {{ __('Add color') }}
                                                    </a>
                                                @else
                                                    <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        {{ __('Edit') }}
                                                    </a>

                                                    <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                                                        <i class="fas fa-color">
                                                        </i>
                                                        {{ __('Add color') }}
                                                    </a>
                                                @endif
                                            @endif

                                            @if (auth()->user()->HasRole('vendor'))
                                                <form method="POST"
                                                    action="{{ route('vendor-products.destroy', ['lang' => app()->getLocale(), 'vendor_product' => $product->id]) }}"
                                                    enctype="multipart/form-data" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                        @if ($product->trashed())
                                                            {{ __('Delete') }}
                                                        @else
                                                            {{ __('Delete') }}
                                                        @endif
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($product->trashed())
                                                        {{ __('Delete') }}
                                                    @else
                                                        {{ __('Trash') }}
                                                    @endif
                                                </button>
                                            @endif
                                        @endif

                                    </td>
                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $products->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No products To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
