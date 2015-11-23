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
        init_productsMasonry();


        /**==============================
         ***  Sticky header
         ===============================**/
        if ($.fn.ktSticky) {
            $('.navbar-container.sticky-header').ktSticky({
                contentSticky : '',
                offset: 50
            });
        }
        /**==============================
         ***  Disable mobile menu in desktop
         ===============================**/
        if ($(window).width() >= 1200) {
            $('body').removeClass('opened-nav-animate');
            $('#hamburger-icon').removeClass('active');
        }

    });

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function(){

        init_dataWidth();
        //init_scrolling();
        init_SearchFull();
        init_MainMenu();
        init_MobileMenu();
        init_rating();
        init_carousel();
        init_revolution();
        init_parallax();
        init_shortcodes();
        init_VCGoogleMap();
        init_popup();
        init_quickview();
        init_backtotop();
        init_matchHeight();

        init_productsMasonry();
        init_productCountdown();
        init_gridlistToggle();

        init_productcarouselwoo($("#sync1"), $("#sync2"));


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


        $('#payment .payment_methods li label .input-radio').change(function(){
            var val = $('#payment .payment_methods li label .input-radio:checked').val();
            $('#payment .payment_box').hide();
            $('#payment .payment_method_'+val).show(); 
        }).change();


        $('.kt-tab-container').tabs();
        $('.kt-accordion').accordion({ 'heightStyle': 'content' });


        /* ---------------------------------------------
         Back to top
         --------------------------------------------- */
        $('body').append('<div id="back-to-top"><i class="fa fa-angle-up"></i></div>');
        $('#back-to-top').hide();
        $(window).scroll(function() {
            if($(window).scrollTop() != 0) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').click(function() {
            $('html, body').animate({scrollTop:0},500);
        });
    });


    /* ---------------------------------------------
     Product Countdown
     --------------------------------------------- */
    function init_productCountdown() {
        var coming_html = '<div class="countdown-wrap">'
            +'<div class="value-time">%D</div>'
            +'<div class="title">Days</div>'
            +'</div>'
            +'<div class="countdown-wrap">'
            +'<div class="value-time">%H</div>'
            +'<div class="title">Hours</div>'
            +'</div>'
            +'<div class="countdown-wrap">'
            +'<div class="value-time">%M</div>'
            +'<div class="title">Min</div>'
            +'</div>'
            +'<div class="countdown-wrap">'
            +'<div class="value-time">%S</div>'
            +'<div class="title">Sec</div>'
            +'</div>';

        $('.coming-soon').each(function () {
            var date = $(this).data('date');
            $(this).countdown(date, function (event) {
                $(this).html( event.strftime(coming_html) );
            });

        });
    }

    /* ---------------------------------------------
     Products Masonry
     --------------------------------------------- */

    function init_productsMasonry(){
        $('.products-multi-masonry').each(function(){
            var $masonry = $(this);
            $masonry.waitForImages(function() {

                $masonry.find('.product-thumbnail').css('height', 'auto');

                var standardItem = $masonry.find('.product.standard').first(),
                    standardHeight = standardItem.height(),
                    largeHeight = (standardHeight * 2) + parseInt(standardItem.css('margin-bottom'), 10);

                if (standardHeight > 0) {
                    $masonry.find('.product.wide .product-thumbnail').css('height', largeHeight);
                    $masonry.find('.product.portrait .product-thumbnail').css('height', largeHeight);
                    $masonry.find('.product.big .product-thumbnail').css('height', largeHeight);
                    $masonry.find('.product.landscape .product-thumbnail').css('height', standardHeight);
                    $masonry.find('.product.standard .product-thumbnail').css('height', standardHeight);
                }

                $masonry.isotope({
                    resizable: false,
                    itemSelector : '.product',
                    layoutMode: 'packery',
                    packery: {
                        columnWidth: '.grid-sizer'
                    }
                });



            });


        });
    }


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
                options.items = options.desktop;
            }

            if(typeof options.desktopsmall !== "undefined"){
                options.itemsDesktopSmall = [991,options.desktopsmall];
            }

            if(typeof options.tablet !== "undefined"){
                options.itemsTablet = [768,options.tablet];
            }

            if(typeof options.navigationText === "undefined"){
                options.navigationText = ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'];
            }


            if(typeof options.mobile !== "undefined"){
                options.itemsMobile = [479,options.mobile];
            }

            options.afterInit  = function(elem) {
                if(typeof options.outer !== "undefined" && options.navigation){
                    var $buttons = elem.find('.owl-buttons');
                    $buttons.appendTo(objCarousel.closest('.owl-carousel-kt'));
                }

                if(typeof options.pagbefore !== "undefined" && options.pagination){
                    var $pagination = elem.find('.owl-pagination');
                    $pagination.prependTo(objCarousel.closest('.owl-carousel-kt'));
                }
            };

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
            container:"body",
            delay: { "show": 100, "hide": 100 }
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

    /* ---------------------------------------------
     Match Height
     --------------------------------------------- */
    function init_matchHeight(){
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
    }




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


    /* ---------------------------------------------
     Mobile Menu
     --------------------------------------------- */
    function init_MobileMenu(){


        $('body')
            .on('click','#hamburger-icon',function(e){
                e.preventDefault();
                $(this).toggleClass('active');
                $('body').toggleClass('opened-nav-animate');
                setTimeout(function(){
                    $('body').toggleClass('opened-nav');
                }, 100)

            });

        $('ul.navigation-mobile ul.sub-menu-dropdown, ul.navigation-mobile .kt-megamenu-wrapper').each(function(){
            $(this).parent().children('a').prepend( '<span class="open-submenu"></span>' );
        });

        $('.open-submenu').on('click', function(e){
            e.stopPropagation();
            e.preventDefault();
            $( this ).closest('li').toggleClass('active-menu-item');
            $( this ).closest('li').children( '.sub-menu-dropdown, .kt-megamenu-wrapper' ).slideToggle();
        });

        $(window).resize(function(){
            var $navHeight = $(window).height() - $('.navbar-container').height();
            $('.main-nav-mobile').css({'max-height': $navHeight});
        });

    }


    /* ---------------------------------------------
     Back to top
     --------------------------------------------- */
    function init_backtotop(){
        var backtotop = $('#backtotop').hide();
        $(window).scroll(function() {
            ($(window).scrollTop() != 0) ? backtotop.fadeIn() : backtotop.fadeOut();
        });
        backtotop.click(function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0},500);
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

    
    /* ---------------------------------------------
     Google Map Short code
     --------------------------------------------- */
    function init_VCGoogleMap() {
        var styleMap =  [{"stylers":[{"saturation":-100},{"gamma":0.8},{"lightness":4},{"visibility":"on"}]},{"featureType":"landscape.natural","stylers":[{"visibility":"on"},{"color":"#5dff00"},{"gamma":4.97},{"lightness":-5},{"saturation":100}]}];

        $(".googlemap").each(function () {
            var mapObj = $(this),
                scrollwheel = (mapObj.data('scrollwheel') == '1') ? false : true;
            mapObj.gmap3({
                marker: {values: [{address: mapObj.data('location'), options: {icon: mapObj.data('iconmap')}}]},
                map: {
                    options: {
                        zoom: mapObj.data('zoom'),
                        mapTypeId: mapObj.data('type').toLowerCase(),
                        scrollwheel: scrollwheel,
                        styles: styleMap
                    }
                }
            });
        });
    }


    /* ---------------------------------------------
     Popup content
     --------------------------------------------- */
    function init_popup(){
        var cookie_popup = $.cookie('popup_newletter');
        if($('#popup-wrap').length > 0 && cookie_popup != 1){
            var time_show = $('#popup-wrap').data('timeshow');

            setTimeout(function(){
                $.magnificPopup.open({
                    items: { src: '#popup-wrap' },
                    type: 'inline',
                    mainClass: 'mfp-zoom-in',
                    callbacks: {
                        afterClose: function(){
                            $.cookie('popup_newletter', 1, { expires: 1 });
                        }
                    }
                });
            }, time_show*1000);
        }
    }


    /* ---------------------------------------------
     QickView
     --------------------------------------------- */
    function init_quickview(){
        $('body').on('click', '.quickview', function(e){
            e.preventDefault();
            var objProduct = $(this);
            objProduct.addClass('loading');

            var data = {},
                ajaxurl  = 'ajax/woocommerce-product-quickview.php';

            $.post(ajaxurl, data, function(response) {
                objProduct.removeClass('loading');

                $.magnificPopup.open({
                    mainClass : 'mfp-zoom-in',
                    showCloseBtn: false,
                    removalDelay: 200,
                    items: {
                        src: '<div class="themedev-product-popup mfp-with-anim">' + response + '</div>',
                        type: 'inline'
                    },
                    callbacks: {
                        open: function() {
                            var $popup = $('.themedev-product-popup');
                            $popup.waitForImages(function(){
                                var images = $("#quickview-images"),
                                    thumbnails = $("#quickview-thumbnails");

                                init_productcarouselwoo(images, thumbnails);
                                setTimeout(function(){
                                    $popup.addClass('animate-width');
                                }, 500);
                                setTimeout(function(){
                                    $popup.addClass('add-content');
                                }, 1000);



                            });

                            init_shortcodes();
                        }
                    }
                });
            });
            return false;
        });

        $(document).on('click', '.close-quickview', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });

    }


    /* ---------------------------------------------
     Single Product
     --------------------------------------------- */


    function init_productcarouselwoo(sync1, sync2){

        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            items : 1,
            navigation: true,
            pagination: false,
            afterAction : syncPosition,
            autoHeight: true,
            responsiveRefreshRate : 200,
            navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
        });

        sync2.owlCarousel({
            theme : 'woocommerce-thumbnails',
            items : sync2.data('items'),
            itemsCustom : [[991,sync2.data('items')], [768, sync2.data('items')], [480, sync2.data('items')]],
            navigation: true,
            navigationText: false,
            pagination:false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });

        sync2.on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });

        function syncPosition(el){
            var current = this.currentItem;

            sync2
                .find(".owl-item")
                .removeClass("synced")
                .eq(current)
                .addClass("synced");
            if(sync2.data("owlCarousel") !== undefined){
                center(current)
            }
        }
        function center(number){
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

            var num = number;
            var found = false;

            for(var i in sync2visible){
                if(num === sync2visible[i]){
                    var found = true;
                }
            }

            if(found===false){
                if(num>sync2visible[sync2visible.length-1]){
                    sync2.trigger("owl.goTo", num - sync2visible.length+2)
                }else{
                    if(num - 1 === -1){
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if(num === sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if(num === sync2visible[0]){
                sync2.trigger("owl.goTo", num-1)
            }
        }


    }
    /* ---------------------------------------------
     Init Revolution
     --------------------------------------------- */

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
            disableProgressBar:"off",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            startWithSlide:0,
            debugMode:false,
            fallbacks: {
                simplifyAll:"off",
                nextSlideOnWindowFocus:"off",
                disableFocusListener:false
            }
        });

        $("#rev_slider_3").show().revolution({
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
                    style:"site-nav",
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
                    style:"site-pagination",
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
            disableProgressBar:"off",
            hideThumbsOnMobile:"off",
            hideSliderAtLimit:0,
            hideCaptionAtLimit:0,
            hideAllCaptionAtLilmit:0,
            startWithSlide:0,
            debugMode:false,
            fallbacks: {
                simplifyAll:"off",
                nextSlideOnWindowFocus:"off",
                disableFocusListener:false
            }
        });


        $("#rev_slider_2_1").show().revolution({
            sliderType:"standard",
            jsFileLocation:"assets/libs/revolution/js/",
            sliderLayout:"auto",
            dottedOverlay:"none",
            delay:6000,
            navigation: {
                keyboardNavigation:"off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation:"off",
                onHoverStop:"on",
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
                    hide_onleave:false,
                    tmp:'',
                    left: {
                        h_align:"right",
                        v_align:"top",
                        h_offset:-90,
                        v_offset:30
                    },
                    right: {
                        h_align:"right",
                        v_align:"top",
                        h_offset:-90,
                        v_offset:-30
                    }
                }
            },
            gridwidth:710,
            gridheight:440,
            lazyType:"smart",
            parallax: {
                type:"mouse",
                origo:"slidercenter",
                speed:2000,
                levels:[2,3,4,5,6,7,12,16,10,50],
            },
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

    /* ---------------------------------------------
     Grid list Toggle
     --------------------------------------------- */
    function init_gridlistToggle(){
        $('ul.grid-list a').on('click', function(e){
            e.preventDefault();
            var $this = $(this),
                $gridlist = $this.closest('.grid-list'),
                $products = $this.closest('#main').find('.products');
                
            $gridlist.find('a').removeClass('active');
            $this.addClass('active');
            $products
                .removeClass($this.data('remove'))
                .addClass($this.data('layout'));
                
        });
    }

})(jQuery); // End of use strict