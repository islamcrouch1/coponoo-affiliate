@extends('layouts.dashboard.app')

@section('adminContent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Shopping Cart') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Shopping Cart') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <div class="row">
        <div class="col-12">

            <div class="card m-2">
                <div class="card-header">
                    <h3 style="{{ app()->getLocale() == 'ar' ? 'float:right' : 'float:left' }}" class="card-title">
                        {{ __('Shopping Cart') }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Product image') }}</th>
                                <th>{{ __('Product name') }}</th>
                                <th>{{ __('Color') }}</th>
                                <th>{{ __('Size') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Item price') }}</th>
                                <th>{{ __('Total Price') }}</th>
                                <th>{{ __('Commission') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->cart->products as $product)
                                <tr>
                                    <td><img style="width:50px"
                                            src="{{ asset('storage/images/products/' . $product->images[0]->url) }}"
                                            class="img-responsive rounded-circle" alt="Product Image"></td>
                                    <td>{{ app()->getLocale() == 'ar' ? $product->name_ar : $product->name_en }}
                                        @if ($product->pivot->product_type)
                                            <span class="badge badge-danger badge-lg">{{ __('My stock') }}</span>
                                        @endif
                                    </td>
                                    @if ($product->pivot->product_type == '0')
                                        <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->color->color_ar: $product->stocks->find($product->pivot->stock_id)->color->color_en }}
                                        </td>
                                        <td>{{ app()->getLocale() == 'ar'? $product->stocks->find($product->pivot->stock_id)->size->size_ar: $product->stocks->find($product->pivot->stock_id)->size->size_en }}
                                        </td>
                                    @else
                                        <td>{{ app()->getLocale() == 'ar'? $product->astocks->find($product->pivot->stock_id)->color->color_ar: $product->astocks->find($product->pivot->stock_id)->color->color_en }}
                                        </td>
                                        <td>{{ app()->getLocale() == 'ar'? $product->astocks->find($product->pivot->stock_id)->size->size_ar: $product->astocks->find($product->pivot->stock_id)->size->size_en }}
                                        </td>
                                    @endif
                                    <td>{{ $product->pivot->stock }}</td>
                                    <td>{{ $product->pivot->price }}</td>
                                    <td>{{ $product->pivot->price * $product->pivot->stock }}</td>
                                    <td>{{ ($product->pivot->price - $product->min_price) * $product->pivot->stock }}
                                    </td>
                                    <td><a class="btn btn-sm btn-danger"
                                            href="{{ route('cart.remove', ['lang' => app()->getLocale(),'user' => $user->id,'product' => $product->id,'stock' => $product->pivot->stock_id]) }}">{{ __('Delete') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
    </div>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Add Order Infomation') }}</div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('orders.affiliate', ['lang' => app()->getLocale(), 'user' => $user->id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">{{ __('Client Name') . ' *' }}</label>

                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-2 col-form-label">{{ __('Address') . ' *' }}</label>

                                <div class="col-md-10">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}" autocomplete="name" autofocus>

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="house" class="col-md-2 col-form-label">{{ __('House No') }}</label>

                                <div class="col-md-10">
                                    <input id="house" type="text" class="form-control @error('house') is-invalid @enderror"
                                        name="house" value="{{ old('house') }}" autocomplete="name">

                                    @error('house')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="special_mark"
                                    class="col-md-2 col-form-label">{{ __('Special Mark') }}</label>

                                <div class="col-md-10">
                                    <input id="special_mark" type="text"
                                        class="form-control @error('special_mark') is-invalid @enderror" name="special_mark"
                                        value="{{ old('special_mark') }}" autocomplete="special_mark">

                                    @error('special_mark')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="shipping"
                                    class="col-md-2 col-form-label">{{ __('Shipping to') . ' *' }}</label>

                                <div class="col-md-10">
                                    <select class=" form-control @error('shipping') is-invalid @enderror" id="shipping"
                                        name="shipping" value="{{ old('shipping') }}" required autocomplete="shipping">
                                        @foreach ($rates as $rate)
                                            <option value="{{ $rate->id }}">
                                                {{ app()->getLocale() == 'ar' ? $rate->city_ar : $rate->city_en }}
                                                {{ ' - ' . $rate->cost . ' ' . $rate->country->currency }}</option>
                                        @endforeach
                                    </select>
                                    @error('shipping')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="phone1" class="col-md-2 col-form-label">{{ __('Phone') . ' *' }}</label>

                                <div class="col-md-10">
                                    <input id="phone1" type="text"
                                        class="form-control @error('phone1') is-invalid @enderror" name="phone1"
                                        value="{{ old('phone1') }}" autocomplete="description">

                                    @error('phone1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="phone2" class="col-md-2 col-form-label">{{ __('Alternate Phone') }}</label>

                                <div class="col-md-10">
                                    <input id="phone2" type="text"
                                        class="form-control @error('phone2') is-invalid @enderror" name="phone2"
                                        value="{{ old('phone2') }}" autocomplete="description">

                                    @error('phone2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>






                            <div class="form-group row">
                                <label for="notes" class="col-md-2 col-form-label">{{ __('notes') }}</label>

                                <div class="col-md-10">
                                    <textarea id="notes" type="text" class="form-control @error('notes') is-invalid @enderror" name="notes"
                                        value="{{ old('notes') }}" autocomplete="notes"></textarea>

                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>







                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add New Order') }}
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
