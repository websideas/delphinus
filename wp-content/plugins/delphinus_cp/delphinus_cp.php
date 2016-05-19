<?php
/*
Plugin Name:  Delphinus Custom Post & Shortcode
Plugin URI:   http://kitethemes.com/
Description:  Theme Delphinus Custom Post & Shortcode
Version:      1.0
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
        'supports' 	=> array('title', 'thumbnail', 'page-attributes'),
        'menu_icon' => 'dashicons-universal-access-alt',
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
        'menu_icon' => 'dashicons-format-chat',
        'supports' 	=> array('title', 'editor', 'thumbnail', 'page-attributes'),
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

add_action( 'init', 'kt_register_employees_init' );
function kt_register_employees_init(){
    $labels = array(
        'name' => __( 'Employees', 'delphinus_cp'),
        'singular_name' => __( 'Testimonial', 'delphinus_cp'),
        'add_new' => __( 'Add New', 'delphinus_cp'),
        'all_items' => __( 'All Employees', 'delphinus_cp'),
        'add_new_item' => __( 'Add New Employees', 'delphinus_cp'),
        'edit_item' => __( 'Edit employees', 'delphinus_cp'),
        'new_item' => __( 'New employees', 'delphinus_cp'),
        'view_item' => __( 'View employees', 'delphinus_cp'),
        'search_items' => __( 'Search employees', 'delphinus_cp'),
        'not_found' => __( 'No employees found', 'delphinus_cp'),
        'not_found_in_trash' => __( 'No employees found in Trash', 'delphinus_cp'),
        'parent_item_colon' => __( 'Parent employees', 'delphinus_cp'),
        'menu_name' => __( 'Employees', 'delphinus_cp')
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'supports' 	=> array('title', 'thumbnail', 'page-attributes'),
        'rewrite' => array('slug' => 'team'),
        'menu_icon' => 'dashicons-groups'
    );
    register_post_type( 'kt_employees', $args );

    register_taxonomy('employees-category',array('kt_employees'), array(
        "label" 						=> __("Employees Categories", 'delphinus_cp'),
        "singular_label" 				=> __("Employees Category", 'delphinus_cp'),
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

    add_action( 'do_meta_boxes', 'remove_revolution_slider_meta_boxes' );
    function remove_revolution_slider_meta_boxes() {
        remove_meta_box( 'mymetabox_revslider_0', 'kt_testimonial', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'kt_client', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'kt_employees', 'normal' );
    }


    add_action( 'admin_init', 'kt_tinymce_shortcode_button' );
    function kt_tinymce_shortcode_button() {
        if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
            add_filter( 'mce_buttons', 'kt_register_tinymce_button' );
            add_filter( 'mce_external_plugins', 'kt_add_tinymce_shortcode_button' );
        }
    }

    function kt_register_tinymce_button( $buttons ) {
        array_push( $buttons, "kt_shortcode" );
        return $buttons;
    }

    function kt_add_tinymce_shortcode_button( $plugin_array ) {
        $plugin_array['shortcode_button_script'] = plugins_url('assets/js/tinymce.editor.plugin.js', __FILE__) ;
        return $plugin_array;
    }


}


class KT_Shortcodes
{

    public function __construct() {


        add_shortcode('kt_dropcaps', array($this, 'kt_dropcaps'));
        add_shortcode('kt_tooltip', array($this, 'kt_tooltip'));
        add_shortcode('kt_highlight', array($this, 'kt_highlight'));

    }

    public function kt_dropcaps( $atts, $content )
    {
        //normal, round, circle, square
        $atts = shortcode_atts( array(
            'size' => 'md',
            'background' => '',
            'text' => '#ed8b5c',
            'shapes' => 'normal'
        ), $atts );

        extract( $atts );


        if(!$content){
            return;
        }

        $elementClass = array(
            'class' => 'kt_dropcap',
            'size' => 'dropcap-'.$size,
            'shapes' => 'dropcap-'.$shapes,
        );


        $style_title = '';


        if($background){
            $styles[] = 'background: '.$background;
        }

        if($text){
            $styles[] = 'color: '.$text;
        }

        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        return '<span class="'.$elementClass.'" '.$style_title.'>'.$content.'</span>';
    }


    function kt_tooltip( $atts ){
        $atts = shortcode_atts( array(
            'tooltip_text' => esc_html__('Tooltip Text', 'delphinus'),
            'text' => esc_html__('Text', 'delphinus'),
            'href' => '#',
        ), $atts );
        extract( $atts );

        $elementClass = array(
            'class' => 'kt_tooltip',
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        return sprintf('<a href="%s" data-toggle="tooltip" title="%s" class="%s">%s</a>', esc_url($href), esc_attr($tooltip_text), $elementClass, $text);
    }


    function kt_highlight( $atts ){
        $atts = shortcode_atts( array(
            'background' => '',
            'text_color' => 'white',
            'text' => esc_html__('Text', 'delphinus')
        ), $atts );
        extract( $atts );

        $elementClass = array(
            'class' => 'kt_highlight'
        );

        $style_title = '';


        if($background){
            $styles[] = 'background: '.$background;
        }

        if($text_color){
            $styles[] = 'color: '.$text_color;
        }

        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        return '<span class="'.$elementClass.'" '.$style_title.'>'.$text.'</span>';
    }

}

$kt_shortcodes = new KT_Shortcodes();