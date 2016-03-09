<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


class WPBakeryShortCode_Products_Widget_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'font_container' => '',
            'use_theme_fonts' => 'yes',
            'google_fonts' => '',

            'source' => 'recent',
            'per_page' => 9,
            'carousel_item' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'css_animation' => '',
            'el_class' => '',
            'css' => '',

        ), $atts );

        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wc-products-widget-carousel', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );

        $output = '';



        $meta_query = WC()->query->get_meta_query();
        $args = array(
            'post_type'				=> 'product',
            'post_status'			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $atts['per_page'],
            'meta_query' 			=> $meta_query
        );

        if($source == 'sale' || $source == 'featured'){
            $args['order'] = $order;
            $args['orderby'] = $orderby;
        }


        if( $source == 'bestselling' ){
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';

        }elseif( $source == 'featured' ){
            $args['meta_query'][] = array(
                'key'   => '_featured',
                'value' => 'yes'
            );
        }elseif($source =='sale'){
            $args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            $args['no_found_rows']  = 1;
        }elseif($source == 'recent'){
            $args['order'] = 'date';
            $args['orderby'] = 'desc';
        }

        $products = new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $args ) );

        ob_start();


        if ( $products->have_posts() ) {



            echo '<div class="owl-carousel-kt">';

            echo '<div class="owl-carousel kt-owl-carousel" data-options=\'{"pagination": false, "navigation": true, "desktop": 1, "tablet" : 1, "mobile" : 1}\'>';

            $i = 0;

            while ($products->have_posts()) {

                if( $i % $carousel_item == 0 && $i != 0){
                    echo apply_filters('woocommerce_after_widget_product_list', '</ul>');
                }
                if($i % $carousel_item == 0 ){
                    echo apply_filters('woocommerce_before_widget_product_list', '<ul class="product_list_widget">');
                }

                $products->the_post();
                wc_get_template('content-widget-product.php', array('show_rating' => true));


                $i++;
            }

            echo apply_filters('woocommerce_after_widget_product_list', '</ul>');

            echo '</div></div>';

        }
        wp_reset_postdata();


        $output .= ob_get_clean();

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        $output = '<div class="'.esc_attr( $elementClass ).'"><div class="woocommerce">'.$output.'</div></div>';

        return $output;
    }
}



vc_map( array(
    "name" => esc_html__( "KT: Products Widget Carousel", 'wingman'),
    "base" => "products_widget_carousel",
    "category" => esc_html__('by Kite-Themes', 'wingman' ),
    "params" => array(

        // Data setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Data settings", 'wingman'),
            "param_name" => "data_settings",
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Data source", 'wingman'),
            "param_name" => "source",
            "value" => array(
                esc_html__('Recent products', 'wingman') => 'recent',
                esc_html__('Featured Products', 'wingman') => 'featured',
                esc_html__('On-sale Products', 'wingman') => 'sale',
                esc_html__('Best Selling Products', 'wingman') => 'bestselling',

            ),
            'std' => 'recent',
            "admin_label" => true,
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                '',
                esc_html__( 'Date', 'js_composer' ) => 'date',
                esc_html__( 'ID', 'js_composer' ) => 'ID',
                esc_html__( 'Author', 'js_composer' ) => 'author',
                esc_html__( 'Title', 'js_composer' ) => 'title',
                esc_html__( 'Modified', 'js_composer' ) => 'modified',
                esc_html__( 'Random', 'js_composer' ) => 'rand',
                esc_html__( 'Comment count', 'js_composer' ) => 'comment_count',
                esc_html__( 'Menu order', 'js_composer' ) => 'menu_order',
            ),
            'save_always' => true,
            'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            'dependency' => array(
                'element' => 'source',
                'value' => array( 'featured', 'sale' ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Sort order', 'js_composer' ),
            'param_name' => 'order',
            'value' => array(
                '',
                esc_html__( 'Descending', 'js_composer' ) => 'DESC',
                esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'save_always' => true,
            'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            'dependency' => array(
                'element' => 'source',
                'value' => array( 'featured', 'sale' ),
            ),
        ),


        // Others setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Others settings", 'wingman'),
            "param_name" => "others_settings",
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

        // Carousel Settings
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Total Products', 'js_composer' ),
            'value' => 9,
            'param_name' => 'per_page',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'description' => esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
        ),
        array(
            'type' => 'kt_number',
            'heading' => esc_html__( 'Products in carousel item', 'js_composer' ),
            'value' => 3,
            'param_name' => 'carousel_item',
            'group' => esc_html__( 'Carousel', 'wingman' ),
            'description' => esc_html__( 'The number product in each carousel item', 'js_composer' ),
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
