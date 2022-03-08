@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Colors')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Colors')}}</li>
                <li class="breadcrumb-item active">{{__('Create color')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create color') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(app()->getLocale() . '/dashboard/colors' )}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="color_ar" class="col-md-2 col-form-label">{{ __('Color Arabic Name') }}</label>

                            <div class="col-md-10">
                                <input id="color_ar" type="text" class="form-control @error('color_ar') is-invalid @enderror" name="color_ar" value="{{ old('color_ar') }}"  autocomplete="name" autofocus>

                                @error('color_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="color_en" class="col-md-2 col-form-label">{{ __('Color English Name') }}</label>

                            <div class="col-md-10">
                                <input id="color_en" type="text" class="form-control @error('color_en') is-invalid @enderror" name="color_en" value="{{ old('color_en')  }}"  autocomplete="name" autofocus>

                                @error('color_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="hex" class="col-md-2 col-form-label">{{ __('Color') }}</label>

                            <div class="col-md-5 input-group colorpicker colorpicker-component">
                                <input id="hex" type="text" class="form-control @error('hex') is-invalid @enderror" name="hex" value="#ffffff" style="width: 50%;"  autocomplete="color" autofocus>

                                <span class="input-group-addon"><i style="width:150px; height:90%; margin-right:10px; border-radius:10px; border:1px solid #ced4da"></i></span>

                                @error('hex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>









                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New color') }}
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
