@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Add color')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('products')}}</li>
                <li class="breadcrumb-item active">{{__('Add color')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('Add color')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('products.store_color' , ['lang'=>app()->getLocale() , 'product'=>$Product->id])}}" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group row">
                            <label for="color" class="col-md-2 col-form-label text-md-right">{{ __('Select Color') }}</label>
                            <div class="col-md-10">
                                <select class=" form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color') }}" required autocomplete="color">
                                @foreach ($colors as $color)
                                <option value="{{ $color->id }}" >{{ app()->getLocale() == 'ar' ? $color->color_ar : $color->color_en }}</option>
                                @endforeach
                                </select>
                                @error('color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="size" class="col-md-2 col-form-label text-md-right">{{ __('Select Size') }}</label>
                            <div class="col-md-10">
                                <select class=" form-control @error('size') is-invalid @enderror" id="size" name="size" value="{{ old('size') }}" required autocomplete="size">
                                @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" >{{ app()->getLocale() == 'ar' ? $size->size_ar : $size->size_en }}</option>
                                @endforeach
                                </select>
                                @error('size')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="stock" class="col-md-2 col-form-label">{{ __('Stock') }}</label>

                            <div class="col-md-10">
                                <input id="stock" type="double" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock') }}"  autocomplete="stock">

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add color') }}
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
