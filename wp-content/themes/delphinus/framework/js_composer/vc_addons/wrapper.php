<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_KT_Wrapper extends WPBakeryShortCodesContainer {
    protected function content($atts, $content = null)
    {
        $atts = shortcode_atts( array(
            'max_width' => 950,
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'kt-wrapper', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div class="'.esc_attr( $elementClass ).'" style="max-width: '.$max_width.'px;">'. do_shortcode($content) .'</div>';

    }
}


//Register "container" content element. It will hold all your inner (child) content elements
vc_map( array(
    "name" => esc_html__("KT: Wrapper", 'wingman'),
    "base" => "kt_wrapper",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    //"as_parent" => array('only' => 'kt_heading'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    'is_container' => true,
    "content_element" => true,
    "show_settings_on_create" => false,
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Max width", 'wingman'),
            "param_name" => "max_width",
            "value" => 950,
            "suffix" => esc_html__("px", 'wingman'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
            'param_name' => 'css_animation',
            'admin_label' => true,
            'value' => array(
                esc_html__( 'No', 'js_composer' ) => '',
                esc_html__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
                esc_html__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
                esc_html__( 'Left to right', 'js_composer' ) => 'left-to-right',
                esc_html__( 'Right to left', 'js_composer' ) => 'right-to-left',
                esc_html__( 'Appear from center', 'js_composer' ) => "appear"
            ),
            'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
        ),
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => esc_html__( 'Design options', 'js_composer' )
        ),
    ),
));