<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
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
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'mondova' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'mondova' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );
            endif;
            ?>
        </div><!-- .entry-content -->
    </div>

</article><!-- #post-## -->
