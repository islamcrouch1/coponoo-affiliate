@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Messages') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb {{ app()->getLocale() == 'ar' ? 'float-sm-left' : 'float-sm-right' }}">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Messages') }}</li>
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
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Messages') }}</h3>

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
                @if ($messages->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    #id
                                </th>

                                <th>
                                    {{ __('User Name') }}
                                </th>
                                <th>
                                    {{ __('Message') }}
                                </th>
                                <th>
                                    {{ __('Created At') }}
                                </th>

                                <?php if ($messages !== null) {
                                    $message = $messages[0];
                                } ?>
                                @if ($message->trashed())
                                    <th>
                                        {{ __('Deleted At') }}
                                    </th>
                                @endif
                                <th style="" class="">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($messages->reverse() as $message)
                                    @php
                                        $user1 = App\User::find($message->sender_id);
                                    @endphp

                                    @if ($user1->hasRole('affiliate') || $user1->hasRole('vendor'))
                                        <td>
                                            {{ $message->id }}
                                        </td>


                                        <td>
                                            <small>
                                                {{ $message->user->name }}
                                            </small>
                                        </td>


                                        <td>
                                            <small>
                                                {{ $message->message }}
                                            </small>
                                        </td>


                                        <td>

                                            @php
                                                $date = Carbon\Carbon::now();
                                                $interval = $message->created_at->diffForHumans($date);
                                            @endphp

                                            <small>
                                                <span style="direction: ltr !important"
                                                    class="badge badge-success">{{ $interval }}</span>

                                            </small>
                                        </td>


                                        <td class="project-actions">
                                            <div class="row">

                                            @if (!$message->trashed())
                                                @if (auth()->user()->hasPermission('messages-read'))
                                                <div class="col-md-12">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Reply') }}"
                                                        href="{{ route('users.show', ['lang' => app()->getLocale(), 'user' => $message->user_id]) }}">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        
                                                    </a>
                                                </div>
                                                @else
                                                <div class="col-md-12">
                                                    <a class="btn btn-info btn-sm"data-toggle="tooltip" data-placement="top" title="{{ __('Reply') }}" href="#" aria-disabled="true">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        
                                                    </a>
                                                </div>
                                                @endif
                                            @endif
                                        </div>




                                        </td>
                                    @endif

                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $messages->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No messages To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
