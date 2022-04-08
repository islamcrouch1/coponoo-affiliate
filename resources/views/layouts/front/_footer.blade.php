    <!-- subscribe-Area Start-->
    <section class="subscribe-area pd-top-140 pd-bottom-150 shape-1">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5 offset-xl-1 col-sm-10 align-self-center">
                    <div class="section-title mb-0 pb-5 text-center text-lg-start">
                        <h2 class="title">{{ __('Latest Update And New Offers Notification') }}</h2>
                        {{-- <p>Delay rapid joy share allow age manor six. Went why far saw many</p> --}}
                    </div>
                    <div class="single-subscribe-wrap">
                        <input type="text" placeholder="{{ __('Email address') }}">
                        <button class="btn btn-black">{{ __('SUBSCRIBE') }}</button>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 offset-xl-1 d-none d-lg-block align-self-end">
                    <div class="thumb span3 wow bounceInRight">
                        <img src="{{ asset('storage/img/other/10.png') }}" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- subscribe-Area end-->

    <!-- footer area start -->
    <footer class="footer-area text-center"
        style="background: url({{ asset('storage/img/shape/footer-bg-1.png') }});">
        <div class="container">
            <div class="footer-thumb">
                <a href="index.html"><img style="width: 140px; padding-top:1px"
                        src="{{ asset('storage/images/logo.png') }}" alt="img"></a>
            </div>
            <div class="widget-footer-link">
                <ul>
                    <li><a href="{{ route('home.front', app()->getLocale()) }}">{{ __('HOME') }}</a></li>
                    {{-- <li><a href="about.html">ABOUT</a></li> --}}
                    <li><a href="{{ route('contact.front', app()->getLocale()) }}">{{ __('CONTACT') }}</a></li>
                </ul>
            </div>
            <div class="widget-footer-social">
                <ul>
                    <li><a href="https://www.facebook.com/Sonoo/"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/SonooEG"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/Sonooeg/"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCUI_iyN0ZcnXN9s96CAFV-w"><i
                                class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
        <!--Footer bottom-->
        <div class="footer-bottom">
            <div class="container">
                <div class="copyright-area">
                    <p>© 2021 Sonoo. All Rights Reserved - Developed By <a style="color: red"
                            href="http://red-gulf.com/">RED</a> </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->

    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"><i class="fa fa-angle-up"></i></span>
    </div>
    <!-- back to top area end -->
