<?php
	/*
	 *	WooCommerce product details meta box
	 */
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	
	/* Product details: Register meta box */
	function nm_product_details_meta_box_register() {
		add_meta_box(
			'nm-product-meta',
			__( 'Product Image Swap', 'nm-framework-admin' ),
			'nm_product_details_meta_box_output',
			'product',
			'side',
			'low'
		);
	}
	add_action( 'add_meta_boxes', 'nm_product_details_meta_box_register', 100 ); // Note: Using "100" (priority) to place the meta box after the last WooCommerce meta box
	
	
	/* Product details: Output meta box content */
	function nm_product_details_meta_box_output( $post ) {
		// Nonce field for validation in "nm_product_details_meta_box_save()"
		wp_nonce_field( 'nm-framework', 'nm_nonce_product_details_meta_box' );
		
		// Get post meta
		$image_swap = get_post_meta( $post->ID, 'nm_product_image_swap', true );
		
		// Is post meta saved?
		$input_checked_attr = ( $image_swap ) ? ' checked="checked"' : '';
		
		echo '
			<div>
				<label for="nm_product_image_swap">
					<input type="checkbox" id="nm_product_image_swap" name="nm_product_image_swap" value="1"' . $input_checked_attr . '>' . 
					__( 'Swap to first gallery image on hover', 'nm-framework-admin' ) . '
				</label>
			</div>';
	}
	
	
	/* Product details: Saved meta box data */
	function nm_product_details_meta_box_save( $post_id ) {
		// Verify this came from our meta box with proper authorization (save_post action can be triggered at other times)
		if ( ! nm_verify_save_action( $post_id, 'nm_nonce_product_details_meta_box' ) ) {
			return;
		}
		
		// Verified, save post meta
		if ( isset( $_POST['nm_product_image_swap'] ) ) {
			// Make sure value is an integer
			$image_swap_setting = absint( $_POST['nm_product_image_swap'] );
			
			update_post_meta( $post_id, 'nm_product_image_swap', $image_swap_setting );
		} else {
			delete_post_meta( $post_id, 'nm_product_image_swap' );
		}
	}
	add_action( 'save_post', 'nm_product_details_meta_box_save' );
			