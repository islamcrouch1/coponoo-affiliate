@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>categories</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">categories</li>
                <li class="breadcrumb-item active">Add New categories</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add categories') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('categories.store' , ['parent_cat' => request()->parent , 'lang' => app()->getLocale()])}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name_ar" class="col-md-2 col-form-label">{{ __('Arabic Name') }}</label>

                            <div class="col-md-10">
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ old('name_ar') }}"  autocomplete="name" autofocus>

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
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}"  autocomplete="name" autofocus>

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
                                <input id="description_ar" type="text" class="form-control @error('description_ar') is-invalid @enderror" name="description_ar" value="{{ old('description_ar') }}"  autocomplete="description">

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
                                <input id="description_en" type="text" class="form-control @error('description_en') is-invalid @enderror" name="description_en" value="{{ old('description_en') }}"  autocomplete="description">

                                @error('description_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="parent" class="col-md-2 col-form-label">{{ __('Parent Category') }}</label>
                            <div class="col-md-10">
                                <select style="height: 50px;" class="form-control @error('parent') is-invalid @enderror" name="parent" value="{{ old('parent') }}">
                                    <option value="null" {{request()->parent == 'null' ? 'selected' : ''}}>{{__('Main Category')}}</option>

                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{request()->parent == $category->id ? 'selected' : ''}}>{{app()->getLocale() == 'ar' ? $category->name_ar . ' - ' . $category->country->name_ar : $category->name_en . ' - ' . $category->country->name_en}}</option>
                                    @endforeach

                                </select>
                                @error('parent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="country" class="col-md-2 col-form-label">{{ __('Country select') }}</label>
                            <div class="col-md-10">
                                <select class=" form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}" required autocomplete="country">
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" >{{ $country->name_en }}</option>
                                @endforeach
                                </select>
                                @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="profit" class="col-md-2 col-form-label">{{ __('Profit Rate %') }}</label>

                            <div class="col-md-10">
                                <input id="profit" type="double" class="form-control @error('profit') is-invalid @enderror" name="profit" value="{{ old('profit') }}"  autocomplete="profit" required>

                                @error('profit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('image') }}</label>

                            <div class="col-md-10">
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
                                <img src="" style="width:100px"  class="img-thumbnail img-prev">
                            </div>
                        </div>






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New Category') }}
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
