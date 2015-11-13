(function($){
    "use strict"; // Start of use strict

    /* --------------------------------------------
     Mobile detect
     --------------------------------------------- */
    var ktmobile;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        ktmobile = true;
        $("html").addClass("mobile");
    }
    else {
        ktmobile = false;
        $("html").addClass("no-mobile");
    }

    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */

    $(window).load(function(){

        // Page loader
        $("body").imagesLoaded(function(){
            //$(".page-loader").fadeOut("slow",function(){
                init_wow();
            //});
        });

        $(window).trigger("scroll");
        $(window).trigger("resize");

    });

    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).resize(function(){
        init_dataWidth();
        init_js_height();
    });

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function(){


        $('body')
            .on('click','.nav-bar-leftbar',function(e){
                e.preventDefault();
                $('body').addClass('open-leftbar');
            })
            .on('click','#nav-leftbar-close',function(e){
                e.preventDefault();
                $('body').removeClass('open-leftbar');
            })
            .on('click','#nav-mobile-sidebar',function(e){
                e.preventDefault();
                $('body').addClass('open-mobile-sidebar');
            })
            .on('click','#nav-mobile-close',function(e){
                e.preventDefault();
                $('body').removeClass('open-mobile-sidebar');
            })
            .on('click','#nav-nobile-sidebar',function(e){
                e.preventDefault();
                $('body').removeClass('open-leftbar');
            });


        init_dataWidth();
        //init_scrolling();
        init_SearchFull();
        init_MainMenu();
        init_rating();
        init_carousel();
        init_revolution();
        init_parallax();
        init_shortcodes();





        $('.products-sortby select').selectpicker({
            styleBase: '',
            style: ''
        });

        var current_min_price = 0,
            current_max_price = 500;

        $( '.price_slider' ).slider({
            range: true,
            min: 0,
            max: 700,
            values: [ current_min_price, current_max_price ],
            create: function() {
                $( '.price_label span.from' ).html( '$' + current_min_price );
                $( '.price_label span.to' ).html( '$' + current_max_price );
            },
            slide: function( event, ui ) {
                $( '.price_label span.from' ).html( '$' + ui.values[ 0 ] );
                $( '.price_label span.to' ).html( '$' + ui.values[ 1 ] );
            }
        });






    });


    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){

            var objCarousel = $(this),
                options = $(objCarousel).data('options') || {};
            options.theme = 'owl-kttheme';

            if(typeof options.desktop !== "undefined"){
                options.itemsDesktop = [1199,options.desktop];
                options.itemsDesktopSmall = [991,options.desktop];
                options.items = options.desktop;
            }

            if(typeof options.tablet !== "undefined"){
                options.itemsTablet = [991,options.tablet];
            }

            if(typeof options.navigationText === "undefined"){
                options.navigationText = ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'];
            }

            if(typeof options.mobile !== "undefined"){
                options.itemsMobile = [479,options.mobile];
            }




            options.afterInit  = function(elem) {

                if(typeof options.outer !== "undefined"){
                    console.log('call');
                    if (options.navigation) {
                        var $wrapper = elem.find('.owl-buttons');
                        $wrapper.appendTo(objCarousel.closest('.owl-carousel-kt'));
                    }
                }

            };


            var func_cb =  window[ func_cb ];

            /*
             afterInit : function(elem){
             if(owlPagination && owlNavigation){
             var that = this;
             that.paginationWrapper.appendTo(objCarousel.closest('.owl-carousel-kt'));
             }

             if( typeof func_cb === 'function'){
             func_cb( 'afterInit',   elem );
             }
             },
             afterUpdate: function(elem) {
             if( typeof func_cb === 'function'){
             func_cb( 'afterUpdate',   elem );
             }
             },
             afterMove : function ( elem ){
             if( typeof func_cb === 'function'){
             func_cb( 'afterUpdate',   elem );
             }
             }
            */

            objCarousel.waitForImages(function() {
                objCarousel.owlCarousel(options);
            });

        });
    }

    function init_rating(){
        // Star ratings for comments
        $( '#rating' ).before( '<p class="stars"><span><a class="star-1" href="#" data-val="1"></a><a class="star-2" href="#" data-val="2"></a><a class="star-3" href="#" data-val="3"></a><a class="star-4" href="#" data-val="4"></a><a class="star-5" href="#" data-val="5"></a></span></p>' );

        $( 'body' )
            .on( 'click', '#respond p.stars a', function() {
                var $star   = $( this ),
                    $rating = $( this ).closest( '#respond' ).find( '#rating'),
                    $stars = $( this ).closest( 'p.stars'),
                    $val = $star.data('val');

                $rating.val( $val );
                $star.siblings( 'a' ).removeClass( 'active' );
                $stars.find('a:lt('+$val+')').addClass( 'active' );

                return false;
            });
    }





    /* ==============================================
     Add data width to body Script
     =============================================== */
    function init_dataWidth(){
        var InitStr = $(window).width();
        $('body').attr('data-width',InitStr);
    }


    /* ---------------------------------------------
     Height 100%
     --------------------------------------------- */
    function init_js_height(){

        $(".item-height-window").css('height', $(window).height());
        $(".item-height-parent").each(function(){
            $(this).height($(this).parent().first().height());
        });

    }

    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes() {

        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').tooltip({
            container:"body"
        });
    }

    /* ---------------------------------------------
     WOW animations
     --------------------------------------------- */

    function init_wow(){

        var wow = new WOW({
            mobile: false
        });

        if ($("body").hasClass("appear-animate")){
            wow.init();
        }
    }



    /* ---------------------------------------------
     Search
     --------------------------------------------- */
    function init_SearchFull(){
        $('.search-action a').magnificPopup({
            type: 'inline',
            mainClass : 'mfp-zoom-in',
            items: { src: '#search-fullwidth' },
            focus : 'input[name=s]',
            removalDelay: 200
        });
    }

    /**==============================
     ***  Equal height
     ===============================**/
    $('.equal_height').each(function(){
        var equal_height_element;
        if($(this).hasClass('equal_height_element')){
            equal_height_element = $(this).children('.kt_column').children('*');
        }else{
            equal_height_element = $(this).children();
        }
        equal_height_element.matchHeight({ byRow: true });
    });


    /* ---------------------------------------------
     Main Menu
     --------------------------------------------- */
    function init_MainMenu(){
        $("ul#main-navigation").superfish({
            hoverClass: 'hovered',
            popUpSelector: 'ul.sub-menu-dropdown,.kt-megamenu-wrapper',
            animation: {},
            animationOut: {}
        });
    }


    /* -------------------------------------------
    Parallax Effect
    --------------------------------------------- */

    function init_parallax(){

        // Parallax
        if (($(window).width() >= 1024) && (ktmobile == false)) {
            $(".parallax-1").parallax("50%", 0.1);
            $(".parallax-2").parallax("50%", 0.2);
            $(".parallax-3").parallax("50%", 0.3);
            $(".parallax-4").parallax("50%", 0.4);
            $(".parallax-5").parallax("50%", 0.5);
            $(".parallax-6").parallax("50%", 0.6);
            $(".parallax-7").parallax("50%", 0.7);
        }

    }

    /* ---------------------------------------------
     Smooth Scrolling
     --------------------------------------------- */
    function init_scrolling() {

        $('body')
            .on('click', 'a[href*=#]:not([href=#])', function (e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top
                        }, 2000);
                        return false;
                    }
                }
            }).on('click', 'a:not([href*=mailto],[href*=tel],[href*=#])', function (e) {
                if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') || location.hostname === this.hostname) {
                    $(".page-loader").fadeIn("slow");
                    var href = $(this).attr("href");
                    $("#page").fadeOut("slow", function () {
                        window.location = href;
                    });
                    return false;
                }
            });
    }


    function init_revolution(){
        $("#rev_slider_1").show().revolution({
            sliderType:"carousel",
            jsFileLocation:"assets/libs/revolution/js/",
            sliderLayout:"fullwidth",
            dottedOverlay:"none",
            delay:1000,
            carousel: {
                maxRotation: 0,
                minScale: 70,
                maxVisibleItems: 3,
                infinity: "on",
                space: -50,
                vary_fade: "on",
                stretch: "off"
            },
            gridwidth:450,
            gridheight: 650,
            stopAfterLoops:0,
            stopAtSlide:1,
            disableProgressBar:"on"
        });


        $("#rev_slider_2").show().revolution({
            sliderType:"standard",
            jsFileLocation:"assets/libs/revolution/js/",
            sliderLayout:"fullwidth",
            dottedOverlay:"none",
            delay:6000,
            navigation: {
                keyboardNavigation:"off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation:"off",
                onHoverStop:"off",
                touch:{
                    touchenabled:"on",
                    swipe_threshold: 75,
                    swipe_min_touches: 50,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                }
                ,
                arrows: {
                    style:"metis",
                    enable:true,
                    hide_onmobile:true,
                    hide_under:600,
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    tmp:'',
                    left: {
                        h_align:"left",
                        v_align:"center",
                        h_offset:30,
                        v_offset:0
                    },
                    right: {
                        h_align:"right",
                        v_align:"center",
                        h_offset:30,
                        v_offset:0
                    }
                }
                ,
                bullets: {
                    enable:true,
                    hide_onmobile:true,
                    hide_under:600,
                    style:"ares",
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    direction:"horizontal",
                    h_align:"center",
                    v_align:"bottom",
                    h_offset:0,
                    v_offset:30,
                    space: 10,
                    tmp:'<span class="tp-bullet-inner"></span>'
                }
            },
            gridwidth:1290,
            gridheight:920,
            lazyType:"none",
            shadow:0,
            spinner:"spinner0",
            stopLoop:"off",
            stopAfterLoops:-1,
            stopAtSlide:-1,
            shuffle:"off",
            autoHeight:"off",
            disableProgressBar:"on",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            startWithSlide:0,
            debugMode:false,
            fallbacks: {
                simplifyAll:"off",
                nextSlideOnWindowFocus:"off",
                disableFocusListener:false,
            }
        });

    }

})(jQuery); // End of use strict