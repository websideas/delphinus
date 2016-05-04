<?php

    $layout = kt_option('footer_bottom_layout', 1);
?>

<?php if( is_active_sidebar( 'footer-bottom-1' ) || is_active_sidebar( 'footer-bottom-2' )|| is_active_sidebar( 'footer-bottom-3' )){ ?>
    <footer id="footer-bottom" class="footer-bottom-2">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-bottom-1') ?>
                </div>
                <div class="col-md-3">
                    <?php dynamic_sidebar('footer-bottom-2') ?>
                </div>
                <div class="col-md-6">
                    <?php dynamic_sidebar('footer-bottom-3') ?>
                </div>
            </div>

        </div><!-- .container -->
    </footer><!-- #footer-bottom -->
<?php } ?>