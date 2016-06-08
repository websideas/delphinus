<?php


// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/*
 * Set up the content width value based on the theme's design.
 *
 * @see kt_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 1140;


add_action( 'after_setup_theme', 'kt_theme_setup' );
if ( ! function_exists( 'kt_theme_setup' ) ):

function kt_theme_setup() {
    /**
     * Editor style.
     */
    add_editor_style( array( 'assets/css/editor-style.css') );
    
    /**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

    /*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    /**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array('gallery', 'quote', 'video', 'audio') );

    /*
    * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
	 */
	add_theme_support( 'title-tag' );
    
    /**
	 * Allow shortcodes in widgets.
	 *
	 */
	add_filter( 'widget_text', 'do_shortcode' );
    
    
    /**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

    if (function_exists( 'add_image_size' ) ) {
        add_image_size( 'kt_grid', 570, 380, true);
        add_image_size( 'kt_masonry', 570);
        add_image_size( 'kt_square', 600, 600, true);
        add_image_size( 'kt_list', 700, 570, true);
        add_image_size( 'kt_classic', 1140, 600, true );
        add_image_size( 'kt_small', 150, 150, true );
        add_image_size( 'kt_widgets', 100, 75, true );
    }
    
    load_theme_textdomain( 'delphinus', KT_THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => esc_html__('Main Navigation Menu', 'delphinus'),
        'footer'	  => esc_html__( 'Footer Navigation Menu', 'delphinus' ),
        'vertical'	  => esc_html__( 'Vertical Navigation Menu', 'delphinus' ),
    ));

}
endif;



/**
 * Add stylesheet and script for frontend
 *
 * @since       1.0
 * @return      void
 * @access      public
 */

function kt_add_scripts() {

    wp_enqueue_script( 'html5shiv', KT_THEME_JS.'html5shiv.min.js' );
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

    wp_enqueue_script( 'respond', KT_THEME_JS . 'respond.min.js' );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

    wp_enqueue_style( 'bootstrap', KT_THEME_LIBS . 'bootstrap/css/bootstrap.css', array());
    wp_enqueue_style( 'font-awesome', KT_THEME_LIBS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'kt-delphinus-font', KT_THEME_LIBS . 'delphinus/style.min.css', array());

    wp_enqueue_style( 'kt-plugins', KT_THEME_CSS . 'plugins.css', array());


    if(kt_is_wc()){
        wp_enqueue_style( 'kt-woocommerce', KT_THEME_CSS . 'woocommerce.css' );
    }

	// Load our main stylesheet.
    wp_enqueue_style( 'kt-main', KT_THEME_CSS . 'style.css');
    wp_enqueue_style( 'kt-queries', KT_THEME_CSS . 'queries.css');

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'kt-ie', KT_THEME_CSS . 'ie.css');
	wp_style_add_data( 'kt-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$use_loader = kt_option( 'use_page_loader', 0 );
    if( $use_loader ){
        wp_enqueue_script( 'kt-pace', KT_THEME_JS . 'pace.min.js', array( 'jquery' ), null );
    }

    wp_enqueue_script( 'bootstrap', KT_THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-plugins', KT_THEME_JS . 'plugins.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-main-script', KT_THEME_JS . 'functions.js', array( 'jquery', 'mediaelement', 'wp-mediaelement' ), null, true );

    wp_localize_script( 'kt-main-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
    ));

    if(kt_is_wc()){


        $ajax_filter = 0;

        $shop_header = kt_option('shop_header_tool_bar', 1);
        if($shop_header == 2){
            if($shop_header_ajax = kt_option('shop_header_ajax', 1)){
                $ajax_filter = 1;
            }
        }

        $woo_attr = array(
            'day_str' => esc_html__('Days', 'delphinus'),
            'hour_str' => esc_html__('Hours', 'delphinus'),
            'min_str' => esc_html__('Min', 'delphinus'),
            'sec_str' => esc_html__('Secs', 'delphinus'),
            'ajax_filter' => $ajax_filter
        );

        wp_enqueue_script( 'kt-woocommerce', KT_THEME_JS . 'woocommerce.js', array( 'jquery' ), null, true );
        wp_localize_script( 'kt-woocommerce', 'kt_woocommerce', $woo_attr);
    }

}
add_action( 'wp_enqueue_scripts', 'kt_add_scripts' );


/**
 * Theme Custom CSS
 *
 * @since       1.0
 * @return      void
 * @access      public
 */
function kt_setting_script() {

    $advanced_css = kt_option('advanced_editor_css');
    $css = $advanced_css;

    $styling_link = kt_option('styling_link');
    if($styling_link['hover']){
        $css .= 'a:hover,a:focus{color: '.$styling_link['hover'].';}';
    }
    if($styling_link['active']){
        $css .= 'a:active{color: '.$styling_link['active'].';}';
    }

    $is_shop = false;
    if(is_archive()){
        if(kt_is_wc()){
            if(is_shop()){
                $is_shop = true;
            }
        }
    }

    if(is_page() || is_singular() || $is_shop){

        global $post;
        $post_id = $post->ID;
        if($is_shop){
            $post_id = get_option( 'woocommerce_shop_page_id' );
        }

        $pageh_spacing = rwmb_meta('_kt_page_top_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '.content-area-inner{padding-top: '.$pageh_spacing.';}';
        }
        $pageh_spacing = rwmb_meta('_kt_page_bottom_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '.content-area-inner{padding-bottom:'.$pageh_spacing.';}';
        }

        $pageh_top = rwmb_meta('_kt_page_header_top', array(), $post_id);
        if($pageh_top != ''){
            $css .=  'div.page-header{padding-top: '.$pageh_top.';}';
        }

        $pageh_bottom = rwmb_meta('_kt_page_header_bottom', array(), $post_id);
        if($pageh_bottom != ''){
            $css .=  'div.page-header{padding-bottom: '.$pageh_bottom.';}';
        }

        $pageh_title_color = rwmb_meta('_kt_page_header_title_color', array(), $post_id);
        if($pageh_title_color != ''){
            $css .= 'div.page-header .page-header-title{color:'.$pageh_title_color.';}';
        }

        $pageh_subtitle_color = rwmb_meta('_kt_page_header_subtitle_color', array(), $post_id);
        if($pageh_subtitle_color != ''){
            $css .= 'div.page-header .page-header-subtitle{color:'.$pageh_subtitle_color.';}';
        }

        $pageh_breadcrumbs_color = rwmb_meta('_kt_page_header_breadcrumbs_color', array(), $post_id);
        if($pageh_breadcrumbs_color != ''){
            $css .= 'div.page-header .woocommerce-breadcrumb{color:'.$pageh_breadcrumbs_color.';}';
        }

        $css .= kt_render_custom_css('_kt_page_header_background', 'div.page-header', $post_id);

    }

    if($navigation_space = kt_option('navigation_space', 20)){
        $css .= '#nav #main-navigation > li + li{margin-left: '.$navigation_space.'px;}';
    }

    if($mega_border_color = kt_option('mega_border_color', '#ebebeb')){
        $mega_border_arr = array(
            '#nav #main-navigation > li .kt-megamenu-wrapper.megamenu-layout-table > ul > li > ul > li',
            '#nav #main-navigation > li .kt-megamenu-wrapper > ul > li > a',
            '#nav #main-navigation > li .kt-megamenu-wrapper > ul > li > span',
            '#nav #main-navigation > li .kt-megamenu-wrapper > ul > li .widget-title',
            '#nav #main-navigation > li .kt-megamenu-wrapper.megamenu-layout-table > ul > li'
        );
        $css .= implode($mega_border_arr, ',').'{border-color: '.$mega_border_color.';}';
    }

    if($toolbar_color = kt_option('header_toolbar_border_color', '#ebebeb')){
        $toolbar_color_arr = array(
            '.topbar',
            '.top-navigation > li',
            '.header-container.header-layout8 .top-navigation > li:first-child',
            '.header-container:not(.header-layout8) .topbar .topbar-right .top-navigation > li:first-child',
        );
        $css .= implode($toolbar_color_arr, ',').'{border-color: '.$toolbar_color.';}';
    }

    if($toolbar_color_light = kt_option('header_toolbar_light_border_color', array( 'color' => '#f6f6f6', 'alpha' => '.2' ))){
        $toolbar_color_light_arr = array(
            '.header-transparent.header-light .topbar',
            '.header-transparent.header-light .top-navigation > li',
            '.header-transparent.header-light.header-container.header-layout8 .top-navigation > li:first-child',
            '.header-transparent.header-light.header-container:not(.header-layout8) .topbar .topbar-right .top-navigation > li:first-child',
        );
        $css .= implode($toolbar_color_light_arr, ',').'{border-color: '.kt_hex2rgba($toolbar_color_light['color'], $toolbar_color_light['alpha']).';}';
    }

    if($navigation_height = kt_option('navigation_height', 102)){
        if(isset($navigation_height['height'])){
            $navigation_arr = array(
                '#nav #main-nav-socials > li > a',
                '#nav #main-nav-wc > li > a',
                '#nav #main-nav-tool > li > a',
                '#nav #main-navigation > li > a',
            );
            $css .= implode($navigation_arr, ',').'{line-height: '.intval($navigation_height['height']).'px;}';
        }
    }


    if($navigation_height_fixed = kt_option('navigation_height_fixed', 102)){
        if(isset($navigation_height_fixed['height'])){
            $navigation_fixed_arr = array(
                '.is-sticky .apply-sticky #nav #main-nav-socials > li > a',
                '.is-sticky .apply-sticky #nav #main-nav-wc > li > a',
                '.is-sticky .apply-sticky #nav #main-nav-tool > li > a',
                '.is-sticky .apply-sticky #nav #main-navigation > li > a',
            );
            $css .= implode($navigation_fixed_arr, ',').'{line-height: '.intval($navigation_height_fixed['height']).'px;}';
        }
    }

    $header_sticky_opacity = kt_option('header_sticky_opacity', 0.8);
    $css .= '.header-sticky-background{opacity:'.$header_sticky_opacity.';}';

    $css .= '@media (max-width: 600px){body.opened-nav-animate.admin-bar #wpadminbar{margin-top:-46px}}';

    wp_add_inline_style( 'kt-main', $css );
}
add_action('wp_enqueue_scripts', 'kt_setting_script');


if ( ! function_exists( 'kt_excerpt_more' ) ) :
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ...
     *
     * @param string $more Default Read More excerpt link.
     * @return string Filtered Read More excerpt link.
     */
    function kt_excerpt_more( $more ) {
        return ' &hellip; ';
    }
    add_filter( 'excerpt_more', 'kt_excerpt_more' );
endif;


if ( ! function_exists( 'kt_excerpt_length' ) ) :
    /**
     * Control the number of  excerpt length
     * @return string
     *
     *
     */

    function kt_excerpt_length( ) {
        if(is_search()){
            $excerpt_length = kt_option('search_excerpt_length', 35);
        }else{
            $excerpt_length = kt_option('archive_excerpt_length', 40);
        }
        return $excerpt_length;
    }
    add_filter( 'excerpt_length', 'kt_excerpt_length');
endif;

if ( ! function_exists( 'kt_posts_per_page' ) ) :
    /**
     * Control the number of posts per page
     */
    function kt_posts_per_page( $query ) {
        if ( $query->is_main_query() && !is_admin()) {
            if(isset($_REQUEST['per_page'])){
                $posts_per_page = $_REQUEST['per_page'];
            }elseif(is_search()){
                $posts_per_page = kt_option('search_posts_per_page', 9);
            }elseif($query->is_category() || $query->is_home() || $query->is_tag() || $query->is_posts_page()){
                $posts_per_page = kt_option('archive_posts_per_page', 14);
            }

            if(isset($posts_per_page)){
                set_query_var('posts_per_page', $posts_per_page);
            }
        }
    }
    add_action( 'pre_get_posts', 'kt_posts_per_page' );
endif;
/**
 *
 * Custom call back function for default post type
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function kt_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

        <li id="comment-<?php comment_ID(); ?>" <?php comment_class( '' ); ?>>
            <div class="comment-body">
                <?php esc_html_e( 'Pingback:', 'delphinus' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'delphinus' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

	<?php else : ?>

        <li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
            <div  id="comment-<?php comment_ID(); ?>" class="comment-item clearfix">

                <div class="comment-avatar">
                    <?php echo get_avatar($comment->comment_author_email, $size='100', $default='' ); ?>
                </div>
                <div class="comment-content">
                    <div class="comment-meta">
                        <h5 class="author_name">
                            <?php comment_author_link(); ?>
                        </h5>
                        <span class="comment-date">
                            <?php printf( _x( '%s ago', '%s = human-readable time difference', 'delphinus' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                        </span>
                    </div>
                    <div class="comment-entry entry-content">
                        <?php comment_text() ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.', 'delphinus') ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="comment-actions">
                        <?php edit_comment_link( '<span class="icon-pencil"></span> '.esc_html__('Edit', 'delphinus'),'  ',' ') ?>
                        <?php comment_reply_link( array_merge( $args,
                            array('depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'reply_text' =>'<span class="icon-action-undo"></span> '.esc_html__('Reply','delphinus')
                            ))) ?>
                    </div>
                </div>
            </div>
        <?php
    endif;
}


if ( ! function_exists( 'kt_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     */
    function kt_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation clearfix">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'delphinus' ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Older Comments', 'delphinus' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( '<i class="fa fa-angle-double-right"></i> '.esc_html__( 'Newer Comments',  'delphinus' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;

                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
endif;


if ( ! function_exists( 'kt_post_thumbnail_image' ) ) {
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     */
    function kt_post_thumbnail_image($size = 'post-thumbnail', $class_img = '', $link = true, $placeholder = false, $echo = true) {
        if ( is_attachment()) {
            return;
        }
        $class = 'entry-thumbnail';
        $attrs = '';
        if( $link ){
            $tag = 'a';
            $attrs .= 'href="'.get_the_permalink().'"';
        } else{
            $tag = 'div';
        }
        if(!has_post_thumbnail() && $placeholder){
            $class .= ' no-image';
        }

        if(!$echo){
            ob_start();
        }

        if(has_post_thumbnail() || $placeholder){ ?>
            <<?php echo $tag ?> <?php echo $attrs ?> class="<?php echo esc_attr($class); ?>">
            <?php if(has_post_thumbnail()){ ?>
                <?php the_post_thumbnail( $size, array( 'alt' => get_the_title(), 'class' => $class_img ) ); ?>
            <?php }elseif($placeholder){ ?>
                <?php
                    $image = apply_filters( 'kt_placeholder', $size );
                    printf(
                        '<img src="%s" alt="%s" class="%s"/>',
                        $image,
                        esc_html__('No image', 'delphinus'),
                        $class_img.' no-image'
                    )
                ?>
            <?php } ?>
            </<?php echo $tag ?>><!-- .entry-thumb -->
        <?php }

        if(!$echo){
            return ob_get_clean();
        }
    }
}

if ( ! function_exists( 'kt_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function kt_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" itemprop="datePublished">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			_x( 'Posted on %s', 'post date', 'delphinus' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			_x( 'by %s', 'post author', 'delphinus' ),
			'<span class="vcard author"><span class="fn" itemprop="author"><a class="url fn n" rel="author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>'
		);

		echo apply_filters( 'kt_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>', $posted_on, $byline );

	}
}


if ( ! function_exists( 'kt_paging_nav' ) ) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function kt_paging_nav( $type = 'normal' ) {

        if(is_array($type)){
            $type = $type['pagination'];
        }

        global $wp_query;

        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 || $type == 'none') {
            return;
        }

        if($type == 'button'){ ?>
            <nav class="navigation pagination-button">
                <span class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'delphinus' ); ?></span>
                <div class="nav-links">
                    <?php if ( get_next_posts_link() ) : ?>
                        <div class="nav-previous"><?php next_posts_link( '<i class="fa fa-long-arrow-left"></i> '.esc_html__( 'Older posts', 'delphinus' ) ); ?></div>
                    <?php endif; ?>
                    <?php if ( get_previous_posts_link() ) : ?>
                        <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'delphinus' ).' <i class="fa fa-long-arrow-right"></i>' ); ?></div>
                    <?php endif; ?>
                </div><!-- .nav-links -->
            </nav><!-- .navigation -->
        <?php }elseif($type == 'loadmore'){ ?>
            <?php $more_link = get_next_posts_link( __( 'Load More', 'delphinus' ) ); ?>
            <?php if(!empty($more_link)){ ?>
                <nav class="navigation pagination-loadmore">
                    <?php echo get_next_posts_link( __( 'Load More', 'delphinus' ) ); ?>
                </nav>
            <?php } ?>
        <?php }else{
            the_posts_pagination();
        }
    }
}


if ( ! function_exists( 'kt_entry_meta' ) ) {
	/**
	 * Display the post meta
	 * @since 1.0.0
	 */
	function kt_entry_meta( $arrays = array('categories', 'author') ) {
	    if ( 'post' == get_post_type() ) { ?>
            <div class="entry-post-meta">
			<?php
			foreach($arrays as $array ){
			    if($array == 'categories'){
                    kt_post_meta_categories();
			    }elseif($array == 'author'){
			        kt_post_meta_author();
			    }elseif($array == 'comments'){
			        kt_post_meta_comments();
			    }
			}
			?>
            </div>
        <?php
        }
	}
}


if ( ! function_exists( 'kt_post_meta' ) ) {
	/**
	 * Display the post meta
	 * @since 1.0.0
	 */
	function kt_post_meta() {
		?>
		<div class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>

			<?php
			kt_post_meta_categories();
			//kt_post_meta_author();
			kt_post_meta_date();
			kt_post_meta_comments();
			kt_entry_share_social();

			?>
			<?php endif; // End if 'post' == get_post_type() ?>
		</div>
		<?php
	}
}



if ( ! function_exists( 'kt_post_meta_comments' ) ) {
    function kt_post_meta_comments(){
    if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
            <span class="comments-link">
                <?php
                    comments_popup_link(
                        wp_kses( __( '0 <span>Comments</span>', 'delphinus' ), array( 'span' => array()) ),
                        wp_kses(__( '1 <span>Comment</span>', 'delphinus' ), array( 'span' => array()) ),
                        wp_kses(__( '% <span>Comments</span>', 'delphinus' ), array( 'span' => array()) )
                    );
                ?>
            </span>
        <?php endif;
    }
}

if ( ! function_exists( 'kt_post_meta_categories' ) ) :
    /**
     * Prints HTML with meta information for categories.
     *
     */
    function kt_post_meta_categories( $separator = ', ') {
        $categories_list = get_the_category_list(  $separator );
        if ( $categories_list ) {
            printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span> %2$s</span>',
                _x( 'Categories: ', 'Used before category names.', 'delphinus' ),
                $categories_list
            );
        }
    }
endif;


if ( ! function_exists( 'kt_post_meta_tags' ) ) :
    /**
     * Prints HTML with meta information for tags.
     *
     */
    function kt_post_meta_tags($separator = ', ', $before = '', $after = '') {
        $tags_list = get_the_tag_list( '', $separator, '' );
        if ( $tags_list ) {
            printf( '%2$s <span class="tags-links"><span>%4$s</span>%1$s</span>%3$s',
                $tags_list,
                $before,
                $after,
                esc_html__('Tags from the story: ', 'delphinus')
            );
        }
    }
endif;

if ( ! function_exists( 'kt_post_meta_author' ) ) :
    /**
     * Prints HTML with meta information for author.
     *
     */
    function kt_post_meta_author() {

        printf( '<span class="author vcard"><span class="fn" itemprop="author">%4$s <span class="screen-reader-text">%1$s </span><a class="url fn n" rel="author" href="%2$s">%3$s</a></span></span>',
            _x( 'Author', 'Used before post author name.', 'delphinus' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author(),
            esc_html__('By', 'delphinus' )
        );
    }
endif;



if ( ! function_exists( 'kt_post_meta_date' ) ) {
    /**
     * Prints HTML with date information for current post.
     *
     */
    function kt_post_meta_date() {

        $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s" itemprop="datePublished">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><span class="screen-reader-text">%1$s</span>%2$s</a></span>',
			esc_html__( 'Posted on', 'delphinus' ),
			$time_string
		);

    }
}



if ( ! function_exists( 'kt_entry_date' ) ) {
    /**
     * Prints HTML with date information for current post.
     *
     */
    function kt_entry_date() {

        $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished"><span class="post-date-number">%2$s</span><span class="post-date-text">%3$s</span></time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s"><span class="post-date-number">%2$s</span><span class="post-date-text">%3$s</span></time><time class="updated" datetime="%4$s" itemprop="datePublished"><span class="post-date-number">%5$s</span><span class="post-date-text">%6$s</span></time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date('j') ),
			esc_html( get_the_date('F') ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date('j') ),
			esc_html( get_the_modified_date('F') )
		);

		printf(
			'<span class="post-date">%s</span>',
			$time_string
		);

    }
}


if ( ! function_exists( 'kt_entry_share_social' ) ) {
    function kt_entry_share_social() {
        $total = kt_entry_share_total();
        printf(
            '<span class="post-share">%1$s <span class="text">%2$s</span></span>',
            $total,
            esc_html__('shares', 'delphinus')
        );
    }
}

if ( ! function_exists( 'kt_entry_share_total' ) ) {
    function kt_entry_share_total() {

            $post_id = get_the_ID();

            $cache_key = 'social_count_'.$post_id;
            $cache = get_transient($cache_key);

            if( !$cache ){
                $arr = array('facebook', 'twitter', 'google', 'linkedin', 'pinterest', 'stumbleupon', 'delicious', 'reddit', 'buffer', 'vk');
                $total = 0;
                foreach( $arr as $social){
                    $total += kt_entry_share_count($social);
                }

                $cache = array('count' => intval($total));
                set_transient( $cache_key, $cache, 2 * HOUR_IN_SECONDS );
            }

            return $cache['count'];
        }
}

if(!function_exists('kt_entry_share_count')){
    /**
     * Get count share for post
     * @param $service
     * @return int
     */
    function kt_entry_share_count( $service ) {

        $shareLinks = array(
            "facebook"    => "https://api.facebook.com/method/links.getStats?format=json&urls=",
            "twitter"     => "http://public.newsharecounts.com/count.json?url=",
            "google"      => "https://plusone.google.com/_/+1/fastbutton?url=",
            "linkedin"    => "https://www.linkedin.com/countserv/count/share?format=json&url=",
            "pinterest"   => "http://api.pinterest.com/v1/urls/count.json?url=",
            "stumbleupon" => "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=",
            "delicious"   => "http://feeds.delicious.com/v2/json/urlinfo/data?url=",
            "reddit"      => "http://www.reddit.com/api/info.json?&url=",
            "buffer"      => "https://api.bufferapp.com/1/links/shares.json?url=",
            "vk"          => "https://vk.com/share.php?act=count&index=1&url="
        );

        $post_id = get_the_ID();
        $cache_key = $service.'_count_'.$post_id;
        $cache = get_transient($cache_key);

        if( !$cache ){
            $link = 'http://crestaproject.com/downloads/cresta-social-share-counter/';get_the_permalink($post_id);

            $response = wp_remote_get( $shareLinks[$service].$link );
            if( is_array($response) ) {
                $data = $response['body'];
                switch($service) {
                    case "facebook":
                        $data = json_decode($data);
                        $count = (is_array($data) ? $data[0]->total_count : $data->total_count);
                        break;
                    case "google":
                        preg_match( '/window\.__SSR = {c: (\d+(?:\.\d+)+)/', $data, $matches);
                        if(isset($matches[0]) && isset($matches[1])) {
                            $bits = explode('.',$matches[1]);
                            $count = (int)( empty($bits[0]) ?: $bits[0]) . ( empty($bits[1]) ?: $bits[1] );
                        }
                        break;
                    case "pinterest":
                        $data = substr( $data, 13, -1);
                    case "linkedin":
                    case "twitter":
                        $data = json_decode($data);
                        $count = $data->count;
                        break;
                    case "stumbleupon":
                        $data = json_decode($data);
                        $count = $data->result->views;
                        break;
                    case "delicious":
                        $data = json_decode($data);
                        $count = $data[0]->total_posts;
                        break;
                    case "reddit":
                        $data = json_decode($data);
                        $ups = $downs = 0;
                        foreach($data->data->children as $child) {
                            $ups+= (int) $child->data->ups;
                            $downs+= (int) $child->data->downs;
                        }
                        $count = $ups - $downs;
                        break;
                    case "buffer":
                        $data = json_decode($data);
                        $count = $data->shares;
                        break;
                    case "vk":
                        $data = preg_match('/^VK.Share.count\(\d+,\s+(\d+)\);$/i', $data, $matches);
                        $count = $matches[1];
                        break;
                    default:
                        $count = 0;
                }
                $cache = array('count' => $count );
            }else{
                $cache = array('count' => 0 );
            }

            $hour = apply_filters('kt_caches_time_share', 4);
            set_transient( $cache_key, $cache, $hour * HOUR_IN_SECONDS );
        }

        return intval($cache['count']);
    }
}

if ( ! function_exists( 'kt_entry_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own kt_entry_excerpt() function to override in a child theme.
	 *
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function kt_entry_excerpt( $class = 'entry-content' ) {
		$class = esc_attr( $class );
		 ?>
			<div class="<?php echo esc_attr($class); ?>" itemprop="articleBody">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo esc_attr($class); ?> -->
		<?php
	}
endif;



/* ---------------------------------------------------------------------------
 * Share Box [share_box]
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'kt_share_box' ) ){
    function kt_share_box($post_id = null, $style = "", $class = 'share-it', $count = false){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $link = urlencode(get_permalink($post_id));
        $title = urlencode(addslashes(get_the_title($post_id)));
        $excerpt = urlencode(get_the_excerpt());
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');

        $html = '';
        $share_arr = kt_option('social_share', array('facebook' => true, 'twitter' => true, 'pinterest' => true));

        if($share_arr){
            $i =0;
            foreach($share_arr as $key => $val){
                if($val){
                    $active = ($i == 0) ? ' active' : '';
                    if($key == 'facebook'){
                        // Facebook
                        $html .= '<li class="facebook'.$active.' "><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link.'\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');popUp.focus();return false;">';
                        $text = ($count) ? esc_html__('Share', 'delphinus') : esc_html__('Facebook', 'delphinus');
                        $html .= '<i class="fa fa-facebook"></i><span class="text">'.$text.'</span>';
                        if($count){
                            $html .= '<span class="count">'.kt_entry_share_count('facebook').'</span></li>';
                        }
                        $html .= '</a></li>';
                    }elseif($key == 'twitter'){
                        // Twitter
                        $html .= '<li class="twitter'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://twitter.com/home?status=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
                        $text = ($count) ? esc_html__('tweet', 'delphinus') : esc_html__('Twitter', 'delphinus');
                        $html .= '<i class="fa fa-twitter"></i><span class="text">'.$text.'</span>';
                        if($count){
                            $html .= '<span class="count">'.kt_entry_share_count('twitter').'</span></li>';
                        }
                        $html .= '</a></li>';
                    }elseif($key == 'google_plus'){
                        // Google plus
                        $html .= '<li class="google_plus'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-google-plus"></i><span class="text">'.esc_html__('Google+', 'delphinus').'</span>';
                        $html .= '<span class="count">'.kt_entry_share_count('google').'</span></li>';
                        $html .= "</a></li>";
                    }elseif($key == 'pinterest'){
                        // Pinterest
                        $html .= '<li class="pinterest'.$active.'"><a class="share_link" href="#" onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $title . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $text = ($count) ? esc_html__('Pin it', 'delphinus') : esc_html__('Pinterest', 'delphinus');
                        $html .= '<i class="fa fa-pinterest"></i><span class="text">'.$text.'</span>';
                        if($count){
                            $html .= '<span class="count">'.kt_entry_share_count('pinterest').'</span></li>';
                        }
                        $html .= "</a></li>";
                    }elseif($key == 'linkedin'){
                        // linkedin
                        $html .= '<li class="linkedin'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title. '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-linkedin"></i><span class="text">'.esc_html__('LinkedIn', 'delphinus').'</span>';
                        $html .= '<span class="count">'.kt_entry_share_count('linkedin').'</span></li>';
                        $html .= "</a></li>";
                    }elseif($key == 'tumblr'){
                        // Tumblr
                        $html .= '<li class="tumblr'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . $link . '&amp;name=' . $title . '&amp;description=' . $excerpt . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-tumblr"></i><span class="text">'.esc_html__('Tumblr', 'delphinus').'</span>';
                        $html .= "</a></li>";
                    }elseif($key == 'email'){
                        // Email
                        $html .= '<li class="email'.$active.'"><a class="'.$style.'" href="mailto:?subject='.$title.'&amp;body='.$link.'">';
                        $html .= '<i class="fa fa-envelope-o"></i><span class="text">'.esc_html__('Mail', 'delphinus').'</span>';
                        $html .= "</a></li>";
                    }
                    $i++;
                }
            }
        }

        if($html){
            printf(
                '<div class="%s"><ul class="%s">%s</ul></div>',
                $class,
                'social_icons',
                $html
            );
        }
    }
}


if ( ! function_exists( 'kt_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function kt_post_nav() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) return;

        $class = ' onlyone';
        if($next && $previous){
            $class = '';
        }

		$args = array(
			'next_text' => '<span class="meta-nav">'.esc_html__('Previous Post', 'delphinus').'</span><span class="meta-title">%title</span>',
			'prev_text' => '<span class="meta-nav">'.esc_html__('Next Post', 'delphinus').'</span><span class="meta-title">%title</span>',
        );
        echo '<div class="post-navigation-outer '.$class.'">';
		the_post_navigation( $args );
		echo '</div>';
	}
}



/* ---------------------------------------------------------------------------
 * Related Article [related_article]
 * --------------------------------------------------------------------------- */
if ( ! function_exists( 'kt_related_article' ) ) :
    function kt_related_article($post_id = null, $type = 'categories'){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $posts_per_page = kt_option('blog_related_sidebar', 5);
        $excerpt_length = 15;

        $args = array(
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array($post_id)
        );
        if($type == 'tags'){
            $tags = wp_get_post_tags($post_id);
            if(!$tags) return false;
            $tag_ids = array();
            foreach($tags as $tag)
                $tag_ids[] = $tag->term_id;
            $args['tag__in'] = $tag_ids;
        }elseif($type == 'author'){
            $args['author'] = get_the_author();
        }else{
            $categories = get_the_category($post_id);
            if(!$categories) return false;
            $category_ids = array();
            foreach($categories as $category)
                $category_ids[] = $category->term_id;
            $args['category__in'] = $category_ids;
        }

        $args = apply_filters('kt_related_article_args', $args);

        $exl_function = create_function('$n', 'return '.$excerpt_length.';');
        add_filter( 'excerpt_length', $exl_function , 999 );


        $query = new WP_Query( $args );


        if($query->have_posts()){ ?>
            <div id="related-article">
                <h3 class="post-single-heading"><?php esc_html_e('Related Article', 'delphinus'); ?></h3>
                <div class="blog-posts blog-posts-carousel no-readmore">
                <?php

                    ob_start();
                    $carousel_html ='';

                    while ( $query->have_posts() ) : $query->the_post();

                        echo '<div class="blog-post-wrap col-lg-6 col-md-6 col-sm-6">';
                        get_template_part( 'templates/blog/grid/content-relate', get_post_format());
                        echo '</div>';

                    endwhile;

                    $carousel_html .= ob_get_clean();
                    if($carousel_html){
                        $atts = array(
                            'desktop' => 2,
                            'navigation_position' => 'heading',
                            'navigation_always_on' => true
                        );
                        $carousel_ouput = kt_render_carousel(apply_filters( 'kt_render_args', $atts), '', 'kt-owl-carousel');

                        echo str_replace('%carousel_html%', $carousel_html, $carousel_ouput);

                    }

                ?>
                </div>
            </div><!-- #related-article -->
        <?php
        }
        remove_filter('excerpt_length', $exl_function, 999 );
        wp_reset_postdata();
    }
endif;


