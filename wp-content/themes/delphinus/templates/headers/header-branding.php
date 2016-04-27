<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$logo = kt_get_logo();
$logo_class = ($logo['retina']) ? 'retina-logo-wrapper' : '';
$logo_class .= ($logo['light_retina']) ? ' retina-light-wrapper' : '';

?>

<div class="branding branding-default <?php echo esc_attr($logo_class); ?>">
    <?php $tag = ( is_front_page() && is_home() ) ? 'h1' : 'p'; ?>
    <<?php echo esc_attr($tag) ?> class="site-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url($logo['default']); ?>" class="default-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php  if($logo['retina']){ ?>
                <img src="<?php echo esc_url($logo['retina']); ?>" class="retina-logo retina-default-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php } ?>
            <img src="<?php echo esc_url($logo['light']); ?>" class="light-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php  if($logo['light_retina']){ ?>
                <img src="<?php echo esc_url($logo['light_retina']); ?>" class="retina-logo light-retina-logo" alt="<?php bloginfo( 'name' ); ?>" />
            <?php } ?>
        </a>
    </<?php echo esc_attr($tag) ?>><!-- .site-logo -->
    <div id="site-description"><?php bloginfo( 'description' ); ?></div>
</div><!-- .branding -->