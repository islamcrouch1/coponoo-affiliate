@extends('layouts.dashboard.app')

@section('adminContent')
 
   
   
   <!-- Main content -->
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ asset('storage/' . $user->profile) }}"
                     alt="User profile picture">
              </div>

            <h3 class="profile-username text-center"><span>{{'# ' . $user->id }}</span>{{$user->name}}</h3>

              <p class="text-muted text-center">{{$user->type}}</p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{$user->email}}</a>
                </li>
                <li class="list-group-item">
                  <b>Country</b> <a class="float-right">{{$user->country}}</a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="float-right">{{$user->phone}}</a>
                </li>
                <li class="list-group-item">
                    <b>Gender</b> <a class="float-right">{{$user->gender}}</a>
                </li>
                <li class="list-group-item">
                    <b>Created At</b> <a class="float-right">{{$user->created_at}}</a>
                  </li>
              </ul>

              <a href="{{route('users.edit' , ['lang'=>app()->getLocale() , 'user'=>$user->id])}}" class="btn btn-primary btn-block"><b>Edit</b></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->



@endsection