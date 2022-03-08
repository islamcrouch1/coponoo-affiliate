@extends('layouts.dashboard.app')

@section('adminContent')






   <!-- Main content -->
   <section class="content">

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    {{__('Messages')}}
                </div>
                <ul class="list-group list-group-flush">
                    @if($user->messages->count() > 0)
                    @foreach ($user->messages as $message)
                    <li class="list-group-item">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="image">
                                    <a href="#">
                                        <img src="{{ asset('storage/images/users/' . $message->profile) }}" class="img-circle elevation-2" alt="User Image" style="width:20%; margin:5px">
                                    </a>
                                    @php
                                    $date =  Carbon\Carbon::now();
                                    $interval = $message->created_at->diffForHumans($date );
                                    @endphp
                                    <span style="direction: ltr !important" class="badge badge-success">{{$interval}}</span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <p style="padding-top: 18px">
                                    {{$message->message}}
                                </p>
                            </div>
                        </div>
                        </li>

                    @endforeach
                    @else
                    <li class="list-group-item">
                        {{__('There are no messages at the moment')}}
                    </li>
                    @endif


                    <li class="list-group-item">
                        <form method="POST" action="{{ route('messages.send' , ['lang'=> app()->getLocale() , 'user'=> $user->id]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="message" class="col-md-2 col-form-label text-md-right">{{ __('Message') }}</label>

                                <div class="col-md-10">
                                    <input id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" required autocomplete="message" autofocus>

                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-10 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>

                </ul>
            </div>
        </div>

    </section>


  @endsection
