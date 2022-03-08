@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Slides')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Slides')}}</li>
                <li class="breadcrumb-item active">{{__('Edit Slide')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Slide') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('slides.update' , ['lang'=>app()->getLocale() , 'slide'=>$slide->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="form-group row">
                            <label for="slide_id" class="col-md-2 col-form-label">{{ __('Slide ID') }}</label>

                            <div class="col-md-10">
                                <input id="slide_id" type="text" class="form-control @error('slide_id') is-invalid @enderror" name="slide_id" value="{{ $slide->slide_id }}"  autocomplete="slide_id">

                                @error('slide_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="url" class="col-md-2 col-form-label">{{ __('URL') }}</label>

                            <div class="col-md-10">
                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $slide->url }}"  autocomplete="url">

                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ __('slide Flag') }}</label>
                            <img class="img-thumbnail" style="width:50%" src="{{ asset('storage/' . $slide->image) }}">

                            <div class="col-md-10">
                                <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" value="{{ $slide->image }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit Slide') }}
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
