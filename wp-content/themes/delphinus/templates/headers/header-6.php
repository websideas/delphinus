<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>
<div class="navbar-container sticky-header sticky-header-down">
    <div class="apply-sticky">
        <div class="header-sticky-background"></div>
        <div class="navbar-container-inner clearfix">
            <div class="navbar-container-content">
                <?php get_template_part( 'templates/headers/header',  'branding'); ?>
                <nav class="main-nav" id="nav">
                    <div class="container">
                        <div class="main-nav-outer">
                            <?php
                                get_template_part( 'templates/headers/header',  'menu');
                                get_template_part( 'templates/headers/header',  'social');
                            ?>
                        </div>
                    </div>
                    <ul id="main-nav-tool">
                        <?php get_template_part( 'templates/headers/header',  'search'); ?>
                    </ul><!-- #main-nav-tool -->
                </nav><!-- #nav -->
            </div>
        </div>
    </div>
</div>
