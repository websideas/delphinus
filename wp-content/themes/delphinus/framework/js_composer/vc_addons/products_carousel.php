<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



class WPBakeryShortCode_Products_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'per_page' => 10,
            'orderby' => 'date',
            'meta_key' => '',
            'order' => 'DESC',
            'source' => '',
            'categories' => '',
            'products' => '',
            'operator' => 'IN',
            'layout' => 'normal',

            'autoheight' => true,
            'autoplay' => false,
            'mousedrag' => true,
            'autoplayspeed' => 5000,
            'slidespeed' => 200,
            'carousel_skin' => '',

            'desktop' => 4,
            'desktopsmall' => 3,
            'tablet' => 2,
            'mobile' => 1,

            'gutters' => false,
            'navigation' => true,
            'navigation_always_on' => false,
            'navigation_position' => 'center-outside',
            'navigation_style' => 'normal',

            'pagination' => false,
            'pagination_position' => 'center-bottom',
            'pagination_style' => 'dot-stroke',

            'css_animation' => '',
            'el_class' => '',
            'css' => '',   
        ), $atts );


        extract($atts);

        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'products-carousel ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'woocommerce' => 'woocommerce columns-' . $desktop ,
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'layout' => 'layout-' . $layout ,
        );

        $meta_query = WC()->query->get_meta_query();

        if( $source == 'best-sellers' ){
            $meta_key = 'total_sales';
            $orderby    = 'meta_value_num';
        }

        $args = array(
            'post_type'				=> 'product',
            'post_status'			=> 'publish',
            'ignore_sticky_posts'	=> 1,
            'posts_per_page' 		=> $per_page,
            'meta_query' 			=> $meta_query,
            'order'                 => $order,
            'orderby'               => $orderby,
            'meta_key'              => $meta_key
        );

        if( $source == 'onsale' ){
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
        }elseif( $source == 'featured' ){
            $args['meta_query'][] = array(
                'key'   => '_featured',
                'value' => 'yes'
            );
        }elseif($source == 'top-rated'){
            add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
        }elseif($source == 'categories'){
            if ( ! empty( $categories ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms'    => array_map( 'sanitize_title', explode( ',', $categories ) ),
                        'field'    => 'slug',
                        'operator' => $operator
                    )
                );
            }
        }elseif($source == 'products'){
            if ( ! empty( $atts['products'] ) ) {
                $args['post__in'] = array_map( 'trim', explode( ',', $atts['products'] ) );
            }
        }

        $output = $carousel_html ='';

        ob_start();

        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );





        if ( $products->have_posts() ) :
            global $woocommerce_loop;
            $woocommerce_loop['columns'] = $desktop;
            $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts), '', 'wc-carousel-wrapper');
            if($layout == 'transparent'){
                $woocommerce_loop['type'] = 'transparent';
            }else{
                $woocommerce_loop['type'] = 'classic';
            }

            woocommerce_product_loop_start();
            while ( $products->have_posts() ) : $products->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile; // end of the loop.
            woocommerce_product_loop_end();


        endif;


        $carousel_html .= ob_get_clean();
        wp_reset_postdata();

        if($carousel_html){
            $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
            $output = '<div class="'.esc_attr( $elementClass ).'">'.str_replace('%carousel_html%', $carousel_html, $carousel_ouput).'</div>';
        }

        return $output;

    }
}



vc_map( array(
    "name" => esc_html__( "KT: Products Carousel", 'delphinus'),
    "base" => "products_carousel",
    "category" => esc_html__('by Kite-Themes', 'delphinus' ),
    "params" => array(



        array(
            'type' => 'dropdown',
            "heading" => esc_html__("Product layout", 'delphinus'),
            'param_name' => 'layout',
            'value' => array(
                esc_html__( 'Normal', 'woocommerce' ) => 'normal',
                esc_html__( 'Transparent', 'js_composer' ) => 'transparent',
            ),
            'std' => 'normal',
            'description' => esc_html__( 'Select your product layout.', 'delphinus' )
        ),
        // Others setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Data settings", 'delphinus'),
            "param_name" => "data_settings",
        ),
        array(
            'type' => 'dropdown',
            "heading" => esc_html__("Data source", 'delphinus'),
            'param_name' => 'source',
            'value' => array(
                esc_html__( 'All Product', 'woocommerce' ) => 'all',
                esc_html__( 'Featured Products', 'js_composer' ) => 'featured',
                esc_html__( 'On-sale Products', 'js_composer' ) => 'onsale',
                esc_html__( 'Best Sellers', 'js_composer' ) => 'best-sellers',
                esc_html__( 'Specific Categories', 'js_composer' ) => 'categories',
                esc_html__( 'Specific Products', 'js_composer' ) => 'products',
            ),
            'std' => 'all',
            'description' => esc_html__( 'Select your source', 'delphinus' )
        ),
        array(
            "type" => "kt_taxonomy",
            'taxonomy' => 'product_cat',
            'heading' => esc_html__( 'Categories', 'delphinus' ),
            'param_name' => 'categories',
            'placeholder' => esc_html__( 'Select your categories', 'delphinus' ),
            "dependency" => array("element" => "source","value" => array('categories')),
            'multiple' => true,
        ),
        array(
            "type" => "kt_posts",
            'args' => array('post_type' => 'product', 'posts_per_page' => -1),
            'heading' => esc_html__( 'Specific Products', 'js_composer' ),
            'param_name' => 'products',
            'size' => '5',
            'placeholder' => esc_html__( 'Select your posts', 'js_composer' ),
            "dependency" => array( "element" => "source","value" => array( 'products' ) ),
            'multiple' => true,
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Per page', 'js_composer' ),
            'value' => 10,
            'param_name' => 'per_page',
            'description' => esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
            "admin_label" => true,
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                esc_html__( 'Date', 'js_composer' ) => 'date',
                esc_html__( 'Order by post ID', 'js_composer' ) => 'ID',
                esc_html__( 'Author', 'js_composer' ) => 'author',
                esc_html__( 'Title', 'js_composer' ) => 'title',
                esc_html__( 'Last modified date', 'js_composer' ) => 'modified',
                esc_html__( 'Post/page parent ID', 'js_composer' ) => 'parent',
                esc_html__( 'Number of comments', 'js_composer' ) => 'comment_count',
                esc_html__( 'Menu order/Page Order', 'js_composer' ) => 'menu_order',
                esc_html__( 'Meta value', 'js_composer' ) => 'meta_value',
                esc_html__( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                esc_html__( 'Random order', 'js_composer' ) => 'rand',
            ),
            "dependency" => array( "element" => "source","value" => 'all' ),
            'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            "admin_label" => true,
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'dependency' => array(
                'element' => 'orderby',
                'value' => array( 'meta_value', 'meta_value_num' ),
            ),
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'value' => array(
                esc_html__( 'Descending', 'js_composer' ) => 'DESC',
                esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            "dependency" => array( "element" => "source","value" => 'all' ),
            'param_holder_class' => 'vc_grid-data-type-not-ids',
            'description' => esc_html__( 'Select sorting order.', 'js_composer' ),
            "admin_label" => true,
        ),

        // Others setting
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Others settings", 'delphinus'),
            "param_name" => "others_settings",
        ),

        vc_map_add_css_animation(),

        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),



        // Carousel
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Auto Height', 'delphinus' ),
            'param_name' => 'autoheight',
            'value' => 'true',
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            "description" => esc_html__("Enable auto height.", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Mouse Drag', 'delphinus' ),
            'param_name' => 'mousedrag',
            'value' => 'true',
            "description" => esc_html__("Mouse drag enabled.", 'delphinus'),
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'AutoPlay', 'delphinus' ),
            'param_name' => 'autoplay',
            'value' => 'false',
            "description" => esc_html__("Enable auto play.", 'delphinus'),
            "edit_field_class" => "vc_col-sm-4 kt_margin_bottom",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("AutoPlay Speed", 'delphinus'),
            "param_name" => "autoplayspeed",
            "value" => "5000",
            "suffix" => esc_html__("milliseconds", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            "dependency" => array("element" => "autoplay","value" => array('true')),
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Slide Speed", 'delphinus'),
            "param_name" => "slidespeed",
            "value" => "200",
            "suffix" => esc_html__("milliseconds", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Carousel skin', 'delphinus' ),
            'param_name' => 'carousel_skin',
            'value' => array(
                esc_html__( 'Default', 'delphinus') => '',
                esc_html__( 'White', 'delphinus') => 'white',
            ),
            'std' => '',
            'desc' => esc_html__('Select carousel skin', 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Items to Show?", 'delphinus'),
            "param_name" => "items_show",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Desktop", 'delphinus'),
            "param_name" => "desktop",
            "value" => 4,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),

        array(
            'type' => 'kt_number',
            'heading' => esc_html__( 'on Tablets Landscape', 'delphinus' ),
            'param_name' => 'desktopsmall',
            "value" => 3,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Tablet", 'delphinus'),
            "param_name" => "tablet",
            "value" => 2,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_number",
            "class" => "",
            "edit_field_class" => "vc_col-sm-6 kt_margin_bottom",
            "heading" => esc_html__("On Mobile", 'delphinus'),
            "param_name" => "mobile",
            "value" => 1,
            "min" => "1",
            "max" => "5",
            "step" => "1",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Navigation settings", 'delphinus'),
            "param_name" => "navigation_settings",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Navigation', 'delphinus' ),
            'param_name' => 'navigation',
            'value' => 'true',
            "description" => esc_html__("Show navigation in carousel", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Navigation position', 'delphinus' ),
            'param_name' => 'navigation_position',
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            'value' => array(
                esc_html__( 'Center outside', 'delphinus') => 'center-outside',
                esc_html__( 'Center inside', 'delphinus') => 'center',
                esc_html__( 'Bottom', 'delphinus') => 'bottom',
            ),
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Always Show Navigation', 'delphinus' ),
            'param_name' => 'navigation_always_on',
            'value' => 'false',
            "description" => esc_html__("Always show the navigation.", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            "dependency" => array("element" => "navigation_position","value" => array('center', 'center-outside')),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Navigation style', 'js_composer' ),
            'param_name' => 'navigation_style',
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            'value' => array(
                esc_html__( 'Normal', 'delphinus' ) => 'normal',
                esc_html__( 'Normal White', 'delphinus' ) => 'normal-white',
                esc_html__( 'Circle Background', 'delphinus' ) => 'circle-background',
                esc_html__( 'Square Background', 'delphinus' ) => 'square-background',
                esc_html__( 'Round Background', 'delphinus' ) => 'round-background',
                esc_html__( 'Circle Border', 'delphinus' ) => 'circle-border',
                esc_html__( 'Square Border', 'delphinus' ) => 'square-border',
                esc_html__( 'Round Border', 'delphinus' ) => 'round-border',
            ),
            'std' => 'normal',
            "dependency" => array("element" => "navigation","value" => array('true')),
        ),
        array(
            "type" => "kt_heading",
            "heading" => esc_html__("Pagination settings", 'delphinus'),
            "param_name" => "pagination_settings",
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Pagination', 'delphinus' ),
            'param_name' => 'pagination',
            'value' => 'false',
            "description" => esc_html__("Show pagination in carousel", 'delphinus'),
            'group' => esc_html__( 'Carousel', 'delphinus' )
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Pagination position', 'delphinus' ),
            'param_name' => 'pagination_position',
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            'value' => array(
                esc_html__( 'Center Top', 'delphinus') => 'center-top',
                esc_html__( 'Center Bottom', 'delphinus') => 'center-bottom',
                esc_html__( 'Bottom Left', 'delphinus') => 'bottom-left',
            ),
            'std' => 'center_bottom',
            "dependency" => array("element" => "pagination","value" => array('true')),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Pagination style', 'js_composer' ),
            'param_name' => 'pagination_style',
            'group' => esc_html__( 'Carousel', 'delphinus' ),
            'value' => array(
                esc_html__( 'Dot stroke', 'delphinus' ) => 'dot-stroke',
                esc_html__( 'Fill pp', 'delphinus' ) => 'fill-up',
                esc_html__( 'Circle grow', 'delphinus' ) => 'circle-grow',
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
