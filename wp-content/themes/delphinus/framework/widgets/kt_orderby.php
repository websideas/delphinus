<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Widget_KT_Orderby extends WC_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_kt_orderby';
        $this->widget_description = __( 'Display a product sorting list.', 'delphinus' );
        $this->widget_id          = 'wc_kt_orderby';
        $this->widget_name        = __( 'KT: WooCommerce Product Sorting', 'delphinus' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Sort By', 'delphinus' ),
                'label' => __( 'Title', 'woocommerce' )
            ),
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {

        global $wp_query;

        if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
            return;
        }

        $this->widget_start( $args, $instance );

        $orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => __( 'Default sorting', 'woocommerce' ),
            'popularity' => __( 'Sort by popularity', 'woocommerce' ),
            'rating'     => __( 'Sort by average rating', 'woocommerce' ),
            'date'       => __( 'Sort by newness', 'woocommerce' ),
            'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
            'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
        ) );

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
            unset( $catalog_orderby_options['rating'] );
        }

        global $wp;
        $link = home_url( $wp->request ); // Base page URL

        if ( isset( $_SERVER['QUERY_STRING'] ) ) {
            parse_str( $_SERVER['QUERY_STRING'], $params );
            $link .= '?' . $_SERVER['QUERY_STRING'];
        } else {
            $link .= '';
        }

        $output = '';
        foreach ( $catalog_orderby_options as $id => $name ) :
            $link_url = add_query_arg( array( 'orderby' => $id), $link );
            if($orderby == $id){
                $output .= '<li class="selected">'. esc_html( $name ). '</li>';
            }else{
                $output .= '<li><a href="' . esc_url( $link_url ) . '">' . esc_html( $name ). '</a></li>';
            }
        endforeach;

        printf('<ul>%s</ul>', $output);

        $this->widget_end( $args );
    }

}


/**
 * Register Widget Product Orderby widget
 *
 *
 */

register_widget('WC_Widget_KT_Orderby');

