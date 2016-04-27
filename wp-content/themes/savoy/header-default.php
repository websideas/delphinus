<?php
	global $nm_theme_options, $nm_globals;
?>
                
    <!-- header -->
    <header id="nm-header" class="nm-header default clearfix" role="banner">
        <div class="nm-header-inner">
            <div class="nm-row">
            	<div class="col-xs-12">
                	
					<?php 
						// Header part: Logo
						get_header( 'part-logo' );
					?>
                                    
					<nav class="nm-main-menu">
						<ul id="nm-main-menu-ul" class="nm-menu">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location'	=> 'main-menu',
                                    'container'       	=> false,
                                    'fallback_cb'     	=> false,
                                    'items_wrap'      	=> '%3$s'
                                ) );
							?>
						</ul>
					</nav>
                    
                    <nav class="nm-right-menu">
                        <ul id="nm-right-menu-ul" class="nm-menu">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location'	=> 'right-menu',
                                    'container'       	=> false,
                                    'fallback_cb'     	=> false,
                                    'items_wrap'      	=> '%3$s'
                                ) );
								
								if ( nm_woocommerce_activated() && $nm_theme_options['menu_login'] ) :
                            ?>
                            <li class="nm-menu-login menu-item">
                            	<?php echo nm_get_myaccount_link(); ?>
							</li>
							<?php 
								endif;
								
								if ( $nm_globals['cart_link'] ) :
								
									$cart_url = ( $nm_globals['cart_panel'] ) ? '#' : WC()->cart->get_cart_url();
							?>
                            <li class="nm-menu-cart menu-item">
                                <a href="<?php echo esc_url( $cart_url ); ?>" id="nm-menu-cart-btn">
                                    <span><?php esc_html_e( 'Cart', 'nm-framework' ); ?></span>
                                    <?php echo nm_get_cart_contents_count(); ?>
                                </a>
                            </li>
                            <?php 
								endif; 
								
								if ( $nm_globals['header_shop_search'] ) :
							?>
                            <li class="nm-menu-search menu-item"><a href="#" id="nm-menu-search-btn"><i class="nm-font nm-font-search-alt flip"></i></a></li>
                            <?php endif; ?>
                            <li class="nm-menu-offscreen menu-item">
                                <?php echo nm_get_cart_contents_count(); ?>
                                
                                <a href="#" id="nm-slide-menu-button" class="clicked">
                                    <div class="nm-menu-icon">
                                        <span class="line-1"></span>
                                        <span class="line-2"></span>
                                        <span class="line-3"></span>
                                    </div>
								</a>
                            </li>
                        </ul>
                    </nav>
                
            	</div>
            </div>
        </div>
        
        <?php
        	// Shop search-form
			if ( $nm_globals['header_shop_search'] ) {
				wc_get_template( 'product-searchform_nm.php' );
			}
		?>
        
    </header>
    <!-- /header -->
                    