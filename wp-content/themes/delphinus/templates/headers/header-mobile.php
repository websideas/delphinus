<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div id="header-content-mobile" class="clearfix">
    <div class="header-content-mobile-inner">
        <div class="branding branding-mobile">
            <?php
            $logo = kt_get_logo();
            $logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : '';
            ?>
            <p class="site-logo <?php echo esc_attr($logo_class); ?>">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <img src="<?php echo esc_url($logo['default']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
                    <?php  if($logo['retina']){ ?>
                        <img src="<?php echo esc_url($logo['retina']); ?>" class="retina-logo retina-default-logo" alt="<?php bloginfo( 'name' ); ?>" />
                    <?php } ?>
                </a>
            </p><!-- .site-logo -->
        </div><!-- .site-branding -->

        <div class="header-mobile-tools">

            <a title="Menu" href="#" id="hamburger-icon" class="">
                <span class="hamburger-icon-inner">
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </span>
            </a>

            <?php if ( kt_is_wc() && kt_option('header_cart', 1) ) { ?>
                <?php kt_cart_link('cart-mobile', '<i class="kt-icon-Shopping-Cart"></i>'); ?>
            <?php } ?>

        </div>
    </div>
</div>