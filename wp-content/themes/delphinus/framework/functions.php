<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



/**
 * Add custom favicon
 *
 * @since 1.0
 */
function kt_add_site_icon(){
    if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
        $custom_favicon = kt_option( 'custom_favicon' );
        $custom_favicon_iphone = kt_option( 'custom_favicon_iphone' );
        $custom_favicon_iphone_retina = kt_option( 'custom_favicon_iphone_retina' );
        $custom_favicon_ipad = kt_option( 'custom_favicon_ipad' );
        $custom_favicon_ipad_retina = kt_option( 'custom_favicon_ipad_retina' );
        if($custom_favicon['url']){
            printf( '<link rel="shortcut icon" href="%s"/>', esc_url($custom_favicon['url']) );
        }
        if($custom_favicon_iphone['url']) {
            printf('<link rel="apple-touch-icon" href="%s"/>', esc_url($custom_favicon_iphone['url']));
        }
        if($custom_favicon_ipad['url']) {
            printf('<link rel="apple-touch-icon" sizes="72x72" href="%s"/>', esc_url($custom_favicon_ipad['url']));
        }
        if($custom_favicon_iphone_retina['url']) {
            printf('<link rel="apple-touch-icon" sizes="114x114" href="%s"/>', esc_url($custom_favicon_iphone_retina['url']));
        }
        if($custom_favicon_ipad_retina['url']) {
            printf('<link rel="apple-touch-icon" sizes="144x144" href="%s"/>', esc_url($custom_favicon_ipad_retina['url']));
        }
    }
}
add_action( 'wp_head', 'kt_add_site_icon');


/**
 * Flag boolean.
 *
 * @param $input string
 * @return boolean
 */
function kt_sanitize_boolean( $input = '' ) {
    $input = (string)$input;
    return in_array($input, array('1', 'true', 'y', 'on'));
}
add_filter( 'sanitize_boolean', 'kt_sanitize_boolean', 15 );




/**
 * Add class to next button
 *
 * @param string $attr
 * @return string
 */
function kt_next_posts_link_attributes( $attr = '' ) {
    return "class='btn btn-default'";
}
add_filter( 'next_posts_link_attributes', 'kt_next_posts_link_attributes', 15 );


/**
 * Add class to prev button
 *p
 * @param string $attr
 * @return string
 */
function kt_previous_posts_link_attributes( $attr = '' ) {
    return "class='btn btn-default'";
}
add_filter( 'previous_posts_link_attributes', 'kt_previous_posts_link_attributes', 15 );


if(!function_exists('kt_placeholder_callback')) {
    /**
     * Return PlaceHolder Image
     * @param string $size
     * @return string
     */
    function kt_placeholder_callback($size = '')
    {

        $placeholder = kt_option('archive_placeholder');
        if(is_array($placeholder) && $placeholder['id'] != '' ){
            $obj = kt_get_thumbnail_attachment($placeholder['id'], $size);
            $imgage = $obj['url'];
        }elseif($size == 'kt_grid' || $size == 'kt_masonry') {
            $imgage = KT_THEME_IMG . 'placeholder-recent.jpg';
        }elseif ($size == 'kt_classic'){
            $imgage = KT_THEME_IMG . 'placeholder-blogpost.jpg';
        }elseif($size == 'kt_list'){
            $imgage = KT_THEME_IMG . 'placeholder-list.jpg';
        }elseif($size == 'kt_small'){
            $imgage = KT_THEME_IMG . 'placeholder-small.jpg';
        }elseif($size == 'kt_zigzag'){
            $imgage = KT_THEME_IMG . 'placeholder-zigzag.jpg';
        }else{
            $imgage = KT_THEME_IMG . 'placeholder-post.jpg';
        }

        return $imgage;
    }
    add_filter('kt_placeholder', 'kt_placeholder_callback');
}


/**
 * Custom password form
 *
 * @return string
 */
function kt_password_form() {
    global $post;
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <p>' . __( "To view this protected post, enter the password below:", 'mondova' ) . '</p>
    <div class="input-group"><input name="post_password" type="password" size="20" maxlength="20" /><span class="input-group-btn"><input type="submit" class="btn btn-dark" name="Submit" value="' . esc_attr__( "Submit", 'mondova' ) . '" /></span></div>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'kt_password_form' );


/**
 * Extend the default WordPress body classes.
 *
 * @since 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function kt_body_classes( $classes ) {
    global $post;

    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    if( is_page() || is_singular('post')){

        $classes[] = 'layout-'.kt_getlayout($post->ID);
        $classes[] = rwmb_meta('_kt_extra_page_class');
    }else{
        $classes[] = 'layout-'.kt_option('layout', 'boxed');
    }

    return $classes;
}
add_filter( 'body_class', 'kt_body_classes' );


/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function kt_widget_tag_cloud_args( $args ) {
    $args['largest'] = 1;
    $args['smallest'] = 1;
    $args['number']   = 15;
    $args['unit'] = 'em';
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'kt_widget_tag_cloud_args' );


/**
 * Add page header
 *
 * @since 1.0
 */

function kt_page_header( ){

    global $post;
    $show_title = false;

    if ( is_front_page() && is_singular('page')){
        $show_title = rwmb_meta('_kt_page_header', array(), get_option('page_on_front', true));
        if( !$show_title ){
            $show_title = kt_option('show_page_header', 1);
        }
    }elseif(is_archive()){
        $show_title = kt_option('archive_page_header', 1);
    }elseif(is_search()){
        $show_title = kt_option('search_page_header', 1);
    }elseif(is_404()){
        $show_title = kt_option('notfound_page_header', 1);
    }else{
        if(is_page()){
            $post_id = $post->ID;
            $show_title = rwmb_meta('_kt_page_header', array(), $post_id);
            if( !$show_title ){
                $show_title = kt_option('show_page_header', 1);
            }
        }else{
            $show_title = kt_option('show_page_header', 1);
        }
    }


    $show_title = apply_filters( 'kt_show_title', $show_title );
    if($show_title == 'on' || $show_title == 1){
        $title = kt_get_page_title();
        $subtitle = kt_get_page_subtitle();

        $title = '<h1 class="page-header-title">'.$title.'</h1>';
        if($subtitle != ''){
            $subtitle = '<div class="page-header-subtitle">'.$subtitle.'</div>';
        }

        $style = 'fancy-tabbed';
        //standard, fancy-tabbed

        if($style == 'fancy-tabbed'){
            $layout = '<div class="page-header %3$s"><div class="container"><div class="page-header-content">%1$s %2$s</div></div></div>';
        }else{
            $layout = '<div class="page-header %4$s"><div class="container"><div class="page-header-content">%1$s %2$s</div></div></div>';
        }

        printf(
            $layout,
            $title,
            $subtitle,
            $style.'-heading'
        );
    }


}
add_action( 'kt_before_content', 'kt_page_header', 20 );

/**
 * Get page title
 *
 * @param string $title
 * @return mixed|void
 */

function kt_get_page_title( $title = '' ){
    global $post;

    if ( is_front_page() && !is_singular('page') ) {
        $title = esc_html__( 'Blog', 'wingman' );
    } elseif ( is_search() ) {
        $title = esc_html__( 'Search', 'wingman' );
    } elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        if($page_for_posts){
            $title = get_the_title($page_for_posts) ;
            $title = apply_filters( 'the_title', $title, $page_for_posts );
        }
    } elseif( is_404() ) {
        $title = esc_html__( 'Page not found', 'wingman' );
    } elseif ( is_archive() ){
        $title = get_the_archive_title();
        if(kt_is_wc()) {
            if (is_shop()) {
                $shop_page_id = get_option('woocommerce_shop_page_id');
                $title = get_the_title($shop_page_id);
            }
        }
    } elseif ( is_front_page() && is_singular('page') ){
        $page_on_front = get_option('page_on_front', true);
        $title = get_the_title($page_on_front) ;
        $title = apply_filters( 'the_title', $title, $page_on_front );
    } elseif( is_page() || is_singular() ){
        $post_id = $post->ID;
        $custom_text = rwmb_meta('_kt_page_header_custom', array(), $post_id);
        $title = ($custom_text != '') ? $custom_text : get_the_title($post_id);
        $title = apply_filters( 'the_title', $title, $post_id );
    }

    return apply_filters( 'kt_title', $title );

}


/**
 * Get page tagline
 *
 * @return mixed|void
 */

function kt_get_page_subtitle(){
    global $post;
    $tagline = '';
    if ( is_front_page() && !is_singular('page') ) {
        $tagline =  esc_html__('Lastest posts', 'wingman');
    }elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        $tagline = nl2br(rwmb_meta('_kt_page_header_subtitle', array(), $page_for_posts))  ;
    }elseif ( is_front_page() && is_singular('page') ){
        $tagline =  rwmb_meta('_kt_page_header_subtitle');
    }elseif ( is_archive() ){
        $tagline = get_the_archive_description( );
        if(kt_is_wc()){
            if(is_shop()){
                $shop_page_id = get_option( 'woocommerce_shop_page_id' );
                $tagline = rwmb_meta('_kt_page_header_subtitle', array(), $shop_page_id);
            }
            if( is_product_category() || is_product_tag() ){
                $tagline = '';
            }
        }
    }elseif(is_search()){
        $tagline = '';
    }elseif( $post ){
        $post_id = $post->ID;
        $tagline = nl2br(rwmb_meta('_kt_page_header_subtitle', array(), $post_id));
    }

    return apply_filters( 'kt_subtitle', $tagline );
}



add_action('kt_loop_after', 'kt_paging_nav');





/**
 * Add slideshow header
 *
 * @since 1.0
 */
add_action( 'kt_slideshows_position', 'kt_slideshows_position_callback' );
function kt_slideshows_position_callback(){

    if(is_page()){
        kt_show_slideshow();
    }
}




function kt_comment_form_before_fields(){
    echo '<div class="comment-form-fields row clearfix">';
}
add_action( 'comment_form_before_fields', 'kt_comment_form_before_fields', 1 );



function kt_comment_form_after_fields(){
    echo '</div>';
}
add_action( 'comment_form_after_fields', 'kt_comment_form_after_fields', 9999 );