<?php
/**
 * The template for displaying comments.
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
        <div class="comment-title bg-gray">
            <div class="container">
                <h4 class="comment-text pull-left">
                    <?php
                    printf(
                        _nx( 'There are <span>One</span> comment', 'There are <span>%1$s</span> comments', get_comments_number(), 'comments title', 'mondova' ),
                        number_format_i18n( get_comments_number() )
                    );
                    ?>
                </h4>
                <div class="leave-comment pull-right">
                    <a href="#respond"><i class="arrow_right"></i> <?php esc_html_e('leave a comment', 'mondova') ?></a>
                </div>
            </div>
        </div>

        <div class="comment-list-wrap">

            <div class="container">


                <ol class="comment-list">
                    <?php
                    wp_list_comments( array(
                        'style'       => 'ul',
                        'short_ping'  => true,
                        'avatar_size' => 60,
                        'callback' => 'kt_comments'
                    ) );
                    ?>
                </ol><!-- .comment-list -->

                <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
                    <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                        <h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'storefront' ); ?></h1>
                        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'storefront' ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'storefront' ) ); ?></div>
                    </nav><!-- #comment-nav-above -->
                <?php endif; // check for comment navigation ?>


                <?php //kt_comment_nav(); ?>

            </div>
        </div>

    <?php endif; // have_comments() ?>

    <div class="container">
        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'adroit' ); ?></p>
        <?php endif; ?>
    </div>
    <?php


    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );

    $required = ' '.esc_html__('(required)', 'adroit');

    $new_fields = array(
        'author' => '<div class="comment_field_wrap"><div class="comment_field-column"><p class=" comment-form-author">' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  placeholder="'.esc_html__('Name', 'adroit').'"'. $aria_req . $html_req .'/></p></div>',
        'email'  => '<div class="comment_field-column"><p class="comment-form-email">' .
            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'.esc_html__('Email', 'adroit').'"'. $aria_req . $html_req.'/></p></div></div>',
        'url'    => '<p class="comment-form-url">' .
            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'.esc_html__('Website', 'adroit').'" /></p>',
    );

    $comments_args = array(
        'fields' => apply_filters( 'comment_form_default_fields', $new_fields ),
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="'.esc_html__('Your Comment', 'adroit').'"  aria-required="true" rows="6"></textarea></p>',
        'class_submit'      => 'btn btn-default btn-lg',
        'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title post-single-heading">',
    );

    ?>
    <div class="comment-form-wrap">
        <div class="container">
            <div class="comment-form-outer">
                <?php comment_form($comments_args); ?>
            </div>
        </div>
    </div>



</div><!-- .comments-area -->
