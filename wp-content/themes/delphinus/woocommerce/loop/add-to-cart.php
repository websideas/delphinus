<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;


$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $product->product_type, $product );

// Variable product handling
if ( 'variable' === $add_to_cart_handler || 'grouped' === $add_to_cart_handler) {
    $icon = 'icon_cart_alt';
    // Grouped Products
} else {
    $icon = 'icon_bag_alt';
}

echo '<div class="wc-addtocart-wrap" title="'.esc_attr($product->add_to_cart_text()).'" data-toggle="tooltip" data-added="'.esc_attr(esc_html__('Added to cart', 'mondova')).'" data-addbutton="'.esc_attr($product->add_to_cart_text()).'">';
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		'<i class="'.$icon.'"></i><span>'.esc_html( $product->add_to_cart_text() ).'</span>'
	),
$product );
echo "</div>";
