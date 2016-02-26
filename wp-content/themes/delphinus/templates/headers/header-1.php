<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>


<div id="header-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 header-left">
                <?php get_template_part( 'templates/headers/header',  'topnav'); ?>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center">
                <?php get_template_part( 'templates/headers/header',  'branding'); ?>
            </div>
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 header-right">
                <?php get_template_part( 'templates/headers/header',  'cart'); ?>
                <?php get_template_part( 'templates/headers/header',  'wishlist'); ?>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div><!-- .container -->
</div><!-- #header-content -->

<div class="navbar-container sticky-header">
    <div class="apply-sticky">
        <div class="header-sticky-background bg-white"></div>
        <div class="container">
            <nav class="main-nav" id="nav">
                <div class="main-nav-inner">
                    <?php get_template_part( 'templates/headers/header',  'menu'); ?>
                </div>
            </nav><!-- #nav -->
        </div>
    </div>
</div>
