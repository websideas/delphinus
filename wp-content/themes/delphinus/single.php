<?php
/**
 * The template for displaying all single posts.
 *
 */

$sidebar = array(
    'sidebar' => '',
    'sidebar_area' => 'primary-widget-area',
);

get_header(); ?>

<div id="primary" class="content-area">
    <div  id="main" class="site-main" role="main">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
            do_action( 'kt_single_post_before' );

            get_template_part( 'templates/content', 'single' );

            kt_post_nav();

            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

            do_action( 'kt_single_post_after' );
            ?>
        <?php endwhile; // end of the loop. ?>
    </div><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>


