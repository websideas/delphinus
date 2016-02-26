<?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
    <div class="shopping-bag shopping-bag-cart">
        <?php kt_woocommerce_get_cart(); ?>
    </div>
<?php } ?>