<?php
/*
Plugin Name:  Delphinus Custom Post
Plugin URI:   http://kitethemes.com/
Description:  Theme Delphinus Custom Post
Version:      1.1
Author:       KiteThemes
Author URI:   http://themeforest.net/user/kite-themes

Copyright (C) 2014-2015, by Cuongdv
All rights reserved.
*/


add_action( 'init', 'kt_register_client_init' );
function kt_register_client_init(){
    $labels = array( 
        'name' => __( 'Client', 'delphinus_cp'),
        'singular_name' => __( 'Client', 'delphinus_cp'),
        'add_new' => __( 'Add New', 'delphinus_cp'),
        'all_items' => __( 'All Clients', 'delphinus_cp'),
        'add_new_item' => __( 'Add New Client', 'delphinus_cp'),
        'edit_item' => __( 'Edit Client', 'delphinus_cp'),
        'new_item' => __( 'New Client', 'delphinus_cp'),
        'view_item' => __( 'View Client', 'delphinus_cp'),
        'search_items' => __( 'Search Client', 'delphinus_cp'),
        'not_found' => __( 'No Client found', 'delphinus_cp'),
        'not_found_in_trash' => __( 'No Client found in Trash', 'delphinus_cp'),
        'parent_item_colon' => __( 'Parent Client', 'delphinus_cp'),
        'menu_name' => __( 'Clients', 'delphinus_cp')
    );
    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array('title', 'thumbnail'),
    );
    register_post_type( 'kt_client', $args );
    
    register_taxonomy('client-category',array('kt_client'), array(
        "label" 						=> __("Client Categories", 'delphinus_cp'),
        "singular_label" 				=> __("Client Category", 'delphinus_cp'),
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
}


add_action( 'init', 'kt_register_testimonial_init' );
function kt_register_testimonial_init(){
    $labels = array(
        'name' => __( 'Testimonial', 'delphinus_cp'),
        'singular_name' => __( 'Testimonial', 'delphinus_cp'),
        'add_new' => __( 'Add New', 'delphinus_cp'),
        'all_items' => __( 'Testimonials', 'delphinus_cp'),
        'add_new_item' => __( 'Add New testimonial', 'delphinus_cp'),
        'edit_item' => __( 'Edit testimonial', 'delphinus_cp'),
        'new_item' => __( 'New testimonial', 'delphinus_cp'),
        'view_item' => __( 'View testimonial', 'delphinus_cp'),
        'search_items' => __( 'Search testimonial', 'delphinus_cp'),
        'not_found' => __( 'No testimonial found', 'delphinus_cp'),
        'not_found_in_trash' => __( 'No testimonial found in Trash', 'delphinus_cp'),
        'parent_item_colon' => __( 'Parent testimonial', 'delphinus_cp'),
        'menu_name' => __( 'Testimonials', 'delphinus_cp')
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'supports' 	=> array('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'kt_testimonial', $args );
    
    register_taxonomy('testimonial-category',array('kt_testimonial'), array(
        "label" 						=> __("Testimonial Categories", 'delphinus_cp'), 
        "singular_label" 				=> __("Testimonial Category", 'delphinus_cp'), 
        'public'                        => false,
        'hierarchical'                  => true,
        'show_ui'                       => true,
        'show_in_nav_menus'             => false,
        'args'                          => array( 'orderby' => 'term_order' ),
        'rewrite'                       => false,
        'query_var'                     => true,
        'show_admin_column'             => true
    ));
}



/**
 * Remove Rev Slider Metabox
 */
if ( is_admin() ) {

    function remove_revolution_slider_meta_boxes() {
        remove_meta_box( 'mymetabox_revslider_0', 'kt_testimonial', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'kt_client', 'normal' );
    }
    add_action( 'do_meta_boxes', 'remove_revolution_slider_meta_boxes' );

}