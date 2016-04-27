<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );
class WPBakeryShortCode_Banner extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {

        $atts = shortcode_atts(array(
            'title' => '',
            'image' => '',
            'link' => '',
            'img_size' => 'thumbnail',
            'align' => 'center',
            'style' => '1',
            'overlay' => '',
            'position' => 'middle',
            'font_container' => '',
            'use_theme_fonts' => 'yes',
            'google_fonts' => '',

            'css_animation' => '',
            'el_class' => '',
            'css'      => '',
        ), $atts);

        // This is needed to extract $font_container_data and $google_fonts_data
        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);


        $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
        extract( $atts );

        extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );

        $settings = get_option( 'wpb_js_google_fonts_subsets' );
        if ( is_array( $settings ) && ! empty( $settings ) ) {
            $subsets = '&subset=' . implode( ',', $settings );
        } else {
            $subsets = '';
        }

        if ( isset( $google_fonts_data['values']['font_family'] ) ) {
            wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
        }

        if ( ! empty( $styles ) ) {
            $style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        } else {
            $style = '';
        }

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'banner ', $this->settings['base'], $atts ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
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

        if($title){
            $content = sprintf('<%1$s class="banner-title" %2$s><span>%3$s</span></%1$s>', $font_container_data['values']['tag'], $style, $title).$content;
        }

        $output = $img['thumbnail'];
        $output .= sprintf('<div class="banner-content">%s</div>', $content);

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
    "name" => esc_html__( "KT: Banner", 'delphinus'),
    "base" => "banner",
    "category" => esc_html__('by Kite-Themes', 'delphinus' ),
    "description" => esc_html__( "", 'delphinus'),

    "params" => array(
        array(
            "type" => "textfield",
            'heading' => esc_html__( 'Title', 'js_composer' ),
            'param_name' => 'title',
            'value' => esc_html__( 'Title', 'js_composer' ),
            "admin_label" => true,
        ),
        array(
            "type" => "textarea_html",
            "heading" => esc_html__("Content", 'delphinus'),
            "param_name" => "content",
            "description" => esc_html__("", 'delphinus'),
            'holder' => 'div',
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Link Url', 'js_composer' ),
            'param_name' => 'link',
        ),

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image', 'delphinus' ),
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
            'heading' => esc_html__( 'Image overlay', 'delphinus' ),
            'param_name' => 'overlay',
            'value' => array(
                esc_html__( 'Default', 'delphinus' ) => '',
                esc_html__( 'Dark (15%)', 'delphinus' ) => 'dark',
                esc_html__( 'Dark (40%)', 'delphinus' ) => 'dark2',
                esc_html__( 'Darker (60%)', 'delphinus' ) => 'dark3',
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
        vc_map_add_css_animation(),
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        // Typography setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Typography heading", 'delphinus'),
            "param_name" => "typography_heading",
            'group' => esc_html__( 'Typography', 'delphinus' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'tag' => 'h3',
                    'color',
                    'font_size',
                    'line_height',
                    'tag_description' => esc_html__( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => esc_html__( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => esc_html__( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => esc_html__( 'Enter line height.', 'js_composer' ),
                    'color_description' => esc_html__( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'group' => esc_html__( 'Typography', 'delphinus' ),
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts',
            'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => esc_html__( 'Use font family from the theme.', 'js_composer' ),
            'group' => esc_html__( 'Typography', 'delphinus' ),
            'std' => 'yes'
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => 'font_family:Oswald|font_style:700%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => esc_html__( 'Select font family.', 'js_composer' ),
                    'font_style_description' => esc_html__( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => esc_html__( 'Typography', 'delphinus' ),
            'dependency' => array(
                'element' => 'use_theme_fonts',
                'value_not_equal_to' => 'yes',
            ),
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