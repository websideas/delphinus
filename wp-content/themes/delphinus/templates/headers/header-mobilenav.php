<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if ( has_nav_menu( 'primary' ) ) {

    $search_html = $search = $user_html = $wishlist_html = '';

    if ( kt_option('header_search', 1) ) {
        if(kt_is_wc()){
            $search = get_product_search_form(false);
        }else{
            $search = get_search_form(false);
        }
        $search_html = sprintf('<li class="menu-item menu-item-search-form">%s</li>', $search);
    }

    if ( kt_is_wc()){
        $text = (is_user_logged_in ()) ? esc_html__('My Account', 'delphinus') : esc_html__('Login', 'delphinus');
        $user_html = sprintf(
            '<li class="menu-item menu-item-myaccount"><a href="%s">%s</a>',
            get_permalink( get_option('woocommerce_myaccount_page_id') ),
            $text
        );

        if ( defined( 'YITH_WCWL' ) ) {
            global $yith_wcwl;
            $wishlist = sprintf(
                '<a href="%s">%s</a>',
                esc_url( $yith_wcwl->get_wishlist_url() ),
                esc_html__('wishlist', 'delphinus')
            );
            $wishlist_html = sprintf('<li class="menu-item menu-item-wishlist">%s</li>', $wishlist);
        }
    }

    wp_nav_menu( array(
        'theme_location'    => 'primary',
        'container'         => 'nav',
        'container_class'   => 'main-nav-mobile',
        'container_id'      => 'main-nav-mobile',
        'menu_class'        => 'menu navigation-mobile',
        'link_before'       => '<span>',
        'link_after'        => '</span>',
        'walker'            => new KTMegaWalker(),
        'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s'.$user_html.$wishlist_html.$search_html.'</ul>',
    ) );

}