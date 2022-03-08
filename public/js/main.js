; (function ($) {
    "use strict";

    $(document).ready(function () {

        /**-----------------------------
         *  Navbar fix
         * ---------------------------*/
        $(document).on('click', '.navbar-area .navbar-nav li.menu-item-has-children>a', function (e) {
            e.preventDefault();
        })

        /*-------------------------------------
            menu
        -------------------------------------*/
        $('.navbar-area .menu').on('click', function() {
            $(this).toggleClass('open');
            $('.navbar-area .navbar-collapse').toggleClass('sopen');
        });

        // mobile menu
        if ($(window).width() < 992) {
            $(".in-mobile").clone().appendTo(".sidebar-inner");
            $(".in-mobile ul li.menu-item-has-children").append('<i class="fas fa-chevron-right"></i>');
            $('<i class="fas fa-chevron-right"></i>').insertAfter("");

            $(".menu-item-has-children a").on('click', function(e) {
                // e.preventDefault();

                $(this).siblings('.sub-menu').animate({
                    height: "toggle"
                }, 300);
            });
        }

        var menutoggle = $('.menu-toggle');
        var mainmenu = $('.navbar-nav');

        menutoggle.on('click', function() {
            if (menutoggle.hasClass('is-active')) {
                mainmenu.removeClass('menu-open');
            } else {
                mainmenu.addClass('menu-open');
            }
        });

        /*--------------------------------------------
            Search Popup
        ---------------------------------------------*/
        var bodyOvrelay =  $('#body-overlay');
        var searchPopup = $('#search-popup');

        $(document).on('click','#body-overlay',function(e){
            e.preventDefault();
        bodyOvrelay.removeClass('active');
            searchPopup.removeClass('active');
        });
        $(document).on('click','.search',function(e){
            e.preventDefault();
            searchPopup.addClass('active');
        bodyOvrelay.addClass('active');
        });

        // Water Effect
        var $waterEffect = $('.water-effect');
        if ($waterEffect.length > 0) {
            $waterEffect.ripples({
                resolution: 256,
                perturbance: 0.05,
                // dropRadius: 50
            });
        }

        /*--------------------------------------------------
            select onput
        ---------------------------------------------------*/
        $('select').niceSelect();

        /* -------------------------------------------------------------
         fact counter
         ------------------------------------------------------------- */
        $('.counter').counterUp({
            delay: 15,
            time: 2000
        });

        /* -----------------------------------------------------
            Variables
        ----------------------------------------------------- */
        var leftArrow = '<i class="la la-arrow-left"></i>';
        var leftAngle = '<i class="fa fa-angle-left"></i>';
        var rightArrow = '<i class="la la-arrow-right"></i>';
        var rightAngle = '<i class="fa fa-angle-right"></i>';

        /*------------------------------------
            Slider
        ------------------------------------*/
        /**screenshot-slider**/
        $('.screenshot-slider').slick({
          infinite: true,
          slidesToShow: 5,
          arrows: false,
          speed: 1500,
          dots: true,
          centerMode: true,
          centerPadding: '0%',
          prevArrow: leftAngle,
          nextArrow: rightAngle,
          responsive: [{
              breakpoint: 991,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 2
              }
            },
            {
               breakpoint: 500,
               settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
               }
            }]
        });

        /*------------------------------------
            testimonial Slider
        ------------------------------------*/
        /**testimonial-slider**/
        $('.testimonial-slider').slick({
            infinite: true,
            slidesToShow: 3,
            arrows: false,
            speed: 1500,
            dots: true,
            centerMode: true,
            centerPadding: '0%',
            responsive: [{
              breakpoint: 991,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
               breakpoint: 768,
               settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
               }
            }]
        });

        /**discount-slider**/
        $('.discount-slider').slick({
          infinite: true,
          slidesToShow: 1,
          arrows: false,
          speed: 1500,
          dots: true,
          centerMode: true,
          centerPadding: '0%',
        });

        /*------------------------------------------------
            Magnific JS
        ------------------------------------------------*/
        $('.play-btn').magnificPopup({
            type: 'iframe',
            removalDelay: 260,
            mainClass: 'mfp-zoom-in',
        });
        $.extend(true, $.magnificPopup.defaults, {
            iframe: {
                patterns: {
                    youtube: {
                        index: 'youtube.com/',
                        id: 'v=',
                        src: 'https://www.youtube.com/embed/Wimkqo8gDZ0'
                    }
                }
            }
        });

        /*-------------------------------------------------
            wow js init
        --------------------------------------------------*/
        new WOW().init();

        /*------------------
           back to top
        ------------------*/
        $(document).on('click', '.back-to-top', function () {
            $("html,body").animate({
                scrollTop: 0
            }, 2000);
        });

    });

    $(window).on("scroll", function() {
        /*---------------------------------------
        sticky menu activation && Sticky Icon Bar
        -----------------------------------------*/

        var mainMenuTop = $(".navbar-area");
        if ($(window).scrollTop() >= 1) {
            mainMenuTop.addClass('navbar-area-fixed');
        }
        else {
            mainMenuTop.removeClass('navbar-area-fixed');
        }

        var ScrollTop = $('.back-to-top');
        if ($(window).scrollTop() > 1000) {
            ScrollTop.fadeIn(1000);
        } else {
            ScrollTop.fadeOut(1000);
        }
    });

    $(window).on('load', function () {

        /**Pre loader**/
        setTimeout(function() {
            $('body').addClass('loaded');
        }, 300);

        /*-----------------
            back to top
        ------------------*/
        var backtoTop = $('.back-to-top')
        backtoTop.fadeOut();


    });



})(jQuery);
