<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
?>
                <?php do_action( 'kt_content_bottom' ); ?>
            </div><!-- #content -->
        </div><!-- #wrapper-content -->

        <?php if(kt_option('footer', true)){ ?>
            <?php do_action( 'kt_before_footer' ); ?>
            <div id="footer" class="site-footer">
                <?php $footer_top = kt_footer_top(); ?>
                <?php if($footer_top){ ?>
                    <footer id="footer-top">
                        <div class="container">
                            <?php dynamic_sidebar('footer-top') ?>
                        </div><!-- .container -->
                    </footer><!-- #footer-top -->
                <?php } ?>

                <?php

                if(kt_option('footer_widgets', true)){
                    $widgets_layout = kt_option('footer_widgets_layout', 'featured');
                    $layout = ($widgets_layout == 'featured') ? 'widgets-featured' : 'widgets';
                    get_template_part( 'templates/footers/footer', $layout);
                }

                if(kt_option('footer_bottom', false)){
                    get_template_part( 'templates/footers/footer', 'bottom');
                }

                ?>

                <?php if(kt_option('footer_copyright', true)){ ?>
                    <footer id="footer-copyright">
                        <div class="container">
                            <?php
                            get_template_part( 'templates/footers/footer', kt_option('footer_copyright_layout', 'centered') );
                            ?>
                        </div><!-- .container -->
                    </footer><!-- #footer-copyright -->
                <?php } ?>
            </div><!-- #footer -->

            <?php do_action( 'kt_after_footer' ); ?>
        <?php } ?>
    </div><!-- #page -->
</div><!-- #page_outter -->


<?php wp_footer(); ?>
</body>
</html>
