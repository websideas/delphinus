<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



if ( ! is_active_sidebar( 'footer-column-1' ) && ! is_active_sidebar( 'footer-column-2' ) && ! is_active_sidebar( 'footer-column-3' ) && ! is_active_sidebar( 'footer-column-4' ))
    return;

?>
<footer id="footer-area">
    <div class="row no-gutters row-flex">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <div class="col-inner">
                <div class="footer-area-inner">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?php dynamic_sidebar('footer-column-1'); ?>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?php dynamic_sidebar('footer-column-2'); ?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <?php dynamic_sidebar('footer-column-3'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 footer-area-right">
            <div class="col-inner">
                <div class="footer-area-inner">
                    <?php dynamic_sidebar('footer-column-4'); ?>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #footer-area -->