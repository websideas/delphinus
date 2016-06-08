<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div class="<?php echo esc_attr(apply_filters('kt_navbar_container', 'navbar-container')); ?>">
    <div class="apply-sticky">
        <div class="header-sticky-background"></div>
        <div class="navbar-container-inner clearfix">
            <div class="navbar-container-content">

                <nav class="main-nav" id="nav">
                    <div class="container">
                        <?php get_template_part( 'templates/headers/header',  'branding'); ?>
                        <div class="main-nav-outer">
                            <?php
                                get_template_part( 'templates/headers/header',  'menu');
                                get_template_part( 'templates/headers/header',  'social');
                            ?>
                        </div>
                        <ul id="main-nav-tool">
                            <?php get_template_part( 'templates/headers/header',  'search'); ?>
                        </ul><!-- #main-nav-tool -->
                    </div>
                </nav><!-- #nav -->
            </div>
        </div>
    </div>
</div>
