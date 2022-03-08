@extends('layouts.dashboard.app')

@section('adminContent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Settings') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('Settings') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Settings') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.store', app()->getLocale()) }}">
                            @csrf





                            <div class="form-group row">
                                <label for="tax" class="col-md-2 col-form-label">{{ __('Sales Tax') }}</label>

                                <div class="col-md-10">
                                    <input id="tax" type="text" class="form-control @error('tax') is-invalid @enderror"
                                        value="{{ setting('tax') }}" name="tax" autocomplete="description">

                                    @error('tax')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mandatory"
                                    class="col-md-2 col-form-label">{{ __('Mandatory Period For Affiliate') . __(' - in minutes') }}</label>

                                <div class="col-md-10">
                                    <input id="mandatory" type="text"
                                        class="form-control @error('mandatory') is-invalid @enderror"
                                        value="{{ setting('mandatory') }}" name="mandatory" autocomplete="mandatory">

                                    @error('mandatory')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mandatory_vendor"
                                    class="col-md-2 col-form-label">{{ __('Mandatory Period For Vendors') . __(' - in minutes') }}</label>

                                <div class="col-md-10">
                                    <input id="mandatory_vendor" type="text"
                                        class="form-control @error('mandatory_vendor') is-invalid @enderror"
                                        value="{{ setting('mandatory_vendor') }}" name="mandatory_vendor"
                                        autocomplete="mandatory_vendor">

                                    @error('mandatory_vendor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="max_price" class="col-md-2 col-form-label">{{ __('max price %') }}</label>

                                <div class="col-md-10">
                                    <input id="max_price" type="text"
                                        class="form-control @error('max_price') is-invalid @enderror"
                                        value="{{ setting('max_price') }}" name="max_price" autocomplete="description">

                                    @error('max_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="commission"
                                    class="col-md-2 col-form-label">{{ __('Suggested commission %') }}</label>

                                <div class="col-md-10">
                                    <input id="commission" type="text"
                                        class="form-control @error('commission') is-invalid @enderror"
                                        value="{{ setting('commission') }}" name="commission" autocomplete="description">

                                    @error('commission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            @php
                                $social_sites = ['facebook', 'youtube', 'instagram', 'twitter', 'snapchat', 'whatsapp'];
                            @endphp

                            @foreach ($social_sites as $social_site)
                                <div class="form-group row">
                                    <label for="{{ $social_site }}"
                                        class="col-md-2 col-form-label">{{ $social_site . ' ' . __('link') }}</label>

                                    <div class="col-md-10">
                                        <input id="{{ $social_site }}" type="text" class="form-control"
                                            name="{{ $social_site }}_link"
                                            value="{{ setting($social_site . '_link') }}" autofocus>
                                    </div>

                                </div>
                            @endforeach


                            <div class="form-group row">
                                <label for="terms_ar"
                                    class="col-md-2 col-form-label">{{ __('Arabic Terms And Conditions') }}</label>

                                <div class="col-md-10">
                                    <textarea id="terms_ar" type="text"
                                        class="form-control ckeditor @error('terms_ar') is-invalid @enderror"
                                        name="terms_ar" autocomplete="description">{{ setting('terms_ar') }}</textarea>

                                    @error('terms_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="terms_en"
                                    class="col-md-2 col-form-label">{{ __('Arabic Terms And Conditions') }}</label>

                                <div class="col-md-10">
                                    <textarea id="terms_en" type="text"
                                        class="form-control ckeditor @error('terms_en') is-invalid @enderror"
                                        name="terms_en" autocomplete="description">{{ setting('terms_en') }}</textarea>

                                    @error('terms_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="modal_1"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Popup for front') }}</label>

                                <div class="col-md-10">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_1') is-invalid @enderror" type="radio"
                                            name="modal_1" {{ setting('modal_1') == 'on' ? 'checked' : '' }}
                                            id="inlineRadio1" value="on">
                                        <label class="form-check-label" for="inlineRadio1">{{ __('On') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_1') is-invalid @enderror" type="radio"
                                            name="modal_1" {{ setting('modal_1') == 'off' ? 'checked' : '' }}
                                            id="inlineRadio2" value="off">
                                        <label class="form-check-label" for="inlineRadio2">{{ __('Off') }}</label>
                                    </div>

                                    @error('modal_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="modal_1_title"
                                    class="col-md-2 col-form-label">{{ __('Title for fornt popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_1_title" type="text"
                                        class="form-control @error('modal_1_title') is-invalid @enderror"
                                        value="{{ setting('modal_1_title') }}" name="modal_1_title"
                                        autocomplete="modal_1_title">

                                    @error('modal_1_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="modal_1_body"
                                    class="col-md-2 col-form-label">{{ __('Body for fornt popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_1_body" type="text"
                                        class="form-control @error('modal_1_body') is-invalid @enderror"
                                        value="{{ setting('modal_1_body') }}" name="modal_1_body"
                                        autocomplete="modal_1_body">

                                    @error('modal_1_body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>






                            <div class="form-group row">
                                <label for="modal_2"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Popup for vendors') }}</label>

                                <div class="col-md-10">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_2') is-invalid @enderror" type="radio"
                                            name="modal_2" {{ setting('modal_2') == 'on' ? 'checked' : '' }}
                                            id="inlineRadio1" value="on">
                                        <label class="form-check-label" for="inlineRadio1">{{ __('On') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_2') is-invalid @enderror" type="radio"
                                            name="modal_2" {{ setting('modal_2') == 'off' ? 'checked' : '' }}
                                            id="inlineRadio2" value="off">
                                        <label class="form-check-label" for="inlineRadio2">{{ __('Off') }}</label>
                                    </div>

                                    @error('modal_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="modal_2_title"
                                    class="col-md-2 col-form-label">{{ __('Title for vendor popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_2_title" type="text"
                                        class="form-control @error('modal_2_title') is-invalid @enderror"
                                        value="{{ setting('modal_2_title') }}" name="modal_2_title"
                                        autocomplete="modal_2_title">

                                    @error('modal_2_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="modal_2_body"
                                    class="col-md-2 col-form-label">{{ __('Body for vendor popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_2_body" type="text"
                                        class="form-control @error('modal_2_body') is-invalid @enderror"
                                        value="{{ setting('modal_2_body') }}" name="modal_2_body"
                                        autocomplete="modal_2_body">

                                    @error('modal_2_body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>








                            <div class="form-group row">
                                <label for="modal_3"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Popup for affiliate') }}</label>

                                <div class="col-md-10">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_3') is-invalid @enderror" type="radio"
                                            name="modal_3" {{ setting('modal_3') == 'on' ? 'checked' : '' }}
                                            id="inlineRadio1" value="on">
                                        <label class="form-check-label" for="inlineRadio1">{{ __('On') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('modal_3') is-invalid @enderror"
                                            type="radio" name="modal_3"
                                            {{ setting('modal_3') == 'off' ? 'checked' : '' }} id="inlineRadio2"
                                            value="off">
                                        <label class="form-check-label" for="inlineRadio2">{{ __('Off') }}</label>
                                    </div>

                                    @error('modal_3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="modal_3_title"
                                    class="col-md-2 col-form-label">{{ __('Title for affiliate popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_3_title" type="text"
                                        class="form-control @error('modal_3_title') is-invalid @enderror"
                                        value="{{ setting('modal_3_title') }}" name="modal_3_title"
                                        autocomplete="modal_3_title">

                                    @error('modal_3_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="modal_3_body"
                                    class="col-md-2 col-form-label">{{ __('Body for affiliate popup') }}</label>

                                <div class="col-md-10">
                                    <input id="modal_3_body" type="text"
                                        class="form-control @error('modal_3_body') is-invalid @enderror"
                                        value="{{ setting('modal_3_body') }}" name="modal_3_body"
                                        autocomplete="modal_3_body">

                                    @error('modal_3_body')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>





                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
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
