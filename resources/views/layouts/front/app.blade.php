<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coponoo') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!--Fevicon icon-->
        <link rel="icon" href="{{ asset('storage/img/fevicon.png') }}">

        <!-- Stylesheet -->
<!-- CSS only -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('css/slick-slider.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">


        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;400&display=swap" rel="stylesheet">


    <link type="text/css" href="{{ asset('css/intlTelInput.css') }}" rel="stylesheet">


  @if (app()->getLocale() == 'ar')

    <style>


        h1,h2,h3,h5,h6,p,span,.banner-inner,.text-al{
            direction: rtl !important;
            text-align: right !important;
        }

        .page-title{
            text-align: center !important;

        }


        .card{
            direction: rtl;
            text-align: right;
        }


        .form-check-label {
            margin-right: 20px;

        }

        .content{
            direction: rtl;
            text-align: right;
        }

        .content-header{
            direction: rtl;
            text-align: right;
        }

        .content-gummla{
            direction: rtl;
            text-align: right;
        }


                /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


        .iti__flag {background-image: url("/images/flags.png");}

        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .iti__flag {background-image: url("/images/flags@2x.png");}
        }

        .iti__selected-flag{
            direction: ltr;
        }

        .iti__country {
            padding: 5px 10px;
            outline: none;
            direction: ltr;
        }


        #phone{
            direction: ltr !important;
        }

        #parent_phone{
            direction: ltr !important;
        }

        .iti {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .btn{
            margin:2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            direction: rtl !important;
        }


    </style>

  @endif


  <style>
                      /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }


        .btn-link{
            color: blue !important
        }

        .nice-select{
            width: 100% !important ;
        }

        .iti__flag {background-image: url("/images/flags.png");}

        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
        .iti__flag {background-image: url("/images/flags@2x.png");}
        }

        .iti__selected-flag{
            direction: ltr;
        }

        .iti__country {
            padding: 5px 10px;
            outline: none;
            direction: ltr;
        }


        #phone{
            direction: ltr !important;
        }

        #parent_phone{
            direction: ltr !important;
        }

        .iti {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .btn{
            margin:2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            direction: rtl !important;
        }


  </style>




    @if (app()->getLocale() == 'ar')

    <style>
        .card{
            direction: rtl;
            text-align: right;
        }


        .content-header{
            direction: rtl;
            text-align: right;
        }
    </style>

  @endif
</head>
<body>


    @include('layouts.front._header')


    @yield('content')


    @include('layouts.front._footer')

{{--

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Coponoo') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login' ,  ['lang'=>app()->getLocale() ]) }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register' ,  ['lang'=>app()->getLocale() ]) }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div> --}}




    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/image-loaded.js') }}"></script>
    <script src="{{ asset('js/nice-select.js') }}"></script>
    <script src="{{ asset('js/slick-slider.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/ripple.js') }}"></script>
    <script src="{{ asset('js/waypoint.js') }}"></script>
    <script src="{{ asset('js/counterup.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/app1.js') }}" defer></script>


    <!-- main js  -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('js/intlTelInput.js') }}"></script>




    @if (setting('modal_1') == 'on')
    <script>

        var myModal = new bootstrap.Modal(document.getElementById('frontModal'), {
        keyboard: false
        });

        myModal.show()


    </script>

    @endif


    <script>





                var input = document.querySelector("#phone");
                    window.intlTelInput(input, {
                        separateDialCode: true,
                        preferredCountries:["eg"],
                        utilsScript: "/js/utils.js?<%= time %>"
                    });


                var input = document.querySelector("#parent_phone");
                    window.intlTelInput(input, {
                        separateDialCode: true,
                        preferredCountries:["eg"],
                        utilsScript: "/js/utils.js?<%= time %>"

                    });










    </script>


    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/61c9ab94c82c976b71c3ab10/1fntscfdk';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->


</body>
</html>
