<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
	<div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>

			<ol class="comment-list">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper">
			<div id="review_form" class="comment-respond">
				<?php
					$commenter = wp_get_current_commenter();


                    $new_fields = array(
                        'author' => '<p class=" comment-form-author">' .
                            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  placeholder="'.esc_html__('Name', 'adroit').'" aria-required="true"/></p>',
                        'email'  => '<p class="comment-form-email">' .
                            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'.esc_html__('Email', 'adroit').'" aria-required="true"/></p>'
                    );

					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'woocommerce' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
						'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => $new_fields,
                        'class_submit'      => 'btn btn-default btn-lg',
						'label_submit'  => __( 'Add Review', 'mondova' ),
						'logged_in_as'  => '',
                        'submit_button' => '',
                        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="'.esc_html__('Your Review', 'adroit').'"  aria-required="true" rows="6"></textarea></p>'
					);

					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
					}

                    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                        $comment_form['submit_button'] = '<span class="comment-form-rating"><select name="rating" id="rating">
                                <option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
                                <option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
                                <option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
                                <option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
                                <option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
                                <option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
                            </select></span>';
                    }

                    $comment_form['submit_button'] .= '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
