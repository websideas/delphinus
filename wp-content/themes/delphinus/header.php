<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo KT_THEME_JS; ?>html5shiv.min.js"></script>
      <script src="<?php echo KT_THEME_JS; ?>respond.min.js"></script>
    <![endif]-->

    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>
</head>
<body <?php body_class( ); ?>>
    <?php
        $header_layout = kt_get_header_layout();
        $header_position = kt_get_header_position();
    ?>
    <?php
    do_action( 'kt_body_top' ); ?>

    <div id="page_outter">
        <div id="page" class="hfeed site">
            <div id="wrapper-content" class="content-header-<?php echo esc_attr($header_layout); ?>">

                <?php
                do_action( 'kt_before_header' ); ?>

                <div class="header-container header-layout<?php echo esc_attr($header_layout); ?> <?php echo esc_attr(apply_filters('kt_header_class', '', $header_layout)); ?>">

                    <?php
                    if($header_position == 'below'){
                        do_action( 'kt_slideshows_position' );
                    } ?>

                    <header id="header" class="<?php echo apply_filters('theme_header_content_class', 'header-content', $header_layout) ?>">
                        <?php get_template_part( 'templates/headers/header', $header_layout); ?>
                    </header><!-- #header -->

                    <?php
                    if($header_position != 'below'){
                        do_action( 'kt_slideshows_position' );
                    } ?>
                </div><!-- .header-container -->

                <?php
                do_action( 'kt_before_content' ); ?>

                <div id="content" class="<?php echo apply_filters('kt_content_class', 'site-content') ?>">
                    <?php
                    do_action( 'kt_content_top' ); ?>