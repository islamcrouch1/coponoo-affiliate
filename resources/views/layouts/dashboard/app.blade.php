<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Copono Dashboard</title>

    <link rel="icon" href="{{ asset('storage/img/fevicon.png') }}">


    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <meta name="csrf-token" content="{{ csrf_token() }}">







    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('dist/noty/noty.css') }}">
    <script src="{{ asset('dist/noty/noty.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link type="text/css" href="{{ asset('css/intlTelInput.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css"
        rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;400&display=swap" rel="stylesheet">


    @if (app()->getLocale() == 'ar')
        <style>
            .card {
                direction: rtl;
                text-align: right;
            }





            .card-title {
                float: right;

            }



            .modal-body {
                direction: rtl;
                text-align: right;
            }

            .card-header>.card-tools {
                float: left;
            }

            .content {
                direction: rtl;
                text-align: right;
            }

            .content-header {
                direction: rtl;
                text-align: right;
            }

            .content-gummla {
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


            .iti__flag {
                background-image: url("/images/flags.png");
            }

            @media (-webkit-min-device-pixel-ratio: 2),
            (min-resolution: 192dpi) {
                .iti__flag {
                    background-image: url("/images/flags@2x.png");
                }
            }

            .iti__selected-flag {
                direction: ltr;
            }

            .iti__country {
                padding: 5px 10px;
                outline: none;
                direction: ltr;
            }


            #phone {
                direction: ltr !important;
            }

            #parent_phone {
                direction: ltr !important;
            }

            .iti {
                position: relative;
                display: inline-block;
                width: 100%;
            }

            .btn {
                margin: 2px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
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

        /* .content-wrapper{
            background-color: #c1e3ff;
        } */

        @media only screen and (min-width: 1000px) {
            .coponoo .col-md-2 {
                max-width: 12.5% !important;
            }
        }

        .cat-title {
            height: 45px;
            font-family: 'Cairo', sans-serif;
            font-size: 13px;
            font-weight: bold;
        }

        .cat-title a {
            color:#000000 !important;

        }


        .navbar-white {
            background-color: #008cff;
        }

        .iti__flag {
            background-image: url("/images/flags.png");
        }

        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .iti__flag {
                background-image: url("/images/flags@2x.png");
            }
        }

        .iti__selected-flag {
            direction: ltr;
        }

        .form-check-inline {
            padding-top: 10px
        }

        .product-a {
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 228px;
            margin: 0 0 15px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn:not(:disabled):not(.disabled).active,
        .btn:not(:disabled):not(.disabled):active {
            box-shadow: none;
            background-color: #c3ceda;
        }

        .form-check-inline .form-check-input {
            margin-left: 10px
        }

        .iti__country {
            padding: 5px 10px;
            outline: none;
            direction: ltr;
        }

        .modal-refund {
            border-top: unset;
            border-bottom: 1px solid #e9ecef;
        }


        #phone {
            direction: ltr !important;
        }

        #parent_phone {
            direction: ltr !important;
        }

        .iti {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .btn {
            margin: 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            direction: rtl !important;
        }

        .labl {
            display: block;
        }

        .labl>input {
            /* HIDE RADIO */
            visibility: hidden;
            /* Makes input not-clickable */
            position: absolute;
            /* Remove input from document flow */
        }

        .labl>input+div {
            /* DIV STYLES */
            cursor: pointer;
            border-radius: 50px;
        }

        .labl>input:checked+div {
            /* (RADIO CHECKED) DIV STYLES */
            border: 1px solid #000000;
            width: 35px !important;
            height: 35px !important;
            border-radius: 50px;
        }


        .labl-size>input {
            /* HIDE RADIO */
            visibility: hidden;
            /* Makes input not-clickable */
            position: absolute;
            /* Remove input from document flow */
        }

        .labl-size>input+div {
            /* DIV STYLES */
            cursor: pointer;
            border: 1px solid #333333;
            padding: 10px;
            float: right;
            margin: 5px;
            margin-top: 10px;
        }

        .labl-size>input:checked+div {
            /* (RADIO CHECKED) DIV STYLES */
            border-radius: 10px -webkit-box-shadow: 1px 3px 12px 2px rgba(51, 51, 51, 0.75);
            box-shadow: 1px 3px 12px 2px rgba(51, 51, 51, 0.75);
        }


        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .card-header{
            background-color: #008cff !important;
        }
        .table td {
            padding:0!important;
            width: 30px;
        }
        .btnn{
            width: 30px !important;
        }


    </style>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('layouts.dashboard._header')

        @include('layouts.dashboard._aside')

        @include('layouts.dashboard._flash')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-2">


            @yield('adminContent')

            <!-- /.content -->
        </div>





        @include('layouts.dashboard._footer')


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script src="{{ asset('dist/js/cart.js') }}"></script>
    <script src="{{ asset('dist/js/notification.js') }}"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script>

    <script src="{{ asset('js/intlTelInput.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js">
    </script>



    @if (setting('modal_2') == 'on')
        <script>
            $('#vendorModal').modal('show')
        </script>
    @endif


    @if (setting('modal_3') == 'on')
        <script>
            $('#affiliateModal').modal('show')
        </script>
    @endif



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });





        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;


        var pusher = new Pusher('eafcb3adf9234ab2c05d', {
            cluster: 'mt1'
        });



        $('.select4').select2();


        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["eg"],
            utilsScript: "/js/utils.js?<%= time %>"
        });


        var input = document.querySelector("#parent_phone");
        window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["eg"],
            utilsScript: "/js/utils.js?<%= time %>"

        });


        $(document).ready(function() {



            $(".img1").change(function() {

                if (this.files) {

                    var filesAmount = this.files.length;
                    $('#gallery').empty();


                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            var image = `
                                        <img src="` + event.target.result + `" style="width:100px"  class="img-thumbnail img-prev">
                                   `;

                            $('#gallery').append(image);

                        }
                        reader.readAsDataURL(this.files[i]);
                    }

                }

            });


            $(".img").change(function() {

                if (this.files && this.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('.img-prev').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }

            });






            $('.btn').on('click', function() {

                $("#phone_hide").val($(".iti__selected-dial-code").html());

                $("#parent_phone_hide").val($(".iti__selected-dial-code").html());

                $(this).closest('form').submit();

                $(".btn").attr("disabled", true);

            });






        });
    </script>

    <script>
        function downloadAll() {
            var div = document.getElementById("allImages");
            console.log(div);
            var images = div.getElementsByTagName("img");
            console.log(images)

            for (i = 0; i < images.length; i++) {
                console.log(images[i]);
                downloadWithName(images[i].src, images[i].src);
            }
        }

        function downloadWithName(uri, name) {
            function eventFire(el, etype) {
                if (el.fireEvent) {
                    (el.fireEvent('on' + etype));
                } else {
                    var evObj = document.createEvent('MouseEvent');
                    evObj.initMouseEvent(etype, true, false,
                        window, 0, 0, 0, 0, 0,
                        false, false, false, false,
                        0, null);
                    el.dispatchEvent(evObj);
                }
            }

            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            eventFire(link, "click");
        }
    </script>


    <script type="text/javascript">
        $('.colorpicker').colorpicker();
    </script>



    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/61c9ab94c82c976b71c3ab10/1fntscfdk';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

</body>

</html>
