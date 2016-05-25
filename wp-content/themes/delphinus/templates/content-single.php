<article id="post-<?php the_ID(); ?>" <?php post_class('single-post-wrap'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
    <?php kt_post_thumbnail_image('full', 'img-responsive', false, false); ?>
    <div class="single-post-content">
        <header class="entry-header">
            <?php
                the_title( sprintf( '<div class="entry-title hide" itemprop="name headline">', esc_url( get_permalink() ) ), '</div>' );
                kt_post_meta();
            ?>
        </header><!-- .entry-header -->
        <div class="entry-content clearfix" itemprop="articleBody">
            <?php the_content(); ?>
            <?php
            if( ! post_password_required( ) ):
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'delphinus' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'delphinus' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );
            endif;
            ?>
        </div><!-- .entry-content -->
    </div>
    <footer class="entry-footer">
        <?php
        kt_post_meta_tags('');

        if(kt_post_option(null, '_kt_social_sharing', 'single_share_box', 1)) {
            kt_share_box(null, 'square');
        }

        ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->

<?php


    /*

    if(kt_post_option(null, '_kt_prev_next', 'single_next_prev', 0)){
        kt_post_nav();
    }

    */
    if(kt_post_option(null, '_kt_author_info', 'single_author', 1)){
        // Author bio.
        get_template_part( 'templates/author-bio' );
    }

    if(kt_post_option(null, '_kt_related_acticles', 'single_related', 0)){
        kt_related_article(null, kt_option('single_related_type', 'categories'));
    }

?>