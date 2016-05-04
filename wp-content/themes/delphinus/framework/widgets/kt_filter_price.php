<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Price Filter Widget and related functions.
 *
 * Generates a range slider to filter products by price.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class WC_Widget_KT_Price_Filter extends WC_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_kt_price_filter';
        $this->widget_description = __( 'Shows a price filter slider in a widget which lets you narrow down the list of shown products when viewing product categories.', 'woocommerce' );
        $this->widget_id          = 'wc_kt_price_filter';
        $this->widget_name        = __( 'KT: WooCommerce Price Filter', 'woocommerce' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Filter by price', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' )
            ),
            'range_size' => array(
                'type'  => 'number',
                'min'   => 1,
                'max'   => '',
                'step'  => 1,
                'std'   => 50,
                'label' => __( 'Price range size', 'delphinus' )
            ),
            'max_ranges' => array(
                'type'  => 'number',
                'min'   => 1,
                'max'   => '',
                'step'  => 1,
                'std'   => 5,
                'label' => __( 'Max price ranges', 'delphinus' )
            )
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        global $_chosen_attributes, $wpdb, $wp;

        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }

        if ( sizeof( WC()->query->unfiltered_product_ids ) == 0 ) {
            return; // None shown - return
        }



        // Remember current filters/search

        if ( '' == get_option( 'permalink_structure' ) ) {
            $link_url = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
        } else {
            $link_url = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
        }


        if ( get_search_query() ) {
            $link_url = add_query_arg( 's', get_search_query(), $link_url );
        }

        if ( ! empty( $_GET['post_type'] ) ) {
            $link_url = add_query_arg( 'post_type', urlencode( $_GET['post_type'] ), $link_url );
        }

        if ( ! empty ( $_GET['product_cat'] ) ) {
            $link_url = add_query_arg( 'product_cat', urlencode( $_GET['product_cat'] ), $link_url );
        }

        if ( ! empty( $_GET['product_tag'] ) ) {
            $link_url = add_query_arg( 'product_tag', urlencode( $_GET['product_tag'] ), $link_url );
        }

        if ( ! empty( $_GET['orderby'] ) ) {
            $link_url = add_query_arg( 'orderby', urlencode( $_GET['orderby'] ), $link_url );
        }

        if ( $_chosen_attributes ) {
            foreach ( $_chosen_attributes as $attribute => $data ) {
                $taxonomy_filter = 'filter_' . str_replace( 'pa_', '', $attribute );
                $link_url = add_query_arg( esc_attr( $taxonomy_filter ), esc_attr( implode( ',', $data['terms'] ) ), $link_url );

                if ( 'or' == $data['query_type'] ) {
                    $link_url = add_query_arg( esc_attr( str_replace( 'pa_', 'query_type_', $attribute ) ), 'or', $link_url );
                }
            }
        }

        if ( 0 === sizeof( WC()->query->layered_nav_product_ids ) ) {
            $min = floor( $wpdb->get_var( "
				SELECT min(meta_value + 0)
				FROM {$wpdb->posts} as posts
				LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
				WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) ) . "')
				AND meta_value != ''
			" ) );
            $max = ceil( $wpdb->get_var( "
				SELECT max(meta_value + 0)
				FROM {$wpdb->posts} as posts
				LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
				WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
			" ) );
        } else {
            $min = floor( $wpdb->get_var( "
				SELECT min(meta_value + 0)
				FROM {$wpdb->posts} as posts
				LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
				WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price', '_min_variation_price' ) ) ) ) . "')
				AND meta_value != ''
				AND (
					posts.ID IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
					OR (
						posts.post_parent IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
						AND posts.post_parent != 0
					)
				)
			" ) );
            $max = ceil( $wpdb->get_var( "
				SELECT max(meta_value + 0)
				FROM {$wpdb->posts} as posts
				LEFT JOIN {$wpdb->postmeta} as postmeta ON posts.ID = postmeta.post_id
				WHERE meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
				AND (
					posts.ID IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
					OR (
						posts.post_parent IN (" . implode( ',', array_map( 'absint', WC()->query->layered_nav_product_ids ) ) . ")
						AND posts.post_parent != 0
					)
				)
			" ) );
        }

        if ( $min == $max ) {
            return;
        }

        $this->widget_start( $args, $instance );

        $minprice = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
        $maxprice = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

        $output = '';

        $min_price = 0;
        $range_size = intval( $instance['range_size'] );
        $max_ranges = ( intval( $instance['max_ranges'] ) - 1 );
        $count = 0;

        if ( strlen( $minprice ) > 0 ) {
            $output .= '<li><a href="' . esc_url( $link_url ) . '">' . esc_html__( 'All', 'delphinus' ) . '</a></li>';
        } else {
            $output .= '<li class="selected">' . esc_html__( 'All', 'delphinus' ) . '</li>';
        }


        while($count <= $max_ranges){

            $step = $min_price;
            $min_price += $range_size;

            if($count != $max_ranges ){
                if($min_price > $max){
                    $min_price = $max;
                }
                $link = add_query_arg( array( 'min_price' => $step, 'max_price' => $min_price ), $link_url );
                $price_text = wc_price($step).' - '.wc_price($min_price);
            }else{
                $link = add_query_arg( array( 'min_price' => $step, 'max_price' => $max ), $link_url );
                $price_text = wc_price($step).'+';
            }

            if($step == $minprice && $min_price == $maxprice){
                $output .= '<li class="selected">' . $price_text . '</li>';
            }else{
                $output .= '<li><a href="' . esc_url( $link ) . '">' . $price_text . '</a></li>';
            }

            $count++;
            if($min_price == $max){
                break;
            }

        }


        printf('<ul>%s</ul>', $output);

        $this->widget_end( $args );
    }
}


/**
 * Register Widget Price Filter widget
 *
 *
 */

register_widget('WC_Widget_KT_Price_Filter');

