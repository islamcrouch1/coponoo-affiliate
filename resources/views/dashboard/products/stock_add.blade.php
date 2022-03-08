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
                <div class="card-header">{{__('Add Stock') . ' - ' . $product->name_ar}}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('products.stock.store' , ['lang'=>app()->getLocale() , 'product'=>$product->id])}}" enctype="multipart/form-data">
                        @csrf


                        <table class="table table-striped projects">
                            <thead>
                                <tr>

                                      <th>{{__('Color')}}</th>
                                      <th>{{ __('Size') }}</th>
                                      <th>{{ __('Stock') }}</th>

                                </tr>
                              </thead>

                              <tbody>

                                <tr>

                                  @foreach ($product->stocks as $stock)

                                  @if (app()->getLocale() == 'ar')
                                  <td>{{ $stock->color->color_ar }}</td>
                                  @else
                                  <td>{{ $stock->color->color_en }}</td>
                                  @endif


                                  @if (app()->getLocale() == 'ar')
                                  <td>{{ $stock->size->size_ar }}</td>
                                  @else
                                  <td>{{ $stock->size->size_en }}</td>
                                  @endif



                                  <td>


                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input id="stock" type="double" class="form-control @error('stock') is-invalid @enderror" name="stock[]" value="{{ $stock->stock }}" required  autocomplete="stock">

                                            @error('stock')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                  </td>



                              </tr>
                                    @endforeach


                            </tbody>
                        </table>



                        @foreach ($product->stocks as $stock)

                        @php
                            $stocks = $product->stocks->unique('color_id');
                        @endphp

                        @endforeach


                        <div class="col-md-12">
                            <h5>{{__('Add photos by color')}}</h5>
                            <br>
                        </div>

                        @foreach ($stocks as $stock)


                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label">{{ app()->getLocale() == 'ar' ? $stock->color->color_ar : $stock->color->color_en }}</label>

                            <div class="col-md-10">
                                <input id="image" type="file" class="form-control-file img @error('image') is-invalid @enderror" name="image[{{$stock->id}}][]" value="{{ old('image') }}">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <br>

                        @if ($stock->image != Null)
                        <div class="form-group row">

                            <div class="col-md-10">
                                <img src="{{ asset('storage/images/products/' . $stock->image) }}" style="width:100px"  class="img-thumbnail">
                            </div>
                        </div>
                        @endif




                        @endforeach






                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Stock') }}
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
