  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('home', app()->getLocale()) }}" class="nav-link">{{ __('Home') }}</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
              @if (Auth::user()->hasRole('superadministrator'))
                  <a href="{{ route('messages.admin.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}}}"
                      class="nav-link">{{ __('Contact') }}</a>
              @else
                  <a href="{{ route('messages.show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}}}"
                      class="nav-link">{{ __('Contact') }}</a>
              @endif
          </li>
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout', ['lang' => app()->getLocale()]) }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout', ['lang' => app()->getLocale()]) }}" method="POST"
                      class="d-none">
                      @csrf
                  </form>
              </div>
          </li>

          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ __('Language') }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="nav-link"
                      href="{{ str_replace('/ar', '/en', url()->current()) }}">{{ __('English') }}</a>
                  <a class="nav-link"
                      href="{{ str_replace('/en', '/ar', url()->current()) }}">{{ __('Arabic') }}</a>
              </div>
          </li>




      </ul>

      <!-- SEARCH FORM -->
      {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

          @php
              $userid = Auth::id();
          @endphp


          @if (Auth::user()->HasRole('affiliate'))
              <li style="list-style: none" class="nav-item">
                  <a class="nav-link"
                      href="{{ route('cart', ['lang' => app()->getLocale(), 'user' => $userid]) }}">
                      <i class="fa fa-shopping-cart fa-lg"></i>
                      <span class='badge badge-danger navbar-badge'
                          id='lblCartCount'>{{ Auth::user()->cart->products->count() }}</span>
                  </a>

              </li>

              <li style="list-style: none" class="nav-item">
                  <a class="nav-link"
                      href="{{ route('fav', ['lang' => app()->getLocale(), 'user' => $userid]) }}">
                      <i class="far fa-heart fa-lg"></i>
                      <span class='badge badge-danger navbar-badge'
                          id='fav-icon'>{{ Auth::user()->fav->count() }}</span>
                  </a>

              </li>
          @endif




          {{-- <li style="list-style: none" class="nav-item">

            <!-- Notifications dropdown -->
            <div class="nav-item ml-10pt dropdown dropdown-notifications dropdown-xs-down-full noty-nav"
                data-toggle="tooltip"
                data-title="{{__('Notifications')}}"
                data-placement="bottom"
                data-boundary="window"
                data-local="{{app()->getLocale()}}"
                style="margin-top: 25px;">

                <button class="nav-link btn-flush dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                        data-caret="false">
                    <i class="material-icons">notifications_none</i>
                    <span class="badge badge-notifications badge-accent">{{Auth::user()->notifications->where('status' , 0)->count()}}</span>
                </button>

                @auth

                <input class="noty_id" type="hidden"
                data-id="{{Auth::id()}}"
                >

                @endauth

                <div class="dropdown-menu dropdown-menu-right">
                    <div data-perfect-scrollbar
                        class="position-relative"
                        style="  height:500px;
                        overflow-y: scroll;">
                        <div class="dropdown-header d-flex"><strong>{{__('Notifications')}}</strong></div>
                        <div class="list-group list-group-flush mb-0 noty-list">


                            @foreach (Auth::user()->notifications()->orderBy('id', 'desc')->limit(50)->get()
    as $notification)




                            <a href="{{$notification->url}}"
                            class="list-group-item list-group-item-action unread noty"
                            data-url="{{ route('notification-change', ['lang'=>app()->getLocale() , 'user'=>Auth::id() , 'notification'=>$notification->id ] ) }}">
                                <span class="d-flex align-items-center mb-1">

                                    <small class="text-black-50">{{$notification->created_at}}</small>


                                    @if ($notification->status == 0)
                                    <span class=" {{app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'}} unread-indicator bg-accent"></span>
                                    @endif


                                </span>
                                <span class="d-flex">
                                    <span class="avatar avatar-xs mr-2">
                                        <img src="{{$notification->user_image}}"
                                            alt="people"
                                            class="avatar-img rounded-circle">
                                    </span>
                                    <span class="flex d-flex flex-column">
                                        <strong class="text-black-100" style="{{app()->getLocale() == 'ar' ? 'text-align: right;' : ''}}">{{app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en}}</strong>
                                        <span class="text-black-70" style="{{app()->getLocale() == 'ar' ? 'text-align: right;' : ''}}">{{app()->getLocale() == 'ar' ? $notification->body_ar : $notification->body_en}}</span>
                                    </span>
                                </span>
                            </a>

                            @endforeach


                        </div>
                    </div>
                </div>

            </div>
            <!-- // END Notifications dropdown -->

        </li> --}}

          <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
              <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-comments fa-lg"></i>
                  <span
                      class="badge badge-danger navbar-badge badge-accent">{{ Auth::user()->notifications->where('status', 0)->count() }}</span>
              </a>
              <div style="overflow-y: scroll; max-height:600px "
                  class="dropdown-menu dropdown-menu-lg dropdown-menu-right noty-nav noty-list" data-toggle="tooltip"
                  data-title="{{ __('Notifications') }}" data-placement="bottom" data-boundary="window"
                  data-local="{{ app()->getLocale() }}">

                  @auth

                      <input class="noty_id" type="hidden" data-id="{{ Auth::id() }}">

                  @endauth

                  @foreach (Auth::user()->notifications()->orderBy('id', 'desc')->limit(50)->get()
    as $notification)
                      <a href="

          {{ app()->getLocale() == 'ar'? str_replace('/en', '/ar', $notification->url): str_replace('/ar', '/en', $notification->url) }}

          " class="dropdown-item unread noty"
                          data-url="{{ route('notification-change', ['lang' => app()->getLocale(),'user' => Auth::id(),'notification' => $notification->id]) }}">
                          <!-- Message Start -->
                          <div class="media">
                              <img src="{{ asset('storage/images/icon.png') }}" alt="User Avatar"
                                  class="img-size-50 mr-3 img-circle">
                              <div class="media-body">
                                  <h3 class="dropdown-item-title">

                                      {{-- Brad Diesel --}}

                                      @if ($notification->status == 0)
                                          <span class="float-right text-sm text-danger"><i
                                                  class="fas fa-star"></i></span>
                                      @else
                                          <span class="float-right text-sm text-success"><i
                                                  class="fas fa-star"></i></span>
                                      @endif
                                  </h3>
                                  <p class="text-sm"><strong class="text-black-100"
                                          style="{{ app()->getLocale() == 'ar' ? 'text-align: right;' : '' }}">{{ app()->getLocale() == 'ar' ? $notification->title_ar : $notification->title_en }}</strong>
                                  </p>
                                  <p class="text-sm"><span class="text-black-70"
                                          style="{{ app()->getLocale() == 'ar' ? 'text-align: right;' : '' }}">{{ app()->getLocale() == 'ar' ? $notification->body_ar : $notification->body_en }}</span>
                                  </p>

                                  @php
                                      $date = Carbon\Carbon::now();
                                      $interval = $notification->created_at->diffForHumans($date);
                                  @endphp
                                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ $interval }}
                                  </p>
                              </div>
                          </div>
                          <!-- Message End -->
                      </a>
                      <div class="dropdown-divider"></div>
                  @endforeach

                  <a href="{{ route('notification-show', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                      class="dropdown-item dropdown-footer">{{ __('See All Notifications') }}</a>
                  <a href="{{ route('notification-change-all', ['lang' => app()->getLocale(), 'user' => Auth::id()]) }}"
                      class="dropdown-item dropdown-footer">{{ __('Mark all as read') }}</a>

              </div>
          </li>
          <!-- Notifications Dropdown Menu -->
          {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}
      </ul>
  </nav>
  <!-- /.navbar -->
