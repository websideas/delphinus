<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Categories_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'per_page' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'ids' => '',
            'hide_empty' => 'true',
            'parent'     => '',

            'autoheight' => true,
            'autoplay' => false,
            'mousedrag' => true,
            'autoplayspeed' => 5000,
            'slidespeed' => 200,

            'desktop' => 4,
            'desktopsmall' => 3,
            'tablet' => 2,
            'mobile' => 1,

            'gutters' => false,
            'navigation' => true,
            'navigation_always_on' => true,
            'navigation_position' => 'center-outside',
            'navigation_style' => 'normal',

            'pagination' => false,
            'pagination_position' => 'center-bottom',
            'pagination_style' => 'dot-stroke',

            'css_animation' => '',
            'el_class' => '',
            'css' => '',
        ), $atts );

        $atts['columns'] = $atts['desktop'];
        $atts['number'] = $atts['per_page'];

        $atts['hide_empty'] = apply_filters('sanitize_boolean', $atts['hide_empty']);

        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'products-categories-carousel ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'woocommerce' => 'woocommerce columns-' . $desktop ,
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );


        $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts), '', 'kt-owl-carousel');
        $output = $carousel_html ='';



        if ( isset( $atts['ids'] ) ) {
            $ids = explode( ',', $atts['ids'] );
            $ids = array_map( 'trim', $ids );
        } else {
            $ids = array();
        }

        $hide_empty = ( $atts['hide_empty'] == true || $atts['hide_empty'] == 1 ) ? 1 : 0;

        // get terms and workaround WP bug with parents/pad counts
        $args = array(
            'orderby'    => $atts['orderby'],
            'order'      => $atts['order'],
            'hide_empty' => $hide_empty,
            'include'    => $ids,
            'pad_counts' => true,
            'child_of'   => $atts['parent']
        );

        $product_categories = get_terms( 'product_cat', $args );

        if ( '' !== $atts['parent'] ) {
            $product_categories = wp_list_filter( $product_categories, array( 'parent' => $atts['parent'] ) );
        }

        if ( $hide_empty ) {
            foreach ( $product_categories as $key => $category ) {
                if ( $category->count == 0 ) {
                    unset( $product_categories[ $key ] );
                }
            }
        }

        if ( $atts['number'] ) {
            $product_categories = array_slice( $product_categories, 0, $atts['number'] );
        }


        ob_start();

        if ( $product_categories ) {

            foreach ( $product_categories as $category ) {
                wc_get_template( 'content-product_cat_carousel.php', array(
                    'category' => $category
                ) );
            }

        }

        wp_reset_postdata();
        $carousel_html .= ob_get_clean();
        if($carousel_html){

            $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
            $output = '<div class="'.esc_attr( $elementClass ).'">'.str_replace('%carousel_html%', $carousel_html, $carousel_ouput).'</div>';

        }

        return $output;

    }
}



vc_map( array(
    "name" => esc_html__( "KT: Product Categories Carousel", 'wingman'),
    "base" => "categories_carousel",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    "params" => array(

        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
            'heading' => esc_html__( 'Categories', 'js_composer' ),
            'param_name' => 'ids',
            'multiple' => true,
            'admin_label' => true,
            'select' => 'id',
            'description' => esc_html__('List of product categories', 'delphinus')
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Per Page', 'js_composer' ),
            'value' => '',
            'param_name' => 'per_page',
            'description' => esc_html__( 'The "per_page" shortcode determines how many categories to show on the page', 'js_composer' ),
        ),
        "admin_label" => true,

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                esc_html__( 'Name', 'js_composer' ) => 'name',
                esc_html__( 'ID', 'js_composer' ) => 'id',
                esc_html__( 'Count', 'js_composer' ) => 'count',
                esc_html__( 'Slug', 'js_composer' ) => 'slug',
                esc_html__( 'None', 'js_composer' ) => 'none',
            ),
            'std' => 'name',
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
        ),


        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'value' => array(
                esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
                esc_html__( 'Descending', 'js_composer' ) => 'DESC',
            ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'description' => esc_html__( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
        ),

        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Hide empty', 'wingman' ),
            'param_name' => 'hide_empty',
            'value' => 'true',
            "description" => esc_html__("Hide category if empty.", 'wingman'),
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



        // Carousel
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Auto Height', 'wingman' ),
            'param_name' => 'autoheight',
            'value' => 'true',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "description" => esc_html__("Enable auto height.", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Mouse Drag', 'wingman' ),
            'param_name' => 'mousedrag',
            'value' => 'true',
            "description" => esc_html__("Mouse drag enabled.", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' ),
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'AutoPlay', 'wingman' ),
            'param_name' => 'autoplay',
            'value' => 'false',
            "description" => esc_html__("Enable auto play.", 'wingman'),
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("AutoPlay Speed", 'wingman'),
            "param_name" => "autoplayspeed",
            "value" => "5000",
            "suffix" => esc_html__("milliseconds", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' ),
            "dependency" => array("element" => "autoplay","value" => array('true')),
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Slide Speed", 'wingman'),
            "param_name" => "slidespeed",
            "value" => "200",
            "suffix" => esc_html__("milliseconds", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Items to Show?", 'wingman'),
            "param_name" => "items_show",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Desktop", 'wingman'),
            "param_name" => "desktop",
            "value" => 4,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),

        array(
            'type' => 'kt_number',
            'heading' => esc_html__( 'on Tablets Landscape', 'wingman' ),
            'param_name' => 'desktopsmall',
            "value" => 3,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Tablet", 'wingman'),
            "param_name" => "tablet",
            "value" => 2,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Mobile", 'wingman'),
            "param_name" => "mobile",
            "value" => 1,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Navigation settings", 'wingman'),
            "param_name" => "navigation_settings",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Navigation', 'wingman' ),
            'param_name' => 'navigation',
            'value' => 'true',
            "description" => esc_html__("Show navigation in carousel", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Navigation position', 'wingman' ),
            'param_name' => 'navigation_position',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'value' => array(
                esc_html__( 'Center outside', 'wingman') => 'center-outside',
                esc_html__( 'Center inside', 'wingman') => 'center',
                //esc_html__( 'Top', 'wingman') => 'top',
                esc_html__( 'Bottom', 'wingman') => 'bottom',
            ),
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Always Show Navigation', 'wingman' ),
            'param_name' => 'navigation_always_on',
            'value' => 'false',
            "description" => esc_html__("Always show the navigation.", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' ),
            "dependency" => array("element" => "navigation_position","value" => array('center', 'center-outside')),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Navigation style', 'js_composer' ),
            'param_name' => 'navigation_style',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'value' => array(
                esc_html__( 'Normal', 'wingman' ) => 'normal',
                esc_html__( 'Circle Background', 'wingman' ) => 'circle-background',
                esc_html__( 'Square Background', 'wingman' ) => 'square-background',
                esc_html__( 'Round Background', 'wingman' ) => 'round-background',
                esc_html__( 'Circle Border', 'wingman' ) => 'circle-border',
                esc_html__( 'Square Border', 'wingman' ) => 'square-border',
                esc_html__( 'Round Border', 'wingman' ) => 'round-border',
            ),
            'std' => 'normal',
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Pagination settings", 'wingman'),
            "param_name" => "pagination_settings",
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Pagination', 'wingman' ),
            'param_name' => 'pagination',
            'value' => 'false',
            "description" => esc_html__("Show pagination in carousel", 'wingman'),
            'group' => esc_html__( 'Carousel', 'wingman' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Pagination position', 'wingman' ),
            'param_name' => 'pagination_position',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'value' => array(
                esc_html__( 'Center Top', 'wingman') => 'center-top',
                esc_html__( 'Center Bottom', 'wingman') => 'center-bottom',
                esc_html__( 'Bottom Left', 'wingman') => 'bottom-left',
            ),
            'std' => 'center_bottom',
            "dependency" => array("element" => "pagination","value" => array('true')),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Pagination style', 'js_composer' ),
            'param_name' => 'pagination_style',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'value' => array(
                esc_html__( 'Dot stroke', 'wingman' ) => 'dot-stroke',
                esc_html__( 'Fill pp', 'wingman' ) => 'fill-up',
                esc_html__( 'Circle grow', 'wingman' ) => 'circle-grow',
            ),
            'std' => 'dot_stroke',
            "dependency" => array("element" => "pagination","value" => array('true')),
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
