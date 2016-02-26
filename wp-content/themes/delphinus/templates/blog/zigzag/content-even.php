<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">

    <div class="row no-gutters row-flex row-content-middle">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="col-inner">
                <div class="blog-post-infos">
                    <?php kt_post_thumbnail_image('kt_zigzag'); ?>
                    <?php kt_entry_meta(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="col-inner">
                <div class="blog-post-content">
                    <?php the_title( sprintf( '<h2 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
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
        </div>
    </div>
</article><!-- #post-## -->
