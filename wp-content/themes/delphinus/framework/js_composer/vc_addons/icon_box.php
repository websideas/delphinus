<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );
class WPBakeryShortCode_Icon_Box extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {

        $atts = shortcode_atts( array(
            'title' => __( 'Title', 'js_composer' ),
            'link' => '',

            'use_theme_fonts' => 'true',
            'font_container' => '',
            'google_fonts' => '',
            'letter_spacing' => '0',

            'icon_type' => 'icon',
            'iconbox_icon' => 'fa fa-adjust',
            'iconbox_image' => '',

            'color' => '',
            'custom_color' => '',
            'size' => 'md',

            'align' => 'center',
            'icon_box_layout' => '1',

            'el_class' => '',
            'css_animation' => '',
            'css' => '',
        ), $atts );
        extract($atts);

        $custom_css = $output = $style_title = '';
        $uniqid = 'features-box-'.uniqid();

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'feature-box', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'layout' => 'layout-'.$icon_box_layout
        );

        extract( $this->getAttributes( $atts ) );
        unset($font_container_data['values']['text_align']);



        $styles = array();
        extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );

        $settings = get_option( 'wpb_js_google_fonts_subsets' );
        $subsets = '';
        if ( is_array( $settings ) && ! empty( $settings ) ) {
            $subsets = '&subset=' . implode( ',', $settings );
        }
        if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) ) {
            wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
        }
        if($letter_spacing){
            $styles[] = 'letter-spacing: '.$letter_spacing.'px;';
        }
        if ( ! empty( $styles ) ) {
            $style_title .= 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
        }


        $link = ( $link == '||' ) ? '' : $link;

        if($link){
            $link = vc_build_link( $link );
            $a_href = $link['url'];
            $a_title = $link['title'];
            $a_target = $link['target'];
            $icon_box_link = array('href="'.esc_attr( $a_href ).'"', 'title="'.esc_attr( $a_title ).'"', 'target="'.esc_attr( $a_target ).'"' );

            if($title){
                $style_link = '';
                if(isset($font_container_data['values']['color'])){
                    $style_link .= ' style="color: '.$font_container_data['values']['color'].'"';
                }
                $title = '<a '.implode(' ', $icon_box_link).$style_link.'>'.$title.'</a>';
            }
        }


        $icon_box_title = ($title) ? '<' . $font_container_data['values']['tag'] . ' class="feature-box-title" '.$style_title.'>'.$title.'</' . $font_container_data['values']['tag'] . '>' : '';
        $icon_box_content = ($content) ? '<div class="feature-box-content">'.$content.'</div>' : '';


        $icon_box_icon = '';

        if($icon_type == 'image'){
            $img_lightbox_id = preg_replace( '/[^\d]/', '', $iconbox_image );
            $img_lightbox = wp_get_attachment_image_src( $img_lightbox_id, 'full' );

            if(array($img_lightbox)){
                $icon_box_icon = sprintf('<img src="%s" class="img-responsive" alt="" />', $img_lightbox['0']);
            }
        }else{

            $icon_box_class = array('vc_icon_box size-'.$size);
            if($color != 'custom'){
                $icon_box_class[] = 'color-'.$color;
                $custom_color = kt_color2Hex($color);
            }

            $icon_box_style = 'style="color: '.$custom_color.'"';
            $icon_box_icon = sprintf('<span class="%s %s" %s></span>', $iconbox_icon, implode( ' ' , $icon_box_class), $icon_box_style);

        }

        if($icon_box_icon){
            $icon_box_icon = '<div class="feature-box-icon">'.$icon_box_icon.'</div>';
        }

        $output .= $icon_box_icon . $icon_box_title . $icon_box_content;


        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        return '<div id="'.$uniqid.'" class="'.esc_attr( $elementClass ).'">'.$output.$custom_css.'</div>';


    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => esc_html__( "KT: Icon Box", 'wingman'),
    "base" => "icon_box",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    "description" => esc_html__( "", 'wingman'),
    "wrapper_class" => "clearfix",
    "params" => array(
        array(
            "type" => "textfield",
            'heading' => esc_html__( 'Title', 'js_composer' ),
            'param_name' => 'title',
            "admin_label" => true,
        ),

        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Link Url', 'js_composer' ),
            'param_name' => 'link',
        ),
        array(
            "type" => "textarea_html",
            "heading" => esc_html__("Content", 'wingman'),
            "param_name" => "content",
            "value" => '',
            "description" => esc_html__("", 'wingman'),
            "holder" => "div",
        ),
        //Layout settings
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Layout icon box', 'wingman' ),
            'param_name' => 'icon_box_layout',
            'value' => array(
                esc_html__( 'Icon on Top of Title', 'wingman' ) => '1',
                esc_html__( 'Icon on Top of Title - Center', 'wingman' ) => '2'
            ),
            'description' => esc_html__( 'Select your layout.', 'wingman' ),
            "admin_label" => true,
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
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        //Icon settings
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon to display', 'wingman' ),
            'param_name' => 'icon_type',
            'value' => array(
                esc_html__( 'Font Icon', 'wingman' ) => 'icon',
                esc_html__( 'Image Icon', 'wingman' ) => 'image',
            ),
            'description' => esc_html__( 'Select your layout.', 'wingman' ),
            'group' => esc_html__( 'Icon', 'wingman' )
        ),

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image Thumbnail', 'wingman' ),
            'param_name' => 'iconbox_image',
            'dependency' => array( 'element' => 'icon_type',  'value' => array( 'image' ) ),
            'description' => esc_html__( 'Select image from media library.', 'js_composer' ),
            'group' => esc_html__( 'Icon', 'wingman' )
        ),

        array(
            "type" => "kt_icons",
            'heading' => esc_html__( 'Choose your icon', 'js_composer' ),
            'param_name' => 'iconbox_icon',
            "value" => 'fa fa-adjust',
            'description' => esc_html__( 'Use existing font icon or upload a custom image.', 'wingman' ),
            'dependency' => array("element" => "icon_type","value" => array('icon')),
            'group' => esc_html__( 'Icon', 'wingman' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon color', 'js_composer' ),
            'param_name' => 'color',
            'value' => array_merge( array( esc_html__( 'Default', 'js_composer' ) => 'default' ),  array( esc_html__( 'Accent color', 'wingman' ) => 'accent' ), getVcShared( 'colors' ), array( esc_html__( 'Custom color', 'js_composer' ) => 'custom' ) ),
            'description' => esc_html__( 'Select icon color.', 'js_composer' ),
            'param_holder_class' => 'vc_colored-dropdown',
            'group' => esc_html__( 'Icon', 'wingman' ),
            'dependency' => array("element" => "icon_type","value" => array('icon')),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Custom Icon Color', 'js_composer' ),
            'param_name' => 'custom_color',
            'description' => esc_html__( 'Select custom icon color.', 'js_composer' ),
            'dependency' => array(
                'element' => 'color',
                'value' => 'custom',
            ),
            'group' => esc_html__( 'Icon', 'wingman' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Size', 'js_composer' ),
            'param_name' => 'size',
            'value' => array_merge( getVcShared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
            'std' => 'md',
            'description' => esc_html__( 'Icon size.', 'js_composer' ),
            'group' => esc_html__( 'Icon', 'wingman' )
        ),

        //Typography settings
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Letter spacing", 'wingman'),
            "param_name" => "letter_spacing",
            "value" => 0,
            "min" => 0,
            "max" => 10,
            "suffix" => "px",
            "description" => "",
            'group' => esc_html__( 'Typography', 'wingman' ),
        ),
        array(
            'type' => 'font_container',
            'param_name' => 'font_container',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'tag' => 'h4', // default value h4
                    'font_size',
                    'line_height',
                    'color',
                    'tag_description' => esc_html__( 'Select element tag.', 'js_composer' ),
                    'text_align_description' => esc_html__( 'Select text alignment.', 'js_composer' ),
                    'font_size_description' => esc_html__( 'Enter font size.', 'js_composer' ),
                    'line_height_description' => esc_html__( 'Enter line height.', 'js_composer' ),
                    'color_description' => esc_html__( 'Select heading color.', 'js_composer' ),
                ),
            ),
            'group' => esc_html__( 'Typography', 'wingman' )
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Use theme default font family?', 'js_composer' ),
            'param_name' => 'use_theme_fonts',
            'value' => array( esc_html__( 'Yes', 'js_composer' ) => 'yes' ),
            'description' => esc_html__( 'Use font family from the theme.', 'js_composer' ),
            'group' => esc_html__( 'Typography', 'js_composer' ),
            'std' => 'yes'
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => '',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => esc_html__( 'Select font family.', 'js_composer' ),
                    'font_style_description' => esc_html__( 'Select font styling.', 'js_composer' )
                )
            ),
            'group' => esc_html__( 'Typography', 'wingman' ),
            'dependency' => array(
                'element' => 'use_theme_fonts',
                'value_not_equal_to' => 'yes',
            ),
            'description' => esc_html__( '', 'js_composer' ),
        ),


        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'CSS box', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
            'group' => esc_html__( 'Design Options', 'js_composer' )
        )

    )
));