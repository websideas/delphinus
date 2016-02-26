<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
    <div class="blog-post-content">
        <?php kt_post_thumbnail_image('kt_classic'); ?>
        <?php kt_entry_date(); ?>
        <div class="blog-post-inner">
            <?php the_title( sprintf( '<h3 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            <?php kt_entry_meta(); ?>
            <div class="entry-content" itemprop="articleBody">
                <?php
                /* translators: %s: Name of current post */
                the_content( sprintf(
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mondova' ),
                    get_the_title()
                ) );

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'mondova' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'mondova' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );
                ?>
            </div><!-- .entry-content -->
            <!--<p class="entry-more">
                <?php
                printf( '<a href="%1$s" class="%2$s">%3$s</a>',
                    esc_url( get_permalink( get_the_ID() ) ),
                    'btn btn-default',
                    sprintf( esc_html__( 'Read more %s', 'mondova' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
                );
                ?>
            </p>-->
        </div>
    </div>
</article><!-- #post-## -->
