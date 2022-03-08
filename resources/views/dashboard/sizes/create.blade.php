@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Sizes')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Sizes')}}</li>
                <li class="breadcrumb-item active">{{__('Create Sizes')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create Sizes') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(app()->getLocale() . '/dashboard/sizes' )}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="size_ar" class="col-md-2 col-form-label">{{ __('Arabic Size') }}</label>

                            <div class="col-md-10">
                                <input id="size_ar" type="text" class="form-control @error('size_ar') is-invalid @enderror" name="size_ar" value="{{ old('size_ar') }}"  autocomplete="size_ar" autofocus>

                                @error('size_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="size_en" class="col-md-2 col-form-label">{{ __('English Size') }}</label>

                            <div class="col-md-10">
                                <input id="size_en" type="text" class="form-control @error('size_en') is-invalid @enderror" name="size_en" value="{{ old('size_en') }}"  autocomplete="size_en">

                                @error('size_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New Sizes') }}
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
