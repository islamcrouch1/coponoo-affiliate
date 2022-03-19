@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Notifications') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Notifications') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box - -->

        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" autofocus placeholder="{{ __('Search..') }}"
                                    class="form-control" value="{{ request()->search }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-search mr-1"></i>{{ __('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Notifications') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                @if ($notifications->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('image') }}
                                </th>
                                <th>
                                    {{ __('Notification Title') }}
                                </th>
                                <th>
                                    {{ __('Notifications Body') }}
                                </th>
                                <th>

                                    {{ __('Created At') }}
                                </th>

                                <th>

                                    {{ __('Actions') }}
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($notifications->reverse() as $notification)
                                    <td>

                                        @if (Auth::user()->HasRole('vendor') || Auth::user()->HasRole('affiliate'))
                                            <img alt="Avatar" class="table-avatar"
                                                src="{{ asset('storage/images/icon.png') }}">
                                        @else
                                            <img alt="Avatar" class="table-avatar"
                                                src="{{ $notification->user_image }}">
                                        @endif


                                    </td>
                                    <td>
                                        <small>
                                            {{ app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ app()->getLocale() == 'ar' ? $notification->body_ar : $notification->body_en }}
                                        </small>
                                    </td>
                                    <td>

                                        @php
                                            $date = Carbon\Carbon::now();
                                            $interval = $notification->created_at->diffForHumans($date);
                                        @endphp

                                        <small>
                                            {{ $interval }}
                                        </small>
                                    </td>


                                    <td>
                                        <small>
                                            <a class="btn btn-info btn-sm  data-toggle="tooltip" data-placement="top" title="{{ __('Show') }}" href="{{ $notification->url }}">
                                                <i class="fas fa-solid fa-tv"></i>
                                            </a>
                                        </small>
                                    </td>


                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $notifications->appends(request()->query())->links() }}</div>
            @else
                <h3 class="pl-2">{{ __('No notifications To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
