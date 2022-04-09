@extends('layouts.front.app')

@section('content')



    <div class="container mt-4">
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8 m-2">
                <div class="card" style="margin-top: 80px">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">


                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register', ['lang' => app()->getLocale()]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-10">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                            <label for="type" class="col-md-2 col-form-label text-md-right">{{ __('Account Type') }}</label>

                            <div class="col-md-10">

                                <select class="custom-select type-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" id="type" type="type" @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required>
                                    <option selected>Choose</option>
                                    @php
                                    $types = ['affiliate','seller','employee']
                                    @endphp
                                    @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                  </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}




                            <div class="form-group row">
                                <label for="role"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Permissions') }}</label>

                                <div class="col-md-10">

                                    <select class=" form-control @error('role') is-invalid @enderror"
                                        id="inlineFormCustomSelectPref" id="role" type="role" name="role" required>


                                        <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>
                                            {{ __('affiliate') }}
                                        </option>
                                        <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>
                                            {{ __('Vendor') }}
                                        </option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="country"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Country select') }}</label>
                                <div class="col-md-10">
                                    <select class=" form-control @error('country') is-invalid @enderror" id="country"
                                        name="country" value="{{ old('country') }}" required autocomplete="country">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name_en }}</option>
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
                                <label for="phone"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-10">
                                    <input id="phone" type="txt" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone_hide') . old('phone') }}" required>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row" style="display:none">
                                <label for="phone_hide"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_hide" type="text"
                                        class="form-control @error('phone_hide') is-invalid @enderror" name="phone_hide"
                                        value="{{ old('phone_hide') }}" required>

                                    @error('phone_hide')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-10">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-10">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Gender Select') }}</label>

                                <div class="col-md-10">

                                    <div class="form-check form-check-inline">
                                        <input {{ old('gender') == 'male' ? 'checked' : '' }}
                                            class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                            name="gender" id="inlineRadio1" value="male" required>
                                        <label class="form-check-label" for="inlineRadio1">{{ __('Male') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input {{ old('gender') == 'female' ? 'checked' : '' }}
                                            class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                            name="gender" id="inlineRadio2" value="female" required>
                                        <label class="form-check-label" for="inlineRadio2">{{ __('Female') }}</label>
                                    </div>

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="profile"
                                    class="col-md-2 col-form-label text-md-right">{{ __('Profile Picture') }}</label>

                                <div class="col-md-10">
                                    <input id="profile" type="file"
                                        class="form-control-file img @error('profile') is-invalid @enderror" name="profile"
                                        value="{{ old('profile') }}">

                                    @error('profile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-10">
                                    <img src="{{ asset('storage/images/users/avatarmale.png') }}" style="width:100px"
                                        class="img-thumbnail img-prev">
                                </div>
                            </div>


                            <div class="form-check">
                                <input value="checked" name="check"
                                    class="form-check-input @error('check') is-invalid @enderror" type="checkbox" value=""
                                    id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    <a href="{{ route('front.terms', app()->getLocale()) }}" target="_blank">
                                        {{ __('By registering an account with us, you agree to the Terms of Use and Terms and Conditions of the Coponoo platform') }}
                                    </a>
                                </label>
                                @error('check')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-10 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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
