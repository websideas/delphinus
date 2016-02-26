<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

if ( empty( $woocommerce_loop['effect'] ) ) {
    $woocommerce_loop['effect'] = 1;
}
if ( empty( $woocommerce_loop['type'] ) ) {
    $woocommerce_loop['type'] = 'standard';
}


// Extra post classes
$classes = array(
    'product',
    'product-effect-'.$woocommerce_loop['effect'],
    'product-type-'.$woocommerce_loop['type']
);
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
    $classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
    $classes[] = 'last';
}

$bootstrapColumn = round( 12 / $woocommerce_loop['columns'] );

$classes[] = sprintf('col-lg-%1$s col-md-%1$s col-sm-%2$s', $bootstrapColumn, 6);




?>
<li <?php post_class( $classes ); ?>>


    <div class="product-content">



        <?php

        if($woocommerce_loop['type'] == 'standard'){
            $cat_count = sizeof( get_the_terms( $product->ID, 'product_cat' ) );
            echo $product->get_categories( ' / ', '<span class="posted_in">', '</span>' );
        }

        if($woocommerce_loop['effect'] == 3){
             ?>
            <div title="Rated 4 out of 5" class="star-rating">
                <span style="width:80%"><span class="rating">4</span> out of 5</span>
            </div>
            <a href="woocommerce-product-detailed1.php" class="title-link">Spada Enforcer WP Glove</a>
        <?php
        }

        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        do_action( 'woocommerce_before_shop_loop_item' );

        /**
         * woocommerce_before_shop_loop_item_title hook.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );

        /**
         * woocommerce_after_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_close - 5
         * @hooked woocommerce_template_loop_add_to_cart - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        ?>

    </div>
    <div class="product-details">
        <?php
        /**
         * woocommerce_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );

        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
    </div>

</li>
