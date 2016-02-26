(function($){
    "use strict"; // Start of use strict












    init_wc_grid_list();
    init_wc_currency();
    init_wc_quantily();
    init_wc_carousel();


    /* ---------------------------------------------
     Grid list Toggle
     --------------------------------------------- */
    function init_wc_grid_list(){
        $('ul.gridlist-toggle a').on('click', function(e){
            e.preventDefault();
            var $this = $(this),
                $gridlist = $this.closest('.gridlist-toggle'),
                $products = $this.closest('#main').find('ul.shop-products');

            var data = {
                action: 'frontend_update_posts_layout',
                security : ajax_frontend.security,
                layout: $this.data('layout')
            };

            //$.post(ajax_frontend.ajaxurl, data, function(response) { });

            $gridlist.find('a').removeClass('active');
            $this.addClass('active');
            $products
                .removeClass($this.data('remove'))
                .addClass($this.data('layout'));

        });
    }


    function init_wc_currency(){
        if(typeof woocs_drop_down_view !== "undefined") {
            $('.currency-switcher-content a').on('click', function(e){
                e.preventDefault();
                woocs_redirect($(this).data('currency'));
            });
        }
    }


    $('.product-main-images').magnificPopup({
        delegate: 'a.woocommerce-main-image',
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    init_wc_product_carousel($("#sync1"), $("#sync2"));

    /* ---------------------------------------------
     Single Product
     --------------------------------------------- */


    function init_wc_product_carousel(sync1, sync2){

        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            items : 1,
            navigation: true,
            pagination: false,
            afterAction : syncPosition,
            autoHeight: true,
            responsiveRefreshRate : 200,
            navigationText: ['<i class="arrow_carrot-left"></i>','<i class="arrow_carrot-right"></i>'],
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
     Woocommercer Quantily
     --------------------------------------------- */
    function init_wc_quantily(){
        $('body').on('click','.qty-plus',function(e){
            e.preventDefault();
            var obj_qty = $(this).closest('.quantity').find('input.qty'),
                val_qty = parseInt(obj_qty.val());
            if(isNaN(val_qty)){
                val_qty = 0;
            }
            var max_qty = parseInt(obj_qty.attr('max')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty + step_qty;
            if(max_qty && val_qty > max_qty){ val_qty = max_qty; }
            obj_qty.val(val_qty);
        });
        $('body').on('click','.qty-minus',function(e){
            e.preventDefault();
            var obj_qty = $(this).closest('.quantity').find('input.qty'),
                val_qty = parseInt(obj_qty.val());
            if(isNaN(val_qty)){
                val_qty = 0;
            }
            var min_qty = parseInt(obj_qty.attr('min')),
                step_qty = parseInt(obj_qty.attr('step'));
            val_qty = val_qty - step_qty;
            if(min_qty && val_qty < min_qty){ val_qty = min_qty; }
            if(!min_qty && val_qty < 0){ val_qty = 0; }
            obj_qty.val(val_qty);
        });
    }


    $( 'body' )
        .on('click', '.add_to_cart_button', function() {
            var $this = $(this).addClass('wc-loading');
            $('i', $this).attr('class', 'icon_loading fa-spin');
        })
        .on('click', '.yith-wcwl-add-button', function() {
            var $this = $(this).addClass('wc-wishlist-loading');
            $('i', $this).attr('class', 'icon_loading fa-spin');
        })
        .on('added_to_cart', function(e, data) {
            var $button_product = $('.wc-loading'),
                $parent = $button_product.parent();

            $('i', $button_product).attr('class', 'icon_check');

            $parent.tooltip('hide')
                .attr('title', $parent.data('added'))
                .tooltip('fixTitle');

            setTimeout(function() {
                $parent.tooltip('show');
            }, 200);
        })
        .on( 'added_to_wishlist removed_from_wishlist', function() {


            var $button_product = $('.wc-wishlist-loading'),
                $parent = $button_product.closest('.yith-wcwl-add-to-wishlist');

            $parent.tooltip('hide')
                .attr('title', $parent.data('added'))
                .tooltip('fixTitle');

            setTimeout(function() {
                $parent.tooltip('show');
            }, 200);

            var data = {
                action: 'fronted_get_wishlist',
                security : ajax_frontend.security
            };
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                $('.shopping-bag-wishlist').html(response.html);
                $('.shopping-bag-wishlist .cart_list.product_list_widget').mCustomScrollbar();

            }, 'json');
        })
        .on('wc_fragments_loaded wc_fragments_refreshed added_to_cart added_to_wishlist', function (){
            $('.shopping-bag .cart_list.product_list_widget').mCustomScrollbar();
        });






    /*

    $( 'body' ).on('click','.shopping-bag a.remove',function( e){

        e.preventDefault();

        var product_id = $(this).data('product_id'),
            remove_item = $(this).data('itemkey');

        $('.shopping_cart .shopping-bag').append('<span class="loading_overlay"><i class="fa fa-spinner fa-pulse"></i></span>');

        var data = {
            action: 'fronted_remove_product',
            security : ajax_frontend.security,
            product_id : product_id,
            remove_item : remove_item
        };

        $.get(ajax_frontend.ajaxurl, data, function(response) {
            console.log(response);
        }, 'json');

    });
    */











    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_wc_carousel(){
        $('.wc-carousel-wrapper').each(function(){

            var wooCarousel = $(this),
                objCarousel = wooCarousel.find('ul.shop-products'),
                objParent = objCarousel.closest('.owl-carousel-kt'),
                options = $(wooCarousel).data('options') || {},
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
                console.log(options);
                objCarousel.owlCarousel(options);
            });
        });
    }






})(jQuery); // End of use strict