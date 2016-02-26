<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Banner extends WPBakeryShortCode {
    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
            'title' => '',
            'suffix' => '',
            'prefix' => '',
            'image' => '',
            'link' => '',
            'img_size' => 'thumbnail',
            'align' => 'center',
            'el_class' => '',
            'css'      => '',
            'style' => '1',
            'overlay' => '',
            'position' => 'middle'
        ), $atts));

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'banner ', $this->settings['base'], $atts ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'extra' => $this->getExtraClass( $el_class ),
            'style' => 'style'.$style,
            'overlay' => 'banner-'.$overlay,
            'align' => 'banner-'.$align,
            'position' => 'position-'.$position
        );

        $banner_link = '';

        $img_id = preg_replace( '/[^\d]/', '', $image );
        $img = wpb_getImageBySize( array(
            'attach_id' => $img_id,
            'thumb_size' => $img_size,
            'class' => 'img-responsive',
        ) );
        if ( $img == null ) {
            $img['thumbnail'] = '<img class="vc_img-placeholder img-responsive" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
        }

        $output = $img['thumbnail'];

        $suffix = ($suffix) ? '<p class="banner-suffix">'.$suffix.'</p>' : '';
        $prefix = ($prefix) ? '<p class="banner-prefix">'.$prefix.'</p>' : '';

        $output .= sprintf('<div class="banner-content">%s<h3 class="banner-title">%s</h3>%s</div>', $suffix, $title, $prefix);

        if($link){
            $link = vc_build_link( $link );
            $a_href = $link['url'];
            $a_title = $link['title'];
            $a_target = $link['target'];
            $icon_box_link = array('href="'.esc_attr( $a_href ).'"', 'title="'.esc_attr( $a_title ).'"', 'target="'.esc_attr( $a_target ).'"' );
            $banner_link = '<a class="banner-link" '.implode(' ', $icon_box_link).'></a>';
        }

        $output .= $banner_link;


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        return '<div class="'.esc_attr( $elementClass ).'">'.$output.'</div>';

    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => esc_html__( "KT: Banner", 'wingman'),
    "base" => "banner",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    "description" => esc_html__( "", 'wingman'),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => esc_html__( 'Title', 'js_composer' ),
            'param_name' => 'title',
            'value' => esc_html__( 'Title', 'js_composer' ),
            "admin_label" => true,
        ),

        array(
            "type" => "textfield",
            'heading' => __( 'Title suffix', '' ),
            'param_name' => 'suffix',
            "description" => __( "Enter suffix for title" , 'mondova'),
        ),
        array(
            "type" => "textfield",
            'heading' => __( 'Title prefix', 'mondova' ),
            'param_name' => 'prefix',
            "description" => __( "Enter prefix for title" , 'mondova'),
        ),

        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Link Url', 'js_composer' ),
            'param_name' => 'link',
        ),

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image', 'wingman' ),
            'param_name' => 'image',
            'description' => esc_html__( 'Select image from media library.', 'js_composer' ),
        ),

        array(
            'type' => 'textfield',
            'heading' => __( 'Image size', 'js_composer' ),
            'param_name' => 'img_size',
            'value' => 'thumbnail',
            'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'js_composer' ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Image overlay', 'wingman' ),
            'param_name' => 'overlay',
            'value' => array(
                esc_html__( 'Default', 'wingman' ) => '',
                esc_html__( 'Dark (15%)', 'wingman' ) => 'dark',
                esc_html__( 'Dark (35%)', 'wingman' ) => 'dark2',
                esc_html__( 'Darker (50%)', 'wingman' ) => 'dark3',
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Banner Style', 'wingman' ),
            'param_name' => 'style',
            'value' => array(
                esc_html__( 'Style 1', 'wingman' ) => '1',
                esc_html__( 'Style 2', 'wingman' ) => '2',
            ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Content Alignment', 'js_composer' ),
            'param_name' => 'align',
            'value' => array(
                esc_html__( 'Center', 'js_composer' ) => 'center',
                esc_html__( 'Left', 'js_composer' ) => 'left',
                esc_html__( 'Right', 'js_composer' ) => "right"
            ),
            'std' => 'center',
            'description' => esc_html__( 'Select content alignment within banner.', 'js_composer' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Content Position', 'js_composer' ),
            'param_name' => 'position',
            'value' => array(
                esc_html__( 'Top', 'js_composer' ) => 'top',
                esc_html__( 'Middle', 'js_composer' ) => 'middle',
                esc_html__( 'Bottom', 'js_composer' ) => "bottom"
            ),
            'std' => 'middle',
            'description' => esc_html__( 'Select content position within banner.', 'js_composer' )
        ),

        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),

        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'CSS box', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            'group' => esc_html__( 'Design Options', 'js_composer' )
        )
    ),
));