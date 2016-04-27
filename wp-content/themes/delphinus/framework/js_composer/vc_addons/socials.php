<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Socials extends WPBakeryShortCode {
    protected function content($atts, $content = null) {

        extract(shortcode_atts(array(
    	   "social" => '',
    	   "size" => 'standard',
    	   "style" => 'accent',
           'custom_color' => '',
           'align' => '',
           'tooltip' =>'top',
           'el_class' => '',
           'background_style' => 'empty',
           'space_between_item' => 3,

            'css' => '',
    	), $atts));

        $output = $social_icons = '';

        $socials_arr = array(
            'facebook' => array('title' => esc_html__('Facebook', 'delphinus'), 'icon' => 'fa fa-facebook', 'link' => '%s'),
            'twitter' => array('title' => esc_html__('Twitter', 'delphinus'), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
            'dribbble' => array('title' => esc_html__('Dribbble', 'delphinus'), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
            'vimeo' => array('title' => esc_html__('Vimeo', 'delphinus'), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
            'tumblr' => array('title' => esc_html__('Tumblr', 'delphinus'), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
            'skype' => array('title' => esc_html__('Skype', 'delphinus'), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
            'linkedin' => array('title' => esc_html__('LinkedIn', 'delphinus'), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
            'googleplus' => array('title' => esc_html__('Google Plus', 'delphinus'), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
            'youtube' => array('title' => esc_html__('Youtube', 'delphinus'), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
            'pinterest' => array('title' => esc_html__('Pinterest', 'delphinus'), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
            'instagram' => array('title' => esc_html__('Instagram', 'delphinus'), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
        );

        foreach($socials_arr as $k => &$v){
            $val = kt_option($k);
            $v['val'] = ($val) ? $val : '';
        }


        $tooltiphtml = '';

        if($tooltip) {
            $tooltiphtml .= ' data-toggle="tooltip" data-placement="'.esc_attr($tooltip).'" ';
        }

        $margin = ($space_between_item > 0) ? 'style="padding-left:'.$space_between_item.'px;padding-right:'.$space_between_item.'px;"' : '';
        
        if($social){
            $social_type = explode(',', $social);
            foreach ($social_type as $id) {
                $val = $socials_arr[$id];
                if($val['val']) {
                    $social_text = '<i class="' . esc_attr($val['icon']) . '"></i>';
                    $social_icons .= '<li ' . $margin . '><a class="' . esc_attr($id) . '" title="' . esc_attr($val['title']) . '" ' . $tooltiphtml . ' href="' . esc_url(str_replace('%s', $val['val'], $val['link'])) . '" target="_blank">' . $social_text . '</a></li>' . "\n";
                }
            }
        }else{
            foreach($socials_arr as $key => $val){
                if($val['val']){
                    $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                    $social_icons .= '<li '.$margin.'><a class="'.esc_attr($key).'"  '.$tooltiphtml.' title="'.esc_attr($val['title']).'" href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>'."\n";
                }
            }
        }

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'socials-icon-wrapper', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'style' => 'social-style-'.$style,
            'size' => 'social-icons-'.$size,
            'shape' => 'social-background-'.$background_style,
            'clearfix' => 'clearfix'
        );
        if($background_style == 'empty'){
            $elementClass[] = 'social-background-empty';
        }elseif ( strpos( $background_style, 'outline' ) !== false ) {
            $elementClass[] = 'social-background-outline';
        }else{
            $elementClass[] = 'social-background-fill';
        }
        
        $custom_css = '';
        $rand = 'kt_social_'.rand();
        if( $style == 'custom' ){
            $custom_css .= '#'.$rand.'.social-style-custom.social-background-fill a{
                color:#fff!important;
                background:'.$custom_color.'!important;
            }';
            $custom_css .= '#'.$rand.'.social-style-custom.social-background-outline a{
                color:'.$custom_color.'!important;
                border-color:'.$custom_color.'!important;
                background: none !important;
            }';
            $custom_css .= '#'.$rand.'.social-style-custom.social-background-empty a{
                color:'.$custom_color.'!important;
                background:none!important;
                border:!important;
            }';
        }
        if($custom_css){
            $custom_css = '<div class="kt_custom_css" data-css="'.esc_attr($custom_css).'"></div>';
        }

        if($align){
            $elementClass['align'] = 'social-icons-'.$align;
        }

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

    	$output .= '<div id="'.$rand.'" class="'.esc_attr( $elementClass ).'"><ul style="margin-left: -'.$space_between_item.'px;margin-right: -'.$space_between_item.'px;" class="social-nav clearfix">';
    	$output .= $social_icons;
    	$output .= '</ul>'.$custom_css.'</div>';
     
    	return $output;
    }
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => esc_html__( "KT: Socials", 'delphinus'),
    "base" => "socials",
    "category" => esc_html__('by Kite-Themes', 'delphinus' ),
    "params" => array(
        array(
            "type" => "kt_socials",
            "class" => "",
            "heading" => esc_html__("Choose social", 'delphinus'),
            "param_name" => "social",
            "value" => '',
            "description" => esc_html__("Empty for select all, Drop and sortable social", 'delphinus'),
            "admin_label" => true,
        ),
        array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Style",'delphinus'),
			"param_name" => "style",
			"value" => array(
                esc_html__('Accent', 'delphinus') => 'accent',
                esc_html__('Dark', 'delphinus') => 'dark',
                esc_html__('Light', 'delphinus') => 'light',
                esc_html__('Color', 'delphinus') => 'color',
                esc_html__('Custom Color', 'delphinus') => 'custom',
			),
			"description" => esc_html__("",'delphinus'),
            "admin_label" => true,
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Custom Color', 'js_composer' ),
            'param_name' => 'custom_color',
            'description' => esc_html__( 'Select color socials.', 'js_composer' ),
            'dependency' => array(
                'element' => 'style',
                'value' => 'custom',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Background shape', 'js_composer' ),
            'param_name' => 'background_style',
            'value' => array(
                esc_html__( 'None', 'js_composer' ) => '',
                esc_html__( 'Circle', 'js_composer' ) => 'rounded',
                esc_html__( 'Square', 'js_composer' ) => 'boxed',
                esc_html__( 'Rounded', 'js_composer' ) => 'rounded-less',
                esc_html__( 'Diamond Square', 'js_composer' ) => 'diamond-square',
                esc_html__( 'Outline Circle', 'js_composer' ) => 'rounded-outline',
                esc_html__( 'Outline Square', 'js_composer' ) => 'boxed-outline',
                esc_html__( 'Outline Rounded', 'js_composer' ) => 'rounded-less-outline',
                esc_html__( 'Outline Diamond Square', 'js_composer' ) => 'diamond-square-outline',
            ),
            'description' => esc_html__( 'Select background shape and style for social.', 'delphinus' ),
            "admin_label" => true,
        ),

        array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Size",'delphinus'),
			"param_name" => "size",
			"value" => array(
                esc_html__('Standard', 'delphinus') => 'standard',
                esc_html__('Small', 'delphinus') => 'small',
			),
			"description" => esc_html__("",'delphinus'),
            "admin_label" => true,
		),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Tooltip",'delphinus'),
            "param_name" => "tooltip",
            "value" => array(
                esc_html__('None', 'delphinus') => '',
                esc_html__('Top', 'delphinus') => 'top',
                esc_html__('Right', 'delphinus') => 'right',
                esc_html__('Bottom', 'delphinus') => 'bottom',
                esc_html__('Left', 'delphinus') => 'left',
            ),
            'std' => 'top',
            "description" => esc_html__("Select the tooltip position",'delphinus'),
            "admin_label" => true,
        ),

        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => esc_html__("Align",'delphinus'),
            "param_name" => "align",
            "value" => array(
                esc_html__('None', 'delphinus') => '',
                esc_html__('Center', 'delphinus') => 'center',
                esc_html__('Left', 'delphinus') => 'left',
                esc_html__('Right', 'delphinus') => 'right'
            ),
            "description" => esc_html__("",'delphinus')
        ),
        
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Space Between item", 'delphinus'),
            "param_name" => "space_between_item",
            "value" => 3,
            "min" => 0,
            "max" => 50,
            "suffix" => "px",
            "description" => "",
        ),
        
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
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