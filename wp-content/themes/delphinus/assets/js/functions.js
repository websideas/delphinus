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

        $(window).trigger("scroll");
        $(window).trigger("resize");

    });

    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    $(window).resize(function(){


        /**==============================
         ***  Sticky header
         ===============================**/




        if ($.fn.ktSticky) {
            $('.sticky-header').ktSticky({
                contentSticky : ''
            });
        }

        /**==============================
         ***  Disable mobile menu in desktop
         ===============================**/
        if ($(window).width() >= 1200) {
            $('body').removeClass('opened-nav-animate');
            $('#hamburger-icon').removeClass('active');
        }



        $('.blog-posts-masonry').each(function(){
            var $masonry = $(this);
            $masonry.imagesLoaded(function() {
                $masonry.find('.row').isotope({
                    itemSelector: '.blog-post-wrap',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.blog-post-sizer'
                    }
                })
            });
        });


    });



    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    //init_MainMenu();
    init_carousel();
    init_shortcodes();
    init_backtotop();


    $('.social_icons').on('hover', 'li', function(){
        var $this= $(this);

        $this.siblings().removeClass('active');
        $this.addClass('active');
    });


    /* ---------------------------------------------
     Back to top
     --------------------------------------------- */
    function init_backtotop(){
        var $backtotop = $('#back-to-top');
        $backtotop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0},500);
        });
    }


    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){
        $('.kt-owl-carousel').each(function(){

            var objCarousel = $(this),
                objParent = objCarousel.closest('.owl-carousel-kt'),
                options = $(objCarousel).data('options') || {},
                func_cb;
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
                options.navigationText = ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'];
            }
            if(typeof options.mobile !== "undefined"){
                options.itemsMobile = [479,options.mobile];
            }

            func_cb =  window[options.callback];

            options.afterInit  = function(elem) {

                if(objParent.hasClass('navigation-top')){
                    var $buttons = elem.find('.owl-buttons');
                    $buttons.prependTo(objCarousel.closest('.owl-carousel-kt'));
                }

                if(typeof options.pagbefore !== "undefined" && options.pagination){
                    var $pagination = elem.find('.owl-pagination');
                    $pagination.prependTo(objCarousel.closest('.owl-carousel-kt'));
                }
                if( typeof func_cb === 'function'){
                    func_cb( 'afterInit',   elem );
                }
            };
            options.afterUpdate = function(elem){
                if( typeof func_cb === 'function'){
                    func_cb( 'afterUpdate',   elem );
                }
            };

            options.afterMove = function(elem){
                if( typeof func_cb === 'function'){
                    func_cb( 'afterMove',   elem );
                }
            };



            objCarousel.imagesLoaded(function() {
                //console.log(options);
                objCarousel.owlCarousel(options);
            });
        });
    }

    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes() {
        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').each(function(){
            var $this = $(this);
            if($this.closest('.product-effect-3').length){
                $this.tooltip({container:"body", delay: { "show": 100, "hide": 50 }, placement: "bottom"});
            }else{
                $this.tooltip({container:"body", delay: { "show": 100, "hide": 50 }});
            }

        });
        $(".entry-content").fitVids();

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




})(jQuery); // End of use strict

function wc_widget_carousel( _type, elem ){
    "use strict"; // Start of use strict
    if( _type == 'afterInit'){

        var $nav = elem.find('.owl-buttons'),
            $owlWrap = elem.closest('.owl-carousel-kt'),
            $heading = $owlWrap.find('.products-widget-wrap');
        $nav.prependTo($heading);

    }
}