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
	add_theme_support( 'post-formats', array('gallery', 'quote', 'video', 'audio') );

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
        add_image_size( 'kt_grid', 570, 650, true);
        add_image_size( 'kt_masonry', 570);
        add_image_size( 'kt_list', 700, 570, true);
        add_image_size( 'kt_classic', 1140, 600, true );
        add_image_size( 'kt_zigzag', 960, 600, true);
        add_image_size( 'kt_small', 170, 170, true );
    }
    
    load_theme_textdomain( 'mondova', KT_THEME_DIR . '/languages' );
    
    /**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
        'primary' => esc_html__('Main Navigation Menu', 'mondova'),
        'mobile' => esc_html__('(Mobile Devices) Main Navigation Menu', 'mondova'),
        'footer'	  => esc_html__( 'Footer Navigation Menu', 'mondova' ),
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

    wp_enqueue_style( 'kt-wp-style', get_stylesheet_uri(), array('mediaelement', 'wp-mediaelement') );
    wp_enqueue_style( 'bootstrap', KT_THEME_LIBS . 'bootstrap/css/bootstrap.css', array());
    wp_enqueue_style( 'font-awesome', KT_THEME_LIBS . 'font-awesome/css/font-awesome.min.css', array());
    wp_enqueue_style( 'elegant_font', KT_THEME_LIBS . 'elegant_font/style.css', array());

    wp_enqueue_style( 'kt-plugins', KT_THEME_CSS . 'plugins.css', array());

	// Load our main stylesheet.
    wp_enqueue_style( 'kt-main', KT_THEME_CSS . 'style.css');
    wp_enqueue_style( 'kt-queries', KT_THEME_CSS . 'queries.css');

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'kt-ie', KT_THEME_CSS . 'ie.css');
	wp_style_add_data( 'kt-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'bootstrap', KT_THEME_LIBS . 'bootstrap/js/bootstrap.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-plugins', KT_THEME_JS . 'plugins.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'kt-main-script', KT_THEME_JS . 'functions.js', array( 'jquery', 'mediaelement', 'wp-mediaelement', 'jquery-ui-tabs' ), null, true );

    wp_localize_script( 'kt-main-script', 'ajax_frontend', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'ajax_frontend' ),
    ));

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

    $css = '';

    if(is_page() || is_singular()){

        global $post;
        $post_id = $post->ID;

        $pageh_spacing = rwmb_meta('_kt_page_top_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '.content-area-inner{padding-top: '.$pageh_spacing.';}';
        }
        $pageh_spacing = rwmb_meta('_kt_page_bottom_spacing', array(), $post_id);
        if($pageh_spacing != ''){
            $css .= '.content-area-inner{padding-bottom:'.$pageh_spacing.';}';
        }


    }

    wp_add_inline_style( 'kt-main', $css );
}
add_action('wp_enqueue_scripts', 'kt_setting_script');


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


/**
 *
 *
 * Control the number of posts per page
 */
function kt_posts_per_page( $query ) {
    if ( $query->is_main_query() && !is_admin()) {


        if(isset($_REQUEST['per_page'])){
            $posts_per_page = $_REQUEST['per_page'];
        }elseif(is_search()){
            $posts_per_page = kt_option('search_posts_per_page', 9);
        }elseif($query->is_category() || $query->is_home() || $query->is_tag()){
            $posts_per_page = kt_option('archive_posts_per_page', 14);
        }


        if(isset($posts_per_page)){
            set_query_var('posts_per_page', $posts_per_page);
        }
    }
}
//add_action( 'pre_get_posts', 'kt_posts_per_page' );

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
            <div class="comment-item">
                <?php _e( 'Pingback:', '_tk' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', '_tk' ), '<span class="edit-link">', '</span>' ); ?>
            </div>

	<?php else : ?>

        <li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <div  id="comment-<?php comment_ID(); ?>" class="comment-item">

                <div class="comment-avatar">
                    <?php echo get_avatar($comment->comment_author_email, $size='100',$default='' ); ?>
                </div>
                <div class="comment-body">
                    <div class="comment-meta">
                        <h5 class="comment-author">
                            <?php comment_author_link(); ?>
                        </h5>
                        <time class="comment-date" itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>">
                        <?php printf( _x( '%s ago', '%s = human-readable time difference', 'adroit' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
                    </time>
                    </div>
                    <div class="comment-entry" itemprop="description">
                        <?php comment_text() ?>
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em><?php esc_html_e('Your comment is awaiting moderation.', 'adroit') ?></em>
                        <?php endif; ?>
                    </div>
                    <div class="comment-actions">
                        <?php edit_comment_link( '<span class="icon-pencil"></span> '.esc_html__('Edit', 'adroit'),'  ',' ') ?>
                        <?php comment_reply_link( array_merge( $args,
                            array('depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'reply_text' =>'<span class="icon-action-undo"></span> '.esc_html__('Reply','adroit')
                            ))) ?>
                    </div>
                </div>
            </div>
        <?php
    endif;
}




if ( ! function_exists( 'kt_post_thumbnail_image' ) ) {
    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     */
    function kt_post_thumbnail_image($size = 'post-thumbnail', $class_img = '', $link = true, $placeholder = true, $echo = true) {
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
                        esc_html__('No image', 'mondova'),
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
			_x( 'Posted on %s', 'post date', 'mondova' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			_x( 'by %s', 'post author', 'mondova' ),
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
                <span class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'mondova' ); ?></span>
                <div class="nav-links">
                    <?php if ( get_next_posts_link() ) : ?>
                        <div class="nav-previous"><?php next_posts_link( '<i class="fa fa-long-arrow-left"></i> '.esc_html__( 'Older posts', 'mondova' ) ); ?></div>
                    <?php endif; ?>
                    <?php if ( get_previous_posts_link() ) : ?>
                        <div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'mondova' ).' <i class="fa fa-long-arrow-right"></i>' ); ?></div>
                    <?php endif; ?>
                </div><!-- .nav-links -->
            </nav><!-- .navigation -->
        <?php }elseif($type == 'loadmore'){ ?>
            <?php $more_link = get_next_posts_link( __( 'Load More', 'mountain' ) ); ?>
            <?php if(!empty($more_link)){ ?>
                <nav class="navigation pagination-loadmore">
                    <?php echo get_next_posts_link( __( 'Load More', 'mondova' ) ); ?>
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
	function kt_entry_meta() {
	    if ( 'post' == get_post_type() ) { ?>
            <div class="entry-post-meta">
			<?php
			kt_post_meta_categories();
			kt_post_meta_author();
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
			kt_post_meta_author();
			kt_post_meta_date();
			?>

			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'mondova' ), __( '1 Comment', 'mondova' ), __( '% Comments', 'mondova' ) ); ?></span>
			<?php endif; ?>
		</div>
		<?php
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
                _x( 'Categories: ', 'Used before category names.', 'mondova' ),
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
        $tags_list = get_the_tag_list( '', $separator );
        if ( $tags_list ) {
            printf( '%2$s<span class="tags-links">%1$s</span>%3$s',
                $tags_list,
                $before,
                $after
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
            _x( 'Author', 'Used before post author name.', 'mondova' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author(),
            esc_html__('By', 'mondova' )
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
			_x( 'Posted on %s', 'post date', 'mondova' ),
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
    function kt_share_box($post_id = null, $style = "", $class = 'share-it'){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $link = urlencode(get_permalink($post_id));
        $title = urlencode(addslashes(get_the_title($post_id)));
        $excerpt = urlencode(get_the_excerpt());
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');

        $html = '';
        $share_arr = kt_option('social_share');

        if(count($share_arr)){
            $i =0;
            foreach($share_arr as $key => $val){
                if($val){
                    $active = ($i == 0) ? 'active' : '';
                    if($key == 'facebook'){
                        // Facebook
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link.'\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');popUp.focus();return false;">';
                        $html .= '<i class="fa fa-facebook"></i><span>'.esc_html__('Share on Facebook', 'mondova').'</span>';
                        $html .= '</a></li>';
                    }elseif($key == 'twitter'){
                        // Twitter
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://twitter.com/home?status=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
                        $html .= '<i class="fa fa-twitter"></i><span>'.esc_html__('Share on Twitter', 'mondova').'</span>';
                        $html .= '</a></li>';
                    }elseif($key == 'google_plus'){
                        // Google plus
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . $link . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-google-plus"></i><span>'.esc_html__('Share on Google+', 'mondova').'</span>';
                        $html .= "</a></li>";
                    }elseif($key == 'pinterest'){
                        // Pinterest
                        $html .= '<li class="'.$active.'"><a class="share_link" href="#" onclick="popUp=window.open(\'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $title . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-pinterest"></i><span>'.esc_html__('Share on Pinterest', 'mondova').'</span>';
                        $html .= "</a></li>";
                    }elseif($key == 'linkedin'){
                        // linkedin
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title. '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-linkedin"></i><span>'.esc_html__('Share on LinkedIn', 'mondova').'</span>';
                        $html .= "</a></li>";
                    }elseif($key == 'tumblr'){
                        // Tumblr
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="#" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . $link . '&amp;name=' . $title . '&amp;description=' . $excerpt . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-tumblr"></i><span>'.esc_html__('Share on Tumblr', 'mondova').'</span>';
                        $html .= "</a></li>";
                    }elseif($key == 'email'){
                        // Email
                        $html .= '<li class="'.$active.'"><a class="'.$style.'" href="mailto:?subject='.$title.'&amp;body='.$link.'">';
                        $html .= '<i class="fa fa-envelope-o"></i><span>'.esc_html__('Share on Mail', 'mondova').'</span>';
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

        echo '<div class="post-navigation-wrap"><div class="container">';
		$args = array(
			'next_text' => '<span class="meta-image"></span><span class="meta-nav">'.esc_html__('Previous Post', 'mondova').'</span><span class="meta-title">%title</span>',
			'prev_text' => '<span class="meta-image"></span><span class="meta-nav">'.esc_html__('Next Post', 'mondova').'</span><span class="meta-title">%title</span>',
        );
		the_post_navigation( $args );
        echo '</div></div>';
	}
}
