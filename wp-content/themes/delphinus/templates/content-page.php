<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header hide">
        <div class="entry-title"><?php the_title(); ?></div>
    </header><!-- .entry-header -->
    <div id="page-entry-content" class="entry-content">
        <?php
        the_content();
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'delphinus' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'delphinus' ) . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <?php
    /*
    edit_post_link(
        sprintf(
            wp_kses(__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'delphinus' ), array( 'span' => array('class' => true) ) ),
            get_the_title()
        ),
        '<footer class="entry-footer"><span class="edit-link">',
        '</span></footer><!-- .entry-footer -->'
    );
    */
    ?>

</div><!-- #post-## -->
