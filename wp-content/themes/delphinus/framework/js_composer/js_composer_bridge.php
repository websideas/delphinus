<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)


$visibilities_arr = array('vc_empty_space', 'kt_heading');
foreach($visibilities_arr as $item){
    vc_add_param($item, array(
        "type" => "dropdown",
        "heading" => esc_html__("Visibility",'mondova'),
        "param_name" => "visibility",
        "value" => array(
            esc_html__('Always Visible', 'mondova') => '',
            esc_html__('Visible on Phones', 'mondova') => 'visible-xs-block',
            esc_html__('Visible on Tablets', 'mondova') => 'visible-sm-block',
            esc_html__('Visible on Desktops', 'mondova') => 'visible-md-block',
            esc_html__('Visible on Desktops Large', 'mondova') => 'visible-lg-block',

            esc_html__('Hidden on Phones', 'mondova') => 'hidden-xs',
            esc_html__('Hidden on Tablets', 'mondova') => 'hidden-sm',
            esc_html__('Hidden on Desktops', 'mondova') => 'hidden-md',
            esc_html__('Hidden on Desktops Large', 'mondova') => 'hidden-lg',
        ),
        "admin_label" => true,
    ));
}

$background_arr = array('vc_row', 'vc_column');
foreach($background_arr as $item) {
    vc_add_param($item, array(
        "type" => "dropdown",
        "class" => "",
        "heading" => "Background position",
        "param_name" => "background_position",
        "value" => array(
            '' => 'None',
            "center center" => "center center",
            "center top" => "center top",
            "center bottom" => "center bottom",
            "center right" => "center right",
            "center left" => "center left",
        ),
    ));
}

/*
$composer_addons = array(
    'blockquote.php',
    'googlemap.php',
    'socials.php',
);
*/


$composer_addons = array(
    'heading.php',
    'icon_box.php',
    'blog_posts.php',
    'banner.php',
    'clients_carousel.php',
    'wrapper.php'
);

if(kt_is_wc()){
    $composer_wc_addons = array(
        'products_tab.php',
        'products_widget_carousel.php',
        'products_carousel.php',
        'product_categories_carousel.php',
        'product_categories_grid.php',
        'products.php'
    );
    $composer_addons = array_merge($composer_wc_addons, $composer_addons);
}

foreach ( $composer_addons as $addon ) {
	require_once( KT_FW_DIR . 'js_composer/vc_addons/' . $addon );
}