@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('products')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('products')}}</li>
                <li class="breadcrumb-item active">{{__('Add New products')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('Add New products')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(app()->getLocale() . '/dashboard/vendor-products' )}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ old('name_ar') }}"  autocomplete="name" required autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}"  autocomplete="name" required autofocus>

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
                                <input id="SKU" type="text" class="form-control @error('SKU') is-invalid @enderror" name="SKU" value="{{ old('SKU') }}"  autocomplete="SKU" autofocus>

                                @error('SKU')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description_ar" class="col-md-2 col-form-label">{{ __('Arabic Description') }}</label>

                            <div class="col-md-10">
                                <textarea id="description_ar" type="text" class="form-control ckeditor @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ old('description_ar') }}" required  autocomplete="description">{{ old('description_ar') }}</textarea>

                                @error('description_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description_en" class="col-md-2 col-form-label">{{ __('English Description') }}</label>

                            <div class="col-md-10">
                                <textarea id="description_en" type="text" class="form-control ckeditor @error('description_en') is-invalid @enderror" name="description_en" value="{{ old('description_en') }}" required  autocomplete="description">{{ old('description_en') }}</textarea>

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vendor_price" class="col-md-2 col-form-label">{{ __('Vendor price') }}</label>

                            <div class="col-md-10">
                                <input id="vendor_price" type="double" class="form-control @error('vendor_price') is-invalid @enderror" name="vendor_price" value="{{ old('vendor_price') }}" required  autocomplete="vendor_price">

                                @error('vendor_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>






                        {{-- <div class="form-group row">
                            <label for="stock" class="col-md-2 col-form-label">{{ __('stock') }}</label>

                            <div class="col-md-10">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}"  autocomplete="stock">

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
                                <input id="images" type="file" class="form-control-file img1 @error('images') is-invalid @enderror" accept="image/*" name="images[]" value="{{ old('images') }}" required multiple>

                                @error('images')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                        <div class="col-md-12" id="gallery">


                        </div>


                        <div class="form-group row">
                            <label for="category_id" class="col-md-2 col-form-label">{{ __('category select') }}</label>
                            <div class="col-md-10">
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" value="{{ old('category_id') }}" required autocomplete="category_id">
                                @foreach ($categories as $category)
                                @if ($category->parent == 'null')
                                 <option value="{{ $category->id }}" >{{app()->getLocale() == 'ar' ? $category->name_ar . ' - ' . $category->country->name_ar : $category->name_en . ' - ' . $category->country->name_en}}</option>
                                  @php
                                      $cats = \App\Category::where('parent' , $category->id)->get();
                                  @endphp
                                  @foreach ($cats as $cat)
                                  <option value="{{ $cat->id }}" > -- {{app()->getLocale() == 'ar' ? $cat->name_ar . ' - ' . $cat->country->name_ar : $cat->name_en . ' - ' . $cat->country->name_en}}</option>
                                    @php
                                    $cats = \App\Category::where('parent' , $cat->id)->get();
                                    @endphp
                                    @if ($cats->count() > 0)
                                        @foreach ($cats as $cat)
                                        <option value="{{ $cat->id }}" > ---- {{app()->getLocale() == 'ar' ? $cat->name_ar . ' - ' . $cat->country->name_ar : $cat->name_en . ' - ' . $cat->country->name_en}}</option>
                                        @php
                                        $cats = \App\Category::where('parent' , $cat->id)->get();
                                        @endphp
                                        @if ($cats->count() > 0)
                                            @foreach ($cats as $cat)
                                            <option value="{{ $cat->id }}" > ------ {{app()->getLocale() == 'ar' ? $cat->name_ar . ' - ' . $cat->country->name_ar : $cat->name_en . ' - ' . $cat->country->name_en}}</option>
                                            @endforeach
                                        @endif
                                        @endforeach
                                    @endif
                                  @endforeach
                                @endif
                                @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="colors" class="col-md-2 col-form-label text-md-right">{{ __('Select Colors') }}</label>

                            <div class="col-md-10">

                                <select name="colors[]" class="form-control select4  @error('colors') is-invalid @enderror" multiple="multiple" style="width:100% !important" required>
                                    @foreach ($colors as $color)
                                    <option style="background-color:{{$color->hex}}" value="{{$color->id}}">
                                            <div style="height: 50px" class="col-md-8">{{ app()->getLocale() == 'ar' ? $color->color_ar : $color->color_en}}</div>
                                    </option>
                                    @endforeach
                                </select>
                                @error('colors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sizes" class="col-md-2 col-form-label text-md-right">{{ __('Select Sizes') }}</label>

                            <div class="col-md-10">

                                <select name="sizes[]" class="form-control select4  @error('sizes') is-invalid @enderror" multiple="multiple" style="width:100% !important" required>
                                    @foreach ($sizes as $size)
                                    <option value="{{$size->id}}">{{ app()->getLocale() == 'ar' ? $size->size_ar : $size->size_en}}</option>
                                    @endforeach
                                </select>
                                @error('sizes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label text-md-right">{{ __('Product Status') }}</label>

                            <div class="col-md-10">

                                <select class=" form-control @error('status') is-invalid @enderror" id="status" type="status" name="status" value="{{ old('status') }}" required>
                                    <option value="pending">{{__('pending')}}</option>
                                    <option value="active">{{__('active')}}</option>
                                    <option value="rejected">{{__('rejected')}}</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New product') }}
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
