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
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Sizes')}}</li>
                <li class="breadcrumb-item active">{{__('Edit Sizes')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Sizes') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('sizes.update' , ['lang'=>app()->getLocale() , 'size'=>$size->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="form-group row">
                            <label for="size_ar" class="col-md-2 col-form-label">{{ __('Arabic Size') }}</label>

                            <div class="col-md-10">
                                <input id="size_ar" type="text" class="form-control @error('size_ar') is-invalid @enderror" name="size_ar" value="{{ $size->size_ar }}"  autocomplete="size_ar" autofocus>

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
                                <input id="size_en" type="text" class="form-control @error('size_en') is-invalid @enderror" name="size_en" value="{{ $size->size }}"  autocomplete="size_en">

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
                                    {{ __('Edit Size') }}
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
