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
                    $option_text[] = esc_html__('Crop', 'adroit');
                }
                $sizes[ $_size ] = implode(' - ', $option_text);
            }
        }

        if($full){
            $sizes[ 'full' ] = esc_html__('Full', 'adroit');
        }
        if($custom){
            $sizes[ 'custom' ] = esc_html__('Custom size', 'adroit');
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
        $layout = (isset($_REQUEST['header_layout'])) ?  isset($_REQUEST['header_layout']) : null;
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
        $logo = array('default' => '', 'retina' => '');
        $logo_default = kt_option( 'logo' );
        $logo_retina = kt_option( 'logo_retina' );

        if(is_array($logo_default) && $logo_default['url'] != '' ){
            $logo['default'] = $logo_default['url'];
        }

        if(is_array($logo_retina ) && $logo_retina['url'] != '' ){
            $logo['retina'] = $logo_retina['url'];
        }

        if(!$logo['default']){
            $logo['default'] = KT_THEME_IMG.'logo.png';
            $logo['retina'] = KT_THEME_IMG.'logo-2x.png';
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
        $layout = array('type' => '', 'columns' => '', 'columns_tab' => 2);
        if (isset($_REQUEST['type'])) {
            $layout['type'] = $_REQUEST['type'];
            $layout['pagination'] = 'normal';
            if(isset($_REQUEST['columns'])){
                $layout['columns'] = $_REQUEST['columns'];
            }else{
                $layout['columns'] = kt_option('archive_columns', 2);
            }
        } elseif (is_search()) {
            $layout['type'] = kt_option('search_loop_style', 'grid');
            $layout['columns'] = kt_option('search_columns', 3);
            $layout['pagination'] = kt_option('search_pagination', 'normal');
        } else {
            $layout['type'] = kt_option('archive_loop_style', 'gird');
            $layout['columns'] = kt_option('archive_columns', 2);
            $layout['pagination'] = kt_option('archive_pagination', 'normal');
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

        if($sidebar['sidebar'] == '' || $sidebar['sidebar'] == 'default' ){
            $sidebar['sidebar'] = kt_option('page_sidebar');
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




if (!function_exists('kt_custom_wpml')){
    /**
     * Custom wpml
     *
     */

    function kt_custom_wpml($before = '', $after = '', $title = '', $icon = '<i class="icon_ribbon_alt"></i>'){

        if(kt_is_wpml()){

            $output = $language_html = '';

            if($title){
                $output .= '<a href="#">'.$icon.$title.'</a>';
            }

            $languages = icl_get_languages();

            if(!empty($languages)) {
                foreach ($languages as $l) {
                    $active = ($l['active']) ? 'current' : '';

                    $language_html .= '<li class="'.$active.'">';
                    $language_html .= '<a href="' . esc_url($l['url']) . '">';
                    if ($l['country_flag_url']) {
                        $language_html .= '<img src="' . esc_url($l['country_flag_url']) . '" height="12" alt="' . esc_attr($l['language_code']) . '" width="18" />';
                    }
                    $language_html .= "<span>" . $l['native_name'] . "</span>";
                    $language_html .= '</a>';

                    $language_html .= '</li>';
                }

                if ($language_html != '') {
                    $language_html = '<ul class="list-lang">' . $language_html . '</ul>';
                }

                $output .= $language_html;
            }

            echo $before.$output.$after;

        }

    }
}


