<?php if ( kt_is_wc() && kt_option('header_wishlist', 1) && defined( 'YITH_WCWL' ) ) { ?>
    <li class="shopping-bag shopping-bag-wishlist">
        <?php kt_woocommerce_get_wishlist(); ?>
    </li>
<?php } ?>