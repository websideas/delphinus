<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h3 class="single-bottom-title">
            <?php printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'wingman' ), number_format_i18n( get_comments_number() ) ); ?>
        </h3>

        <div class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'div',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback' => 'kt_comments'
            ) );
            ?>
        </div><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'storefront' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'storefront' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'storefront' ) ); ?></div>
            </nav><!-- #comment-nav-above -->
        <?php endif; // check for comment navigation ?>

    <?php endif; // have_comments() ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wingman' ); ?></p>
    <?php endif; ?>

    <?php


    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );

    $required = ' '.esc_html__('(required)', 'wingman');

    $new_fields = array(
        'author' => '<p class="comment-form-author col-sm-4">' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  placeholder="'.esc_html__('Name', 'wingman').'"' . $aria_req . $html_req . ' /></p>',
        'email'  => '<p class="comment-form-email col-sm-4">' .
            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'.esc_html__('Email', 'wingman').'"' . $aria_req . $html_req . ' /></p>',
        'url'    => '<p class="comment-form-url col-sm-4">' .
            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'.esc_html__('Website', 'wingman').'" /></p>',
    );

    $comments_args = array(
        'label_submit'      => esc_html__( 'Send messages', 'wingman' ),
        'fields' => apply_filters( 'comment_form_default_fields', $new_fields ),
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="'.esc_html__('Your Comment', 'wingman').'"  aria-required="true" rows="6"></textarea></p>',
        'class_submit'      => 'btn btn-dark-b btn-lg',
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title single-bottom-title">',
        'title_reply_after'    => '</h3>',
    );

    ?>

    <?php comment_form($comments_args); ?>

</div><!-- .comments-area -->
