<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_KT_Message extends WPBakeryShortCode {
    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
            'title' => '',
            "type" => 'normal',
            "close" => 'false',
            'style' => 'classic',
            'el_class' => '',
        ), $atts));

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'alert ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'type' => 'alert-'.$type,
            'style' => 'alert-style-'.$style
        );
        if($close == 'true'){
            $elementClass['dismissible'] = 'alert-dismissible fade in';
        }
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );


        $output = '';
        $output .= '<div class="'.esc_attr( $elementClass ).'" role="alert">';
        if($close == 'true'){
            $output .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>';
        }

        if($title){
            $output .= '<h3 class="alert_title">'.$title.'</h3>';
        }
        $output .= $content;

        $output .= '</div><!-- .alert -->';

        return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(

    "name" => esc_html__( "KT: Message Box", 'delphinus'),
    "category" => esc_html__('by Kite-Themes', 'delphinus' ),
    "base" => "kt_message",
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => __( 'Title', 'js_composer' ),
            'param_name' => 'title',
            "admin_label" => true,
        ),
        array(
            'type' => 'textarea_html',
            'holder' => 'div',
            'heading' => __( 'Text', 'js_composer' ),
            'param_name' => 'content',
            'value' => __( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'js_composer' )
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Type",'delphinus'),
            "param_name" => "type",
            "value" => array(
                __('Normal', 'delphinus') => 'normal',
                __('Success', 'delphinus') => 'success',
                __('Info', 'delphinus') => 'info',
                __('Warning', 'delphinus') => 'warning',
                __('Danger', 'delphinus') => 'danger',
            ),
            "description" => __("",'delphinus'),
            "admin_label" => true,
        ),

        array(
            "type" => "dropdown",
            "heading" => __("Style",'delphinus'),
            "param_name" => "style",
            "value" => array(
                __('Classic', 'delphinus') => 'classic',
                __('Modern', 'delphinus') => 'modern',
            ),
            "admin_label" => true,
            "description" => __("",'delphinus')
        ),
        array(
            'type' => 'kt_switch',
            'heading' => __( 'Close button', 'delphinus' ),
            'param_name' => 'close',
            'value' => 'false',
            "description" => __("Close button in alert", 'delphinus')
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
    ),
));