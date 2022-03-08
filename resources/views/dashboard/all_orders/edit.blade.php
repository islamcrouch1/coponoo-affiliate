@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Products</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">Products</li>
                <li class="breadcrumb-item active">Edit Products</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Products') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('products.update' , ['lang'=>app()->getLocale() , 'product'=>$Product->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                            <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{$Product->name_ar}}"  autocomplete="name" autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{$Product->name_en}}"  autocomplete="name" autofocus>

                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description_ar" class="col-md-2 col-form-label">{{ __('Arabic Description') }}</label>

                            <div class="col-md-10">
                                <input id="description_ar" type="text" class="form-control @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ $Product->description_ar }}"  autocomplete="description">

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
                                <input id="description_en" type="text" class="form-control @error('description_en') is-invalid @enderror" name="description_en" value="{{ $Product->description_ar }}"  autocomplete="description">

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="purchase_price" class="col-md-2 col-form-label">{{ __('purchase price') }}</label>

                            <div class="col-md-10">
                                <input id="purchase_price" type="number" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" value="{{ $Product->purchase_price }}"  autocomplete="purchase_price">

                                @error('purchase_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sale_price" class="col-md-2 col-form-label">{{ __('sale price') }}</label>

                            <div class="col-md-10">
                                <input id="sale_price" type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{ $Product->sale_price }}"  autocomplete="sale_price">

                                @error('sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="stock" class="col-md-2 col-form-label">{{ __('stock') }}</label>

                            <div class="col-md-10">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $Product->stock }}"  autocomplete="stock">

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <div class="col-md-10 pt-4">
                                <input id="image" type="file" class="form-control-file img @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-10">
                                <img src="{{ asset('storage/images/Products/' . $Product->image) }}" style="width:100px"  class="img-thumbnail img-prev">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="ed_class" class="col-md-2 col-form-label">{{ __('Category select') }}</label>
                            <div class="col-md-10">
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" value="{{ old('category_id') }}" required autocomplete="category_id">                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{$Product->category->id == $category->id ? 'selected' : ''}}>{{ $category->name_en }}</option>
                                @endforeach
                                </select>
                                @error('ed_class')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="type" class="col-md-2 col-form-label">{{ __('product type Select') }}</label>

                            <div class="col-md-10">

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input radio1 @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio1" value="downloaded_product" {{$Product->type == 'downloaded_product' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="inlineRadio1">{{ __('downloaded product') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input radio2 @error('type') is-invalid @enderror" type="radio" name="type" id="inlineRadio2" value="physical_product" {{$Product->type == 'physical_product' ? 'checked' : ''}}>
                                    <label class="form-check-label" for="inlineRadio2">{{ __('physical product') }}</label>
                                </div>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if ($Product->type == 'downloaded_product' )

                        <div class="form-group row down_link">
                            <label for="down_link" class="col-md-2 col-form-label">{{ __('product download') }}</label>

                            <div class="col-md-10">
                                <a href="{{ asset('storage/products/files/' . $Product->down_link) }}">Download</a>
                            </div>
                        </div>



                        <div class="form-group row down_link">
                            <label for="down_link" class="col-md-2 col-form-label">{{ __('Upload your product') }}</label>

                            <div class="col-md-10">
                                <input id="down_link" type="file" class="form-control-file @error('down_link') is-invalid @enderror" name="down_link" value="{{ old('down_link') }}">

                                @error('down_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @else
                        <div class="form-group row down_link"  style="display:none;">
                            <label for="down_link" class="col-md-2 col-form-label">{{ __('Upload your product') }}</label>

                            <div class="col-md-10">
                                <input id="down_link" type="file" class="form-control-file @error('down_link') is-invalid @enderror" name="down_link" value="{{ old('down_link') }}">

                                @error('down_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif










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
