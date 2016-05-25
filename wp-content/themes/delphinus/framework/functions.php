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



if ( ! function_exists( 'kt_page_loader' ) ) :
    /**
     * Add page loader to frontend
     *
     */
    function kt_page_loader(){
        $use_loader = kt_option( 'use_page_loader', 0 );
        if( $use_loader ){
            $svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                        <path d="M3.7,12h10.6l15.1,54.6c0.4,1.6,1.9,2.7,3.6,2.7h46.4c1.5,0,2.8-0.9,3.4-2.2l16.9-38.8c0.5-1.2,0.4-2.5-0.3-3.5c-0.7-1-1.8-1.7-3.1-1.7H45c-2,0-3.7,1.7-3.7,3.7s1.7,3.7,3.7,3.7h45.6L76.9,62H35.8L20.7,7.3c-0.4-1.6-1.9-2.7-3.6-2.7H3.7C1.7,4.6,0,6.3,0,8.3S1.7,12,3.7,12z"/>
                        <path d="M29.5,95.4c4.6,0,8.4-3.8,8.4-8.4s-3.8-8.4-8.4-8.4s-8.4,3.8-8.4,8.4C21.1,91.6,24.8,95.4,29.5,95.4z"/>
                        <path d="M81.9,95.4c0.2,0,0.4,0,0.6,0c2.2-0.2,4.3-1.2,5.7-2.9c1.5-1.7,2.2-3.8,2-6.1c-0.3-4.6-4.3-8.1-8.9-7.8s-8.1,4.4-7.8,8.9C73.9,91.9,77.5,95.4,81.9,95.4z"/>
                    </svg>';
            ?>
            <div class="page-loading-wrapper">
                <div class="progress-bar-loading">
                    <div class="back-loading progress-bar-inner">
                        <?php echo $svg; ?>
                    </div>
                    <div class="front-loading progress-bar-inner">
                        <?php echo $svg; ?>
                    </div>
                    <div class="progress-bar-number">0%</div>
                </div>
            </div>
            <?php

        }
    }
    add_action( 'kt_body_top', 'kt_page_loader');
endif;



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



function kt_add_search_full(){
    if(kt_option('header_search', 1)){

        if(kt_is_wc()){           $search = get_product_search_form(false);
        }else{
            $search = get_search_form(false);
        }

        printf(
            '<div id="%1$s" class="%2$s">%3$s</div>',
            'search-fullwidth',
            'mfp-hide mfp-with-anim',
            $search
        );
    }
}
add_action('kt_body_top', 'kt_add_search_full', 999);



/**
 * Add popup
 *
 * @since 1.0
 */

function kt_body_top_add_popup(){
    $enable_popup = kt_option( 'enable_popup', 0 );
    $disable_popup_mobile = kt_option( 'disable_popup_mobile' );
    $content_popup = kt_option( 'content_popup' );
    $time_show = kt_option( 'time_show', 0 );
    $image_popup = kt_option( 'popup_image' );
    $popup_form = kt_option( 'popup_form' );


    if( $enable_popup == 1 && !isset($_COOKIE['kt_popup']) ){
        ?>
        <div id="popup-wrap" class="mfp-hide mfp-with-anim" data-mobile="<?php echo esc_attr( $disable_popup_mobile ); ?>" data-timeshow="<?php echo esc_attr($time_show); ?>">
            <div class="container-fluid">
                <div class="wrapper-newletter-content">
                    <div class="row no-gutters">
                        <div class="col-md-4 col-sm-4 newletter-popup-img hidden-xs">
                            <?php if( $image_popup['url'] ){ ?>
                                <img src="<?php echo esc_attr($image_popup['url']); ?>" alt="" class="img-responsive">
                            <?php } ?>
                        </div>
                        <div class="col-md-8 col-sm-8 wrapper-newletter-popup">
                            <div class="newletter-popup-content">
                                <?php
                                    echo apply_filters('the_content', $content_popup);
                                    if($popup_form){
                                        printf('<div class="newletter-popup-form">%s</div>', apply_filters('the_content', $popup_form));
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action( 'kt_body_top', 'kt_body_top_add_popup', 20 );


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
    <p>' . __( "To view this protected post, enter the password below:", 'delphinus' ) . '</p>
    <div class="input-group"><input name="post_password" type="password" size="20" maxlength="20" /><span class="input-group-btn"><input type="submit" class="btn btn-dark" name="Submit" value="' . esc_attr__( "Submit", 'delphinus' ) . '" /></span></div>
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

    if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
        $classes[]	= 'no-wc-breadcrumb';
    }

    if( is_page() || is_singular('post')){
        $classes[] = 'layout-'.kt_getlayout($post->ID);
        $classes[] = rwmb_meta('_kt_extra_page_class');

        $type = rwmb_meta('_kt_type_page');
        if($type){
            $classes[] = 'page-type-'.$type;
        }

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

    if ( is_front_page() && !is_singular('page')){
        $show_title = rwmb_meta('_kt_page_header', array(), get_option('page_on_front', true));
        if(kt_is_wc()) {
            if (is_shop()) {
                $page_id = get_option('woocommerce_shop_page_id');
                $show_title = rwmb_meta('_kt_page_header', array(), $page_id);
            }
        }
        if( !$show_title ){
            $show_title = kt_option('show_page_header', 1);
        }
    }elseif(is_archive()){
        $show_title = kt_option('archive_page_header', 1);
    }elseif(is_search()){
        $show_title = kt_option('search_page_header', 1);
    }elseif(is_404()){
        $show_title = false;
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

        if(kt_is_wc()){
            if(is_product()){
                $show_title = false;
            }
        }

    }


    $show_title = apply_filters( 'kt_show_title', $show_title );
    if($show_title == 'on' || $show_title == 1){
        $title = kt_get_page_title();
        $subtitle = kt_get_page_subtitle();

        $title = '<h1 class="page-header-title">'.$title.'</h1>';
        if($subtitle != ''){
            $title .= '<div class="page-header-subtitle">'.$subtitle.'</div>';
        }

        $breadcrumb = '';
        if ( function_exists( 'woocommerce_breadcrumb' ) ) {
            ob_start();
            woocommerce_breadcrumb();
            $breadcrumb .= ob_get_clean();
        }

        $content = sprintf('<div class="row"><div class="col-md-4">%1$s</div><div class="col-md-8 text-right">%2$s</div></div>', $breadcrumb, $title);
        $layout = '<div class="page-header"><div class="container"><div class="page-header-content">%1$s</div></div></div>';


        printf(
            $layout,
            $content
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
        $title = esc_html__( 'Blog', 'delphinus' );
        if(kt_is_wc()) {
            if (is_shop()) {
                $shop_page_id = get_option('woocommerce_shop_page_id');
                $custom_text = rwmb_meta('_kt_page_header_custom', array(), $shop_page_id);
                $title = ($custom_text != '') ? $custom_text : get_the_title($shop_page_id);
            }
        }
    } elseif ( is_search() ) {
        $title = esc_html__( 'Search', 'delphinus' );
    } elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        if($page_for_posts){
            $title = get_the_title($page_for_posts) ;
            $title = apply_filters( 'the_title', $title, $page_for_posts );
        }
    } elseif( is_404() ) {
        $title = esc_html__( 'Page not found', 'delphinus' );
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
        $tagline =  esc_html__('Lastest posts', 'delphinus');
        if(kt_is_wc()) {
            if (is_shop()) {
                $shop_page_id = get_option('woocommerce_shop_page_id');
                $tagline = rwmb_meta('_kt_page_header_subtitle', array(), $shop_page_id);
            }
        }
    }elseif( is_home() ){
        $page_for_posts = get_option('page_for_posts', true);
        $tagline = nl2br(rwmb_meta('_kt_page_header_subtitle', array(), $page_for_posts))  ;
    }elseif ( is_front_page() && is_singular('page') ){
        $tagline =  rwmb_meta('_kt_page_header_subtitle');
    }elseif ( is_archive() ){
        $tagline = get_the_archive_description( );
        if(kt_is_wc()){
            if(is_shop()){
                if(!is_search()){
                    $shop_page_id = get_option( 'woocommerce_shop_page_id' );
                    $tagline = rwmb_meta('_kt_page_header_subtitle', array(), $shop_page_id);
                }
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
        $page_id = get_the_ID();
        if(kt_is_wc()) {
            if (is_shop()) {
                $page_id = get_option('woocommerce_shop_page_id');
            }
        }
        kt_show_slideshow($page_id);
    }
}

add_filter( 'get_the_archive_title', 'kt_get_the_archive_title');
/**
 * Remove text Category and Archives in get_the_archive_title
 *
 * @param $title
 * @return null|string
 */
function kt_get_the_archive_title($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title =  single_term_title( '', false );
    }

    return $title;

}


add_filter('wpb_widget_title', 'kt_widget_title', 10, 2);
function kt_widget_title($output = '', $params = array('')) {
    if ( '' === $params['title'] ) {
        return '';
    }
    $extraclass = ( isset( $params['extraclass'] ) ) ? ' ' . $params['extraclass'] : '';
    return '<h4 class="wpb_heading'.$extraclass.'">'.$params['title'].'</h4>';
}

add_filter('kt_header_class', 'kt_header_add_class', 10, 3);
function kt_header_add_class($classes, $header_layout, $header_position){

    $header_scheme = '';
    if(is_page()){
        $header_scheme = rwmb_meta('_kt_header_scheme', array());
    }

    if(!$header_scheme){
        $header_scheme = 'dark';
    }

    $classes .= ' header-'.$header_scheme;


    if($header_position == 'transparent'){
        $classes .= ' header-transparent';
    }


    return $classes;
}


add_filter('kt_header_content_class', 'kt_header_content_class', 10, 2);
function kt_header_content_class($classes, $header_layout){

    if($header_shadow = kt_option( 'header_shadow', true )){
        $classes .= ' header-shadow';
    }
    return $classes;
}



if(!function_exists('kt_setting_script_footer')){
    /**
     * Add advanced js to footer
     *
     */
    function kt_setting_script_footer() {
        $advanced_js = kt_option('advanced_editor_js');

        if($advanced_js){
            printf('<script type="text/javascript">%s</script>', $advanced_js);
        }
        if($advanced_tracking_code = kt_option('advanced_tracking_code')){
            echo kt_option('advanced_tracking_code');
        }

    }
    add_action('wp_footer', 'kt_setting_script_footer', 100);
}




