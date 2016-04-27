<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



add_action( 'vc_after_init', 'kt_add_option_to_vc' );
function kt_add_option_to_vc() {


    $image_styles = WPBMap::getParam( 'vc_single_image', 'style' );
    $image_styles['value'][esc_html__( 'Border box inner 1', 'delphinus' )] = 'border-box-1';
    $image_styles['value'][esc_html__( 'Border box inner 2', 'delphinus' )] = 'border-box-2';

    $image_styles['value'][esc_html__( 'Zoom In', 'delphinus' )] = 'zoomin';
    $image_styles['value'][esc_html__( 'Zoom Out', 'delphinus' )] = 'zoomout';
    $image_styles['value'][esc_html__( 'Slide', 'delphinus' )] = 'slide';
    $image_styles['value'][esc_html__( 'Shine', 'delphinus' )] = 'shine';

    vc_update_shortcode_param( 'vc_single_image', $image_styles );

}

function kt_add_visibility_shortcode($class, $base, $atts){
    if(isset($atts['visibility'])){
        $class .= ' '.$atts['visibility'];
    }
    return $class;
}
add_filter('vc_shortcodes_css_class', 'kt_add_visibility_shortcode', 20, 3);

