    <!-- preloader area start -->
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <!-- search popup area start -->
    <div class="search-popup" id="search-popup">
        <form action="index.html" class="search-form">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search.....">
            </div>
            <button type="submit" class="submit-btn"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <!-- //. search Popup -->

    <!-- navbar start -->
    <div
        class="navbar-area {{ Route::is('contact.front') || Route::is('contact.products') || Route::is('contact.about')? 'style-4': 'style-3' }}">
        <nav class="navbar navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#themefie_main_menu"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <div class="logo pt-3">
                    <a style="width: 140px; padding-top:1px" class="main-logo"
                        href="{{ route('home.front', app()->getLocale()) }}"><img
                            src="{{ asset('storage/images/logo.png') }}" alt="img"></a>
                    <p><small style="font-size: .65em;">Powered by Sonooegy</small></p>
                </div>
                <div class="collapse navbar-collapse" id="themefie_main_menu">
                    <ul class="navbar-nav menu-open ml-auto">
                        <li class="current-menu-item">
                            <a href="{{ route('home.front', app()->getLocale()) }}">{{ __('HOME') }}</a>
                            {{-- <ul class="sub-menu">
                                <li><a href="index.html">Home 01</a></li>
                                <li><a href="index-2.html">Home 02</a></li>
                                <li><a href="index-3.html">Home 03</a></li>
                                <li><a href="index-4.html">Home 04</a></li>
                            </ul> --}}
                        </li>
                        {{-- <li>
                            <a href="about.html">{{__('ABOUT')}}</a>
                        </li> --}}
                        {{-- <li>
                            <a href="featured.html">FEATURES</a>
                        </li> --}}
                        {{-- <li class="menu-item-has-children current-menu-item">
                            <a href="#">PAGES</a>
                            <ul class="sub-menu">
                                <li><a href="about.html">About</a></li>
                                <li><a href="featured.html">Featured</a></li>
                                <li><a href="faq.html">FAQ</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </li> --}}
                        {{-- <li class="menu-item-has-children current-menu-item">
                            <a href="#">BLOG</a>
                            <ul class="sub-menu">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                            </ul>
                        </li> --}}

                        <li>
                            <a
                                href="{{ route('contact.products', app()->getLocale()) }}">{{ __('OUR PRODUCTS') }}</a>
                        </li>

                        <li>
                            <a href="{{ route('contact.about', app()->getLocale()) }}">{{ __('ABOUT') }}</a>
                        </li>

                        <li>
                            <a href="{{ route('contact.front', app()->getLocale()) }}">{{ __('CONTACT') }}</a>
                        </li>


                        @guest
                            <li class="">
                                <a class=""
                                    href="{{ route('login', ['lang' => app()->getLocale()]) }}">{{ __('LOGIN') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="">
                                    <a class=""
                                        href="{{ route('register', ['lang' => app()->getLocale()]) }}">{{ __('REGISTER') }}</a>
                                </li>
                            @endif
                        @else
                        @endguest


                        @auth
                            <li class="menu-item-has-children">
                                <a href="#">{{ __('Hi ') }} {{ Auth::user()->name }}</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('home', app()->getLocale()) }}">{{ __('My Dashboard') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('logout', ['lang' => app()->getLocale()]) }}"
                                            onclick="event.preventDefault();
                                                                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form"
                                            action="{{ route('logout', ['lang' => app()->getLocale()]) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endauth





                        <li class="menu-item-has-children">
                            <a href="#">{{ __('LANG') }}</a>
                            <ul class="sub-menu">
                                <li><a
                                        href="{{ str_replace('/en', '/ar', url()->current()) }}">{{ __('Arabic') }}</a>
                                </li>
                                <li><a
                                        href="{{ str_replace('/ar', '/en', url()->current()) }}">{{ __('English') }}</a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- navbar end -->
