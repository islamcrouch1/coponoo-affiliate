@extends('layouts.dashboard.app')

@section('adminContent')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('Shipping Rates')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                <li class="breadcrumb-item"><a href="#">{{__('Home')}}</a></li>
                <li class="breadcrumb-item">{{__('Shipping Rates')}}</li>
                <li class="breadcrumb-item active">{{__('Create shipping rate')}}</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>


<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create shipping rate') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(app()->getLocale() . '/dashboard/shipping_rates' )}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="city_ar" class="col-md-2 col-form-label">{{ __('City Arabic Name') }}</label>

                            <div class="col-md-10">
                                <input id="city_ar" type="text" class="form-control @error('city_ar') is-invalid @enderror" name="city_ar" value="{{ old('city_ar') }}"  autocomplete="name" autofocus>

                                @error('city_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city_en" class="col-md-2 col-form-label">{{ __('City English Name') }}</label>

                            <div class="col-md-10">
                                <input id="city_en" type="text" class="form-control @error('city_en') is-invalid @enderror" name="city_en" value="{{ old('city_en')  }}"  autocomplete="name" autofocus>

                                @error('city_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="cost" class="col-md-2 col-form-label">{{ __('Shipping Rate') }}</label>

                            <div class="col-md-10">
                                <input id="cost" type="text" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ old('cost') }}"  autocomplete="name" autofocus>

                                @error('cost')
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




                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add New shipping rate') }}
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
