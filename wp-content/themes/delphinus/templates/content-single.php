<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8 col-xs-12 pull-right">
                <div class="single-post-content">
                    <header class="entry-header">
                        <?php
                            the_title( sprintf( '<h1 class="entry-title" itemprop="name headline">', esc_url( get_permalink() ) ), '</h1>' );
                            kt_post_meta();
                        ?>
                    </header><!-- .entry-header -->
                    <?php kt_post_thumbnail_image('full', 'img-responsive', false, false); ?>
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
            </div>
            <div class="col-sm-4 col-md-4 col-xs-12 single-left">
                <div class="single-left-content">
                    <div class="content-single-left">
                        <h3 class="title">Lifestyle</h3>
                        <div class="category-desciption">
                            <p>" Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero"</p>
                        </div>
                    </div>
                    <div class="content-single-left">
                        <h3 class="title"><?php esc_html_e('Social share', 'mondova') ?></h3>
                        <?php kt_share_box(); ?>
                    </div>
                    <div class="content-single-left">
                        <h3 class="title"><?php esc_html_e('Author', 'mondova') ?></h3>
                        <?php get_template_part( 'templates/author-bio' ); ?>
                    </div>
                    <div class="content-single-left">
                        <h3 class="title"><?php esc_html_e('Tag', 'mondova') ?></h3>
                        <?php kt_post_meta_tags(''); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
