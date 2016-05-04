<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Widget_Color_Filter extends WC_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_color_filter';
        $this->widget_description = __( 'Shows "color" attributes in a widget which lets you narrow down the list of products when viewing products.', 'woocommerce' );
        $this->widget_id          = 'woocommerce_color_filter';
        $this->widget_name        = __( 'KT: WooCommerce Color Filter', 'woocommerce' );

        parent::__construct();
    }

    /**
     * Updates a particular instance of a widget.
     *
     * @see WP_Widget->update
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {


        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        if ( in_array( $new_instance['query_type'], array( 'and', 'or' ) ) ) {
            $instance['query_type'] = $new_instance['query_type'];
        } else {
            $instance['query_type'] = 'and';
        }
        $colors = array();
        foreach( $new_instance['colors'] as $key => $val ){
            $colors[$key] = $val;
        }
        $instance['attribute'] = 'color';
        $instance['colors'] = $colors;

        return $instance;


    }

    /**
     * Outputs the settings update form.
     *
     * @see WP_Widget->form
     *
     * @param array $instance
     */
    public function form( $instance ) {
        $this->init_settings();

        parent::form( $instance );
    }

    /**
     * Init settings after post types are registered.
     */
    public function init_settings() {
        $attribute_array      = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( $attribute_taxonomies ) {
            foreach ( $attribute_taxonomies as $tax ) {
                if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                    $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
                }
            }
        }

        $this->settings = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Color', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' )
            ),
            'query_type' => array(
                'type'    => 'select',
                'std'     => 'and',
                'label'   => __( 'Query type', 'woocommerce' ),
                'options' => array(
                    'and' => __( 'AND', 'woocommerce' ),
                    'or'  => __( 'OR', 'woocommerce' )
                )
            ),
            'colors' => array(
                'type' => 'colors',
                'label' => '',
                'attribute' => 'color',
                'std' => array(),
                'name' => $this->get_field_name( 'colors' )
            )
        );

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
        global $_chosen_attributes;

        if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
            return;
        }


        $current_term = is_tax() ? get_queried_object()->term_id : '';
        $current_tax  = is_tax() ? get_queried_object()->taxonomy : '';
        $taxonomy     = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : $this->settings['attribute']['std'];
        $query_type   = isset( $instance['query_type'] ) ? $instance['query_type'] : $this->settings['query_type']['std'];

        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name' :
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
                break;
            case 'id' :
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = 'ASC';
                $get_terms_args['menu_order'] = false;
                break;
            case 'menu_order' :
                $get_terms_args['menu_order'] = 'ASC';
                break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 < count( $terms ) ) {

            ob_start();

            $found = false;

            $this->widget_start( $args, $instance );

            // Force found when option is selected - do not force found on taxonomy attributes
            if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
                $found = true;
            }


            // List display
            echo '<ul>';

            foreach ( $terms as $term ) {

                // Get count based on current view - uses transients
                $_products_in_term = wc_get_term_product_ids( $term->term_id, $taxonomy );
                $option_is_set     = ( isset( $_chosen_attributes[ $taxonomy ] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) );

                // skip the term for the current archive
                if ( $current_term == $term->term_id ) {
                    continue;
                }

                // If this is an AND query, only show options with count > 0
                if ( 'and' == $query_type ) {

                    $count = sizeof( array_intersect( $_products_in_term, WC()->query->filtered_product_ids ) );

                    if ( 0 < $count && $current_term !== $term->term_id ) {
                        $found = true;
                    }

                    if ( 0 == $count && ! $option_is_set ) {
                        continue;
                    }

                    // If this is an OR query, show all options so search can be expanded
                } else {

                    $count = sizeof( array_intersect( $_products_in_term, WC()->query->unfiltered_product_ids ) );

                    if ( 0 < $count ) {
                        $found = true;
                    }
                }

                $arg = 'filter_' . sanitize_title( $instance['attribute'] );

                $current_filter = ( isset( $_GET[ $arg ] ) ) ? explode( ',', $_GET[ $arg ] ) : array();

                if ( ! is_array( $current_filter ) ) {
                    $current_filter = array();
                }

                $current_filter = array_map( 'esc_attr', $current_filter );

                if ( ! in_array( $term->term_id, $current_filter ) ) {
                    $current_filter[] = $term->term_id;
                }

                // Base Link decided by current page
                if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
                    $link = home_url();
                } elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
                    $link = get_post_type_archive_link( 'product' );
                } else {
                    $link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
                }

                // All current filters
                if ( $_chosen_attributes ) {
                    foreach ( $_chosen_attributes as $name => $data ) {
                        if ( $name !== $taxonomy ) {

                            // Exclude query arg for current term archive term
                            while ( in_array( $current_term, $data['terms'] ) ) {
                                $key = array_search( $current_term, $data );
                                unset( $data['terms'][$key] );
                            }

                            // Remove pa_ and sanitize
                            $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );

                            if ( ! empty( $data['terms'] ) ) {
                                $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                            }

                            if ( 'or' == $data['query_type'] ) {
                                $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                            }
                        }
                    }
                }

                // Min/Max
                if ( isset( $_GET['min_price'] ) ) {
                    $link = add_query_arg( 'min_price', $_GET['min_price'], $link );
                }

                if ( isset( $_GET['max_price'] ) ) {
                    $link = add_query_arg( 'max_price', $_GET['max_price'], $link );
                }

                // Orderby
                if ( isset( $_GET['orderby'] ) ) {
                    $link = add_query_arg( 'orderby', $_GET['orderby'], $link );
                }

                // Current Filter = this widget
                if ( isset( $_chosen_attributes[ $taxonomy ] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) {

                    $class = 'class="chosen"';

                    // Remove this term is $current_filter has more than 1 term filtered
                    if ( sizeof( $current_filter ) > 1 ) {
                        $current_filter_without_this = array_diff( $current_filter, array( $term->term_id ) );
                        $link = add_query_arg( $arg, implode( ',', $current_filter_without_this ), $link );
                    }

                } else {

                    $class = '';
                    $link = add_query_arg( $arg, implode( ',', $current_filter ), $link );

                }

                // Search Arg
                if ( get_search_query() ) {
                    $link = add_query_arg( 's', get_search_query(), $link );
                }

                // Post Type Arg
                if ( isset( $_GET['post_type'] ) ) {
                    $link = add_query_arg( 'post_type', $_GET['post_type'], $link );
                }

                // Query type Arg
                if ( $query_type == 'or' && ! ( sizeof( $current_filter ) == 1 && isset( $_chosen_attributes[ $taxonomy ]['terms'] ) && is_array( $_chosen_attributes[ $taxonomy ]['terms'] ) && in_array( $term->term_id, $_chosen_attributes[ $taxonomy ]['terms'] ) ) ) {
                    $link = add_query_arg( 'query_type_' . sanitize_title( $instance['attribute'] ), 'or', $link );
                }

                echo '<li ' . $class . '>';

                echo ( $count > 0 || $option_is_set ) ? '<a href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '">' : '<span>';

                if(isset($instance['colors'][$term->term_id])){
                    echo '<span style="background-color: '.$instance['colors'][$term->term_id].';"></span>';
                }

                echo $term->name;

                echo ( $count > 0 || $option_is_set ) ? '</a>' : '</span>';

                //echo ' <span class="count">(' . $count . ')</span></li>';

            }

            echo '</ul>';


            $this->widget_end( $args );

            if ( ! $found ) {
                ob_end_clean();
            } else {
                echo ob_get_clean();
            }
        }
    }
}


/**
 * Register Widget Color Filter widget
 *
 *
 */

register_widget('WC_Widget_Color_Filter');

