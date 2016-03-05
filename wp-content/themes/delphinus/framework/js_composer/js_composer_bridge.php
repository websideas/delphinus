<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

//  0 - unsorted and appended to bottom Default  
//  1 - Appended to top)


vc_add_params("vc_icon", array(
    array('type' => 'hidden',  'param_name' => 'icon_class'),
    array('type' => 'hidden',  'param_name' => 'color_hover'),
    array('type' => 'hidden',  'param_name' => 'hover_div'),
    array('type' => 'hidden',  'param_name' => 'background_color_hover'),
    array('type' => 'hidden',  'param_name' => 'iconbox_image'),
    array('type' => 'hidden',  'param_name' => 'icon_type')
));

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


vc_add_params("vc_custom_heading", array(
    array(
        "type" => "dropdown",
        "heading" => __("Custom Style", 'wingman'),
        "param_name" => "custom_style",
        "value" => array(
            esc_html__('Default', 'mondova') => '',
            esc_html__('Style 1', 'mondova') => '1',
            esc_html__('Style 2', 'mondova') => '2',
        ),
        'group' => __( 'Extra', 'js_composer' )
    )
));


/*
$composer_addons = array(
    //'dropcap.php',
    'blockquote.php',
    'googlemap.php',
    'socials.php',
    'gallery-grid.php',
    'gallery_fullwidth.php',
    'gallery-justified.php'
);
*/
$composer_addons = array(
    'heading.php',
    'icon_box.php',
    'blog_posts.php',
);

if(kt_is_wc()){
    $composer_wc_addons = array(
        'products_tab.php',
        'products_widget_carousel.php',
        'products_carousel.php'
    );
    $composer_addons = array_merge($composer_wc_addons, $composer_addons);
}

foreach ( $composer_addons as $addon ) {
	require_once( KT_FW_DIR . 'js_composer/vc_addons/' . $addon );
}