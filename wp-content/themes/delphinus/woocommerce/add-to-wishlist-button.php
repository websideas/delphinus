<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

global $product;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-product-id="<?php echo $product_id ?>" data-product-type="<?php echo $product_type?>" class="<?php echo $link_classes ?>" >
    <i class="icon_heart_alt"></i>
</a>