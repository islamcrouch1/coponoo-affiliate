@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Bonus') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Bonus') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->

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
                            @if (auth()->user()->hasPermission('bonus-create'))
                                <a href="{{ route('bonus.create', app()->getLocale()) }}"> <button type="button"
                                        class="btn btn-primary">{{ __('Create bonus') }}</button></a>
                            @else
                                <a href="#" aria-disabled="true"> <button type="button"
                                        class="btn btn-primary">{{ __('Create bonus') }}</button></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Bonus') }}</h3>

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
                @if ($bonuses->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>
                                <th>
                                    {{ __('Type') }}
                                </th>
                                <th>
                                    {{ __('Amount') }}
                                </th>
                                <th>
                                    {{ __('End date') }}
                                </th>
                                <th>
                                    {{ __('Admin') }}
                                </th>
                                <th>
                                    {{ __('Created At') }}
                                </th>
                                <th>
                                    {{ __('Updated At') }}
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($bonuses as $bonus)
                                    <td>
                                        {{ $bonus->id }}
                                    </td>

                                    <td>
                                        <small>
                                            {{ $bonus->type }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $bonus->amount }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $bonus->date }}
                                        </small>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $bonus->user_id]) }}">
                                            <small>
                                                {{ $bonus->user->name }}
                                            </small>
                                        </a>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $bonus->created_at }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $bonus->updated_at }}
                                        </small>
                                    </td>

                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $bonuses->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No data to show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
