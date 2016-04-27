<?php
	/*
	 *	Default theme options
	 *	
	 *	Note: To re-generate default options use "var_export($nm_theme_options)" on -unchanged- options
	 */
	
	$default_options = array (
		'custom_title' => 1,
		'wp_admin_bar' => 0,
		'top_bar' => 0,
		'top_bar_text' => 'Welcome to our shop!',
		'header_layout' => 'centered',
		'header_fixed' => 1,
		'home_header_transparent' => 0,
		'logo_height' => 16,
		'logo_height_tablet' => 16,
		'logo_height_mobile' => 16,
		'header_spacing_top' => 17,
		'header_spacing_bottom' => 17,
		'header_border' => 1,
		'home_header_border' => 1,
		'shop_header_border' => 1,
		'menu_login' => 1,
		'menu_cart' => '1',
		'widget_panel_color' => 'dark',
		'footer_sticky' => 1,
		'footer_widgets_layout' => 'boxed',
		'footer_widgets_border' => 1,
		'footer_widgets_columns' => 2,
		'footer_bar_content' => 'copyright_text',
		'main_font_color' => '#777777',
		'highlight_color' => '#dc9814',
		'main_background_color' => '#ffffff',
		'main_background_image_type' => 'fixed',
		'top_bar_font_color' => '#eeeeee',
		'top_bar_background_color' => '#282828',
		'header_navigation_color' => '#707070',
		'header_background_color' => '#ffffff',
		'header_home_background_color' => '#ffffff',
		'header_float_background_color' => '#ffffff',
		'header_slide_menu_open_background_color' => '#ffffff',
		'header_login_background_color' => '#f5f5f5',
		'dropdown_menu_font_color' => '#a0a0a0',
		'dropdown_menu_font_highlight_color' => '#eeeeee',
		'dropdown_menu_background_color' => '#282828',
		'footer_widgets_font_color' => '#777777',
		'footer_widgets_highlight_font_color' => '#dc9814',
		'footer_widgets_background_color' => '#ffffff',
		'footer_bar_font_color' => '#aaaaaa',
		'footer_bar_highlight_font_color' => '#eeeeee',
		'footer_bar_menu_border_color' => '#3a3a3a',
		'footer_bar_background_color' => '#282828',
		'single_product_background_color' => '#eeeeee',
		'sale_flash_font_color' => '#373737',
		'sale_flash_background_color' => '#ffffff',
		'main_font_source' => '1',
		'main_font' => 
			array (
				'font-family' => 'Open Sans',
				'subsets' => '',
			),
		'main_font_typekit_kit_id' => '',
		'main_typekit_font' => '',
		'fontdeck_project_id' => '',
		'fontdeck_css' => '',
		'secondary_font_source' => '0',
		'secondary_font' => 
			array (
				'font-family' => 'Open Sans',
				'subsets' => '',
			),
		'secondary_font_typekit_kit_id' => '',
		'secondary_typekit_font' => '',
		'blog_layout' => 'grid',
		'blog_categories_layout' => 'list',
		'blog_categories_columns' => 4,
		'blog_categories_toggle' => 0,
		'blog_show_full_posts' => 0,
		'blog_gallery' => 0,
		'single_post_sidebar' => 'none',
		'custom_wp_gallery' => 0,
		'shop_content_home' => '0',
		'shop_header' => 1,
		'shop_categories' => 1,
		'shop_categories_orderby' => 'slug',
		'shop_categories_order' => 'asc',
		'shop_filters' => 0,
		'shop_filters_enable_ajax' => '1',
		'shop_search' => 'shop',
		'shop_search_min_char' => 2,
		'shop_search_by_titles' => 0,
		'shop_category_description' => 0,
		'shop_category_description_layout' => 'clean',
		'shop_columns' => 4,
		'products_per_page' => 12,
		'product_sale_flash' => 'pct',
		'product_image_lazy_loading' => 1,
		'product_hover_image_global' => 1,
		'shop_infinite_load' => 'button',
		'shop_scroll_offset' => 70,
		'product_quickview' => 1,
		'product_quickview_summary_layout' => 'align-bottom',
		'product_image_column_size' => 6,
		'product_image_max_size' => 500,
		'product_image_zoom' => 1,
		'single_product_sale_flash' => '0',
		'product_description_layout' => 'boxed',
		'social_media_facebook' => '',
		'social_media_instagram' => '',
		'social_media_twitter' => '',
		'social_media_googleplus' => '',
		'social_media_linkedin' => '',
		'social_media_pinterest' => '',
		'social_media_rss' => '',
		'social_media_tumblr' => '',
		'social_media_vimeo' => '',
		'social_media_youtube' => '',
		'custom_css' => '',
		'custom_js' => '',
	);
	
	// Set the options global
	global $nm_theme_options;
	$nm_theme_options = $default_options;
	
	// Save default options to the database
	update_option( 'nm_theme_options', $default_options );
	