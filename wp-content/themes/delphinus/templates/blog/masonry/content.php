<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
    <div class="blog-post-content">
        <?php kt_post_thumbnail_image('kt_masonry'); ?>
        <?php kt_entry_date(); ?>
        <div class="blog-post-inner">
            <?php the_title( sprintf( '<h2 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php kt_entry_meta(); ?>
            <?php kt_entry_excerpt(); ?>
            <p class="entry-more">
                <?php
                printf( '<a href="%1$s" class="%2$s">%3$s</a>',
                    esc_url( get_permalink( get_the_ID() ) ),
                    'btn btn-default',
                    sprintf( esc_html__( 'Read more %s', 'mondova' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
                );
                ?>
            </p>
        </div>
    </div>
</article><!-- #post-## -->
