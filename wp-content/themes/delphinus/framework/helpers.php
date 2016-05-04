<?php

/**
 * All helpers for theme
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Function check if WC Plugin installed
 */
function kt_is_wc(){
    return function_exists('is_woocommerce');
}

/**
 *  @true  if WPML installed.
 */
function  kt_is_wpml(){
    return class_exists('SitePress');
}



if (!function_exists('kt_option')){
    /**
     * Function to get options in front-end
     * @param int $option The option we need from the DB
     * @param string $default If $option doesn't exist in DB return $default value
     * @return string
     */

    function kt_option( $option = false, $default = false ){
        if($option === FALSE){
            return FALSE;
        }
        $kt_options = wp_cache_get( KT_THEME_OPTIONS );
        if(  !$kt_options ){
            $kt_options = get_option( KT_THEME_OPTIONS );
            wp_cache_delete( KT_THEME_OPTIONS );
            wp_cache_add( KT_THEME_OPTIONS, $kt_options );
        }

        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}




if (!function_exists('kt_get_image_sizes')){

    /**
     * Get image sizes
     *
     * @return array
     */
    function kt_get_image_sizes( $full = true, $custom = false ) {

        global $_wp_additional_image_sizes;
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        $sizes = array();
        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {

            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
                $sizes[ $_size ] = array(
                    'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                    'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                    'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
                );
            }

            $option_text = array();
            $option_text[] = ucfirst(str_replace('_', ' ', $_size));
            if( isset($sizes[ $_size ]) ){
                $option_text[] = '('.$sizes[ $_size ]['width'].' x '.$sizes[ $_size ]['height'].')';
                if($sizes[ $_size ]['crop']){
                    $option_text[] = esc_html__('Crop', 'delphinus');
                }
                $sizes[ $_size ] = implode(' - ', $option_text);
            }
        }

        if($full){
            $sizes[ 'full' ] = esc_html__('Full', 'delphinus');
        }
        if($custom){
            $sizes[ 'custom' ] = esc_html__('Custom size', 'delphinus');
        }

        return $sizes;
    }

}



if (!function_exists('kt_sidebars')){
    /**
     * Get sidebars
     *
     * @return array
     */
    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $item ) {
            $sidebars[$item['id']] = $item['name'];
        }
        return $sidebars;
    }
}

if (!function_exists('kt_getlayout')) {
    /**
     * Get Layout of post
     *
     * @param number $post_id Optional. ID of article or page.
     * @return string
     *
     */
    function kt_getlayout($post_id = null){
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $layout = rwmb_meta('_kt_layout', array(),  $post_id);
        if($layout == 'default' || !$layout){
            $layout = kt_option('layout', 'full');
        }

        return $layout;
    }
}

if (!function_exists('kt_show_slideshow')) {
    /**
     * Show slideshow of page
     *
     * @param $post_id
     *
     */
    function kt_show_slideshow($post_id = null)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;

        $slideshow = rwmb_meta('_kt_slideshow_type', array(), $post_id);
        $sideshow_class = array();
        $output = '';

        if ($slideshow == 'revslider') {
            $revslider = rwmb_meta('_kt_rev_slider', array(), $post_id);
            if ($revslider && class_exists('RevSlider')) {
                ob_start();
                putRevSlider($revslider);
                $revslider_html = ob_get_contents();
                ob_end_clean();
                $output .= $revslider_html;
            }
        } elseif ($slideshow == 'layerslider') {
            $layerslider = rwmb_meta('_kt_layerslider', array(), $post_id);
            if ($layerslider && is_plugin_active('LayerSlider/layerslider.php')) {
                $layerslider_html = do_shortcode('[layerslider id="' . $layerslider . '"]');
                if($layerslider_html){
                    $output .= $layerslider_html;
                }
            }
        }elseif($slideshow == 'custom'){
            $customslider = rwmb_meta('_kt_slideshow_custom', array(), $post_id);
            $output .= do_shortcode($customslider);
        }

        if($output != ''){
            printf(
                '<div id="main-slideshow" class="%s"><div id="sideshow-inner">%s</div></div>',
                esc_attr(implode(' ', $sideshow_class)),
                $output
            );
        }
    }
}


if (!function_exists('kt_get_header')) {
    /**
     * Get Header
     *
     * @return string
     *
     */
    function kt_get_header_position(){
        $header = 'default';
        $header_position = '';

        if(is_page()){
            $header_position = rwmb_meta('_kt_header_position');
        }

        if($header_position){
            $header = $header_position;
        }
        return $header;
    }
}


if (!function_exists('kt_get_header_layout')) {
    /**
     * Get Header Layout
     *
     * @return string
     *
     */
    function kt_get_header_layout(){

        $layout = null;

        if(is_page()){
            $layout = rwmb_meta('_kt_header_layout');
        }

        if(isset($_REQUEST['header_layout'])){
            $layout = $_REQUEST['header_layout'];
        }

        if(!$layout){
            $layout = kt_option('header', '1');
        }

        return $layout;
    }
}


if (!function_exists('kt_get_logo')){
    /**
     * Get logo of current page
     *
     * @return string
     *
     */
    function kt_get_logo(){
        $logo = array('default' => '', 'retina' => '', 'light' => '', 'light_retina' => '');
        $logo_default = kt_option( 'logo' );
        $logo_retina = kt_option( 'logo_retina' );
        $logo_light = kt_option( 'logo_light' );
        $logo_light_retina = kt_option( 'logo_light_retina' );

        if(is_array($logo_default) && $logo_default['url'] != '' ){
            $logo['default'] = $logo_default['url'];
        }

        if(is_array($logo_retina ) && $logo_retina['url'] != '' ){
            $logo['retina'] = $logo_retina['url'];
        }

        if(is_array($logo_light) && $logo_light['url'] != '' ){
            $logo['light'] = $logo_light['url'];
        }

        if(is_array($logo_light_retina ) && $logo_light_retina['url'] != '' ){
            $logo['light_retina'] = $logo_light_retina['url'];
        }

        if(!$logo['default']){
            $logo['default'] = KT_THEME_IMG.'logo.png';
            $logo['retina'] = KT_THEME_IMG.'logo-2x.png';
        }

        if(!$logo['light']){
            $logo['light'] = KT_THEME_IMG.'logo-light.png';
            $logo['light_retina'] = KT_THEME_IMG.'logo-light-2x.png';
        }

        return $logo;
    }
}



if (!function_exists('kt_get_archive_sidebar')) {
    /**
     * Get Archive sidebar
     *
     * @return array
     */
    function kt_get_archive_sidebar()
    {
        if( isset($_REQUEST['sidebar'] )){
            $sidebar = array('sidebar' => $_REQUEST['sidebar'], 'sidebar_area' => '');
            if($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }
            if(isset( $_REQUEST['area'])){
                $sidebar['sidebar_area'] = $_REQUEST['area'];
            }elseif(!$sidebar['sidebar_area']){
                $sidebar['sidebar_area'] = 'blog-widget-area';
            }
        }elseif(is_search()){
            $sidebar = array(
                'sidebar' => kt_option('search_sidebar', 'full'),
                'sidebar_area' => ''
            );
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('search_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'full'){
                $sidebar['sidebar'] = '';
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('search_sidebar_right', 'primary-widget-area');
            }
        }else{
            $default = false;
            if(is_home()) {
                $post_id = get_option('page_for_posts');
                $sidebar = array(
                    'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
                    'sidebar_area' => '',
                );

                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
                }elseif($sidebar['sidebar'] == 'full'){
                    $sidebar['sidebar'] = '';
                }else{
                    $default = true;
                }
            }else{
                $default = true;
            }

            if($default){
                $sidebar = array(
                    'sidebar' => kt_option('archive_sidebar', 'right'),
                    'sidebar_area' => '',
                );
                if($sidebar['sidebar'] == 'left' ){
                    $sidebar['sidebar_area'] = kt_option('archive_sidebar_left', 'primary-widget-area');
                }elseif($sidebar['sidebar'] == 'right'){
                    $sidebar['sidebar_area'] = kt_option('archive_sidebar_right', 'primary-widget-area');
                }elseif($sidebar['sidebar'] == 'full'){
                    $sidebar['sidebar'] = '';
                }

            }
        }

        return apply_filters('kt_archive_sidebar', $sidebar);
    }
}


if (!function_exists('kt_get_archive_layout')) {
    /**
     * Get Archive layout
     *
     * @return array
     */
    function kt_get_archive_layout()
    {
        $layout = array('type' => '', 'columns' => '', 'columns_tab' => 2, 'readmore' => '');

        if (isset($_REQUEST['type'])) {
            $layout['type'] = $_REQUEST['type'];
            $layout['pagination'] = 'normal';
            if(isset($_REQUEST['columns'])){
                $layout['columns'] = $_REQUEST['columns'];
            }else{
                $layout['columns'] = kt_option('archive_columns', 2);
            }
            $layout['readmore'] = kt_option('archive_readmore', 'none');
        } elseif (is_search()) {
            $layout['type'] = kt_option('search_loop_style', 'grid');
            $layout['columns'] = kt_option('search_columns', 3);
            $layout['pagination'] = kt_option('search_pagination', 'normal');
            $layout['readmore'] = kt_option('search_readmore', 'none');
        } else {
            $layout['type'] = kt_option('archive_loop_style', 'gird');
            $layout['columns'] = kt_option('archive_columns', 2);
            $layout['pagination'] = kt_option('archive_pagination', 'normal');
            $layout['readmore'] = kt_option('archive_readmore', 'none');
        }

        if($layout['type'] == 'classic'){
            $layout['readmore'] = '';
        }

        return apply_filters('kt_archive_layout', $layout);
    }
}




if (!function_exists('kt_get_page_sidebar')) {
    /**
     * Get page sidebar
     *
     * @param null $post_id
     * @return mixed|void
     */
    function kt_get_page_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );

        if(isset($_REQUEST['sidebar'])){
            $sidebar['sidebar'] = $_REQUEST['sidebar'];
        }

        if(kt_is_wc()){
            if(is_cart() || is_checkout() || is_account_page()){
                $sidebar['sidebar'] = 'full';
            }elseif(defined( 'YITH_WCWL' )){
                $wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
                if($post_id == $wishlist_page_id){
                    $sidebar['sidebar'] = 'full';
                }
            }
        }



        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('page_sidebar', '');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('page_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('page_sidebar_right', 'primary-widget-area');
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }

        return apply_filters('kt_page_sidebar', $sidebar);
    }
}


if (!function_exists('kt_get_post_sidebar')) {
    /**
     * Get post sidebar
     *
     * @param null $post_id
     * @return mixed|void
     */
    function kt_get_post_sidebar( $post_id = null )
    {
        global $post;
        if(!$post_id) $post_id = $post->ID;

        $sidebar = array(
            'sidebar' => rwmb_meta('_kt_sidebar', array(), $post_id),
            'sidebar_area' => '',
        );

        if(isset($_REQUEST['sidebar'])){
            $sidebar['sidebar'] = $_REQUEST['sidebar'];
        }

        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' || $sidebar['sidebar'] == '0' ){
            $sidebar['sidebar'] = kt_option('single_sidebar');
            if($sidebar['sidebar'] == 'left' ){
                $sidebar['sidebar_area'] = kt_option('single_sidebar_left', 'primary-widget-area');
            }elseif($sidebar['sidebar'] == 'right'){
                $sidebar['sidebar_area'] = kt_option('single_sidebar_right', 'primary-widget-area');
            }
        }elseif($sidebar['sidebar'] == 'left'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_left_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'right'){
            $sidebar['sidebar_area'] = rwmb_meta('_kt_right_sidebar', array(), $post_id);
        }elseif($sidebar['sidebar'] == 'full'){
            $sidebar['sidebar'] = '';
        }

        return apply_filters('kt_single_sidebar', $sidebar);
    }
}




if (!function_exists('kt_custom_wpml')){
    /**
     * Custom wpml
     *
     */

    function kt_custom_wpml($before = '', $after = '', $icon = ''){

        if(kt_is_wpml()){

            $output = $language_html = '';


            $languages = icl_get_languages();

            if(!empty($languages)) {
                foreach ($languages as $l) {
                    if($l['active']){
                        $selected = 'current';
                        $currency_lang = $l['language_code'];
                    }else{
                        $selected = '';
                    }

                    $language_html .= '<li class="'.$selected.'">';
                    $language_html .= '<a href="' . esc_url($l['url']) . '">';
                    $language_html .= "<span>" . strtoupper($l['language_code']) . "</span>";
                    $language_html .= '</a>';
                    $language_html .= '</li>';
                }

                if ($language_html != '') {
                    $language_html = '<a href="#">'.$currency_lang.'</a><ul class="list-lang navigation-submenu">' . $language_html . '</ul>';
                }

                $output .= $language_html;
            }

            echo $before.$output.$after;

        }

    }
}


/**
 * Render Carousel
 *
 * @param $data array, All option for carousel
 * @param $class string, Default class for carousel
 *
 * @return void
 */

function kt_render_carousel($data, $extra = '', $class = 'owl-carousel kt-owl-carousel'){
    $data = shortcode_atts( array(
        'gutters' => true,
        'autoheight' => true,
        'autoplay' => false,
        'mousedrag' => true,
        'autoplayspeed' => 5000,
        'slidespeed' => 200,
        'carousel_skin' => '',

        'desktop' => 4,
        'desktopsmall' => '',
        'tablet' => 2,
        'mobile' => 1,

        'navigation' => true,
        'navigation_always_on' => false,
        'navigation_position' => 'center-outside',
        'navigation_style' => 'normal',

        'pagination' => false,
        'pagination_position' => 'center-bottom',
        'pagination_style' => 'dot-stroke',

        'callback' => ''

    ), $data );

    if(!$data['desktopsmall']){
        $data['desktopsmall'] = $data['desktop'];
    }

    extract( $data );


    $autoheight = apply_filters('sanitize_boolean', $autoheight);
    $autoplay = apply_filters('sanitize_boolean', $autoplay);
    $mousedrag = apply_filters('sanitize_boolean', $mousedrag);
    $navigation = apply_filters('sanitize_boolean', $navigation);
    $navigation_always_on = apply_filters('sanitize_boolean', $navigation_always_on);
    $pagination = apply_filters('sanitize_boolean', $pagination);

    $output = '';

    $owl_carousel_class = array(
        'owl-carousel-kt',
        'navigation-'.$navigation_position,
        $extra
    );

    if($carousel_skin){
        $owl_carousel_class[] = 'carousel-skin-'.$carousel_skin;
    }

    if($gutters){
        $owl_carousel_class[] = 'carousel-gutters';
    }

    if($navigation){
        if($navigation_always_on){
            $owl_carousel_class[] = 'visiable-navigation';
        }
        $owl_carousel_class[] = 'navigation-'.$navigation_style;
    }

    if($pagination){
        $owl_carousel_class[] = 'pagination-'.$pagination_position;
        $owl_carousel_class[] = 'pagination-'.$pagination_style;
    }


    $autoplay = ($autoplay) ? $autoplayspeed : $autoplay;

    $data_carousel = array(
        'mouseDrag' => $mousedrag,
        "autoHeight" => $autoheight,
        "autoPlay" => $autoplay,
        "navigation" => $navigation,
        'navigation_pos' => $navigation_position,
        'pagination' => $pagination,
        'pagination_pos' => $pagination_position,
        "slideSpeed" => $slidespeed,
        'desktop' => $desktop,
        'desktopsmall' => $desktopsmall,
        'tablet' => $tablet,
        'mobile' => $mobile,
        'callback' => $callback

    );


    $output .= '<div class="'.esc_attr(implode(' ', $owl_carousel_class)).'">';
    $output .= '<div class=" '.$class.'" '.render_data_carousel($data_carousel).'>%carousel_html%</div>';
    $output .= '</div>';

    return $output;
}


if (!function_exists('render_data_carousel')) {

    /*
     * Render data option for carousel
     * @param $data
     * @return string
     */
    function render_data_carousel($data)
    {
        $output = "";
        $array = array();
        foreach ($data as $key => $val) {
            if (is_bool($val) === true) {
                $val = ($val) ? 'true': 'false';
                $array[$key]= '"'.$key.'": '.$val;
            }else{
                $array[$key]= '"'.$key.'": "'.$val.'"';
            }
        }

        if(count($array)){
            $output = " data-options='{".implode(',', $array)."}'";
        }

        return $output;
    }
}


if(!function_exists('kt_color2hecxa')){
    /**
     * Convert color to hex
     *
     * @param $color
     * @return string
     */
    function kt_color2Hex($color){
        switch ($color) {
            case 'mulled_wine': $color = '#50485b'; break;
            case 'vista_blue': $color = '#75d69c'; break;
            case 'juicy_pink': $color = '#f4524d'; break;
            case 'sandy_brown': $color = '#f79468'; break;
            case 'purple': $color = '#b97ebb'; break;
            case 'pink': $color = '#fe6c61'; break;
            case 'violet': $color = '#8d6dc4'; break;
            case 'peacoc': $color = '#4cadc9'; break;
            case 'chino': $color = '#cec2ab'; break;
            case 'grey': $color = '#ebebeb'; break;
            case 'orange': $color = '#f7be68'; break;
            case 'sky': $color = '#5aa1e3'; break;
            case 'green': $color = '#6dab3c'; break;
            case 'accent': $color = kt_option('styling_accent', '#82c14f'); break;

        }
        return $color;
    }
}

if (!function_exists('kt_get_single_file')) {
    /**
     * Get Single file form meta box.
     *
     * @param string $meta . meta id of article.
     * @param string|array $size Optional. Image size. Defaults to 'screen'.
     * @param array $post_id Optional. ID of article.
     * @return array
     */
    function kt_get_single_file($meta, $size = 'thumbnail' ,$post_id = null)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;

        $medias = rwmb_meta($meta, 'type=image&size='.$size, $post_id);
        if (count($medias)) {
            foreach ($medias as $media) {
                return $media;
            }
        }
        return false;
    }
}


if (!function_exists('kt_post_option')) {
    /**
     * Check option for in article
     *
     * @param number $post_id Optional. ID of article.
     * @param string $meta Optional. meta oftion in article
     * @param string $option Optional. if meta is Global, Check option in theme option.
     * @param string $default Optional. Default vaule if theme option don't have data
     * @return boolean
     */
    function kt_post_option($post_id = null, $meta = '', $option = '', $default = null, $boolean = true)
    {
        global $post;
        if (!$post_id) $post_id = $post->ID;
        $meta_v = get_post_meta($post_id, $meta, true);

        if ($meta_v == '' || $meta_v == 0) {
            $meta_v = kt_option($option, $default);
        }
        $ouput = ($boolean) ? apply_filters('kt_sanitize_boolean', $meta_v) : $meta_v;
        return $ouput;
    }
}