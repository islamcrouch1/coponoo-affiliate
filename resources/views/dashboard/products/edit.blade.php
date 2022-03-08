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
                        <li class="breadcrumb-item">{{ __('products') }}</li>
                        <li class="breadcrumb-item active">{{ __('Edit products') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Edit products') }}</div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('products.update', ['lang' => app()->getLocale(), 'product' => $Product->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            @if ($Product->stocks->count() > 0)
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>

                                            <th></th>
                                            @if (app()->getLocale() == 'ar')
                                                <th>{{ __('Color') }}</th>
                                            @else
                                                <th>{{ __('Color') }}</th>
                                            @endif
                                            <th>{{ __('Size') }}</th>
                                            <th>{{ __('stock') }}</th>
                                            <th>{{ __('Actions') }}</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($Product->stocks as $stock)
                                            <tr>
                                                <td
                                                    style="width:60px; height:100%; background-color:{{ $stock->color->hex }}; margin-left:10px; border-radius:10px;">

                                                </td>
                                                @if (app()->getLocale() == 'ar')
                                                    <td><small>{{ $stock->color->color_ar }}</small></td>
                                                @else
                                                    <td><small>{{ $stock->color->color_en }}</small></td>
                                                @endif

                                                @if (app()->getLocale() == 'ar')
                                                    <td><small>{{ $stock->size->size_ar }}</small></td>
                                                @else
                                                    <td><small>{{ $stock->size->size_en }}</small></td>
                                                @endif
                                                <td><small>{{ $stock->stock }}</small></td>

                                                <td>
                                                    <a href="{{ route('stock.remove', ['lang' => app()->getLocale(), 'stock' => $stock->id, 'product' => $Product->id]) }}"
                                                        class="btn btn-danger">
                                                        {{ __('Delete') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach




                                    </tbody>
                                </table>
                            @else
                                <h3 class="pl-2">{{ __('No stock to show') }}</h3>
                            @endif


                            <div class="row" style="margin: 30px">
                                <div class="col-md-12">
                                    <a href="{{ route('products.stock.add', ['lang' => app()->getLocale(), 'product' => $Product->id]) }}"
                                        class="btn btn-primary">
                                        {{ __('Edit Stock') }}
                                    </a>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                                <div class="col-md-10">
                                    <input id="name_ar" type="text"
                                        class="form-control @error('name_ar') is-invalid @enderror" name="name_ar"
                                        value="{{ $Product->name_ar }}" autocomplete="name" autofocus>

                                    @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name_en" class="col-md-2 col-form-label">{{ __('English Name') }}</label>

                                <div class="col-md-10">
                                    <input id="name_en" type="text"
                                        class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                                        value="{{ $Product->name_en }}" autocomplete="name" autofocus>

                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="SKU" class="col-md-2 col-form-label">{{ __('SKU') }}</label>

                                <div class="col-md-10">
                                    <input id="SKU" type="text" class="form-control @error('SKU') is-invalid @enderror"
                                        name="SKU" value="{{ $Product->SKU }}" autocomplete="SKU" autofocus>

                                    @error('SKU')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description_ar"
                                    class="col-md-2 col-form-label">{{ __('Arabic Description') }}</label>

                                <div class="col-md-10">
                                    <textarea id="description_ar" type="text"
                                        class="form-control ckeditor @error('description_ar') is-invalid @enderror"
                                        name="description_ar"
                                        autocomplete="description">{{ $Product->description_ar }}</textarea>

                                    @error('description_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description_en"
                                    class="col-md-2 col-form-label">{{ __('English Description') }}</label>

                                <div class="col-md-10">
                                    <textarea id="description_en" type="text"
                                        class="form-control ckeditor @error('description_en') is-invalid @enderror"
                                        name="description_en"
                                        autocomplete="description">{{ $Product->description_en }}</textarea>

                                    @error('description_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vendor_price"
                                    class="col-md-2 col-form-label">{{ __('Vendor price') }}</label>

                                <div class="col-md-10">
                                    <input id="vendor_price" type="double"
                                        class="form-control @error('vendor_price') is-invalid @enderror" name="vendor_price"
                                        value="{{ $Product->vendor_price }}" autocomplete="vendor_price">

                                    @error('vendor_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="limited"
                                    class="col-md-2 col-form-label">{{ __('Unlimited Quntity') }}</label>

                                <div class="col-md-10">
                                    {{-- value="{{ old('limited') }}" --}}
                                    <label class="switch">
                                        <input id="limited" class="form-control @error('limited') is-invalid @enderror"
                                            name="limited" type="checkbox"
                                            {{ $Product->limits()->where('product_id', $Product->id)->get()->count() != 0? 'checked': '' }}>
                                        <span class="slider round"></span>
                                    </label>

                                    @error('limited')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fixed_price" class="col-md-2 col-form-label">{{ __('Fixed Price') }}</label>

                                <div class="col-md-10">
                                    <input id="fixed_price" type="double"
                                        class="form-control @error('fixed_price') is-invalid @enderror" name="fixed_price"
                                        value="{{ $Product->fixed_price }}" min="0" autocomplete="fixed_price">

                                    @error('fixed_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                            <label for="min_price" class="col-md-2 col-form-label">{{ __('Min price') }}</label>

                            <div class="col-md-10">
                                <input id="min_price" type="double" class="form-control @error('min_price') is-invalid @enderror" name="min_price" value="{{ $Product->min_price }}"  autocomplete="min_price">

                                @error('min_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="max_price" class="col-md-2 col-form-label">{{ __('Max price') }}</label>

                            <div class="col-md-10">
                                <input id="max_price" type="double" class="form-control @error('max_price') is-invalid @enderror" name="max_price" value="{{ $Product->max_price }}"  autocomplete="max_price">

                                @error('max_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}


                            {{-- <div class="form-group row">
                            <label for="stock" class="col-md-2 col-form-label">{{ __('stock') }}</label>

                            <div class="col-md-10">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $Product->stock }}"  autocomplete="stock">

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}



                            <div class="form-group row">
                                <label for="images" class="col-md-2 col-form-label">{{ __('Add images') }}</label>

                                <div class="col-md-10">
                                    <input id="images" accept="image/*" type="file"
                                        class="form-control-file img1 @error('images') is-invalid @enderror"
                                        accept="image/*" name="images[]" value="{{ old('images') }}" multiple>

                                    @error('images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 m-2" id="gallery">

                                @foreach ($Product->images as $image)
                                    <img src="{{ asset('storage/images/products/' . $image->url) }}" style="width:100px"
                                        class="img-thumbnail img-prev">
                                @endforeach

                            </div>


                            <div class="form-group row">
                                <label for="category_id"
                                    class="col-md-2 col-form-label">{{ __('Category select') }}</label>
                                <div class="col-md-10">
                                    <select class="form-control select4 @error('category_id') is-invalid @enderror"
                                        id="category_id" multiple="multiple" name="categories[]" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $Product->categories()->where('category_id', $category->id)->first()? 'selected': '' }}>
                                                {{ app()->getLocale() == 'ar'? $category->name_ar . ' - ' . $category->country->name_ar: $category->name_en . ' - ' . $category->country->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="status"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Product Status') }}</label>

                                <div class="col-md-10">

                                    <select class=" form-control @error('status') is-invalid @enderror" id="status"
                                        type="status" name="status" required>
                                        <option value="pending" {{ $Product->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('pending') }}</option>
                                        <option value="active" {{ $Product->status == 'active' ? 'selected' : '' }}>
                                            {{ __('active') }}</option>
                                        <option value="rejected" {{ $Product->status == 'rejected' ? 'selected' : '' }}>
                                            {{ __('rejected') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit Product') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection
