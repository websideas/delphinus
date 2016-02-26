<?php
/**
 * All helpers for theme
 *
 */
 
 
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;




add_filter( 'rwmb_meta_boxes', 'kt_register_meta_boxes' );
function kt_register_meta_boxes( $meta_boxes )
{

    $prefix = '_kt_';
    $menus = wp_get_nav_menus();

    $menus_arr = array('' => esc_html__('Default', 'adroit'));
    foreach ( $menus as $menu ) {
        $menus_arr[$menu->term_id] = esc_html( $menu->name );
    }

    $sidebars = array();

    foreach($GLOBALS['wp_registered_sidebars'] as $sidebar){
        $sidebars[$sidebar['id']] = ucwords( $sidebar['name'] );
    }


    $tabs = array(
        'page_layout' => array(
            'label' => esc_html__( 'Layout', 'adroit' ),
            'icon'  => 'fa fa-columns',
        ),
        'page_background' => array(
            'label' => esc_html__( 'Background', 'adroit' ),
            'icon'  => 'fa fa-picture-o',
        )

    );

    $fields = array(



        //Page layout
        array(
            'name' => esc_html__('Page layout', 'adroit'),
            'id' => $prefix . 'layout',
            'desc' => esc_html__("Please choose this page's layout.", 'adroit'),
            'type' => 'select',
            'options' => array(
                'default' => esc_html__('Default', 'adroit'),
                'full' => esc_html__('Full width Layout', 'adroit'),
                'boxed' => esc_html__('Boxed Layout', 'adroit'),
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Sidebar configuration', 'adroit'),
            'id' => $prefix . 'sidebar',
            'desc' => esc_html__("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", 'adroit'),
            'type' => 'select',
            'options' => array(
                0 => esc_html__('Default', 'adroit'),
                'full' => esc_html__('No sidebars', 'adroit'),
                'left' => esc_html__('Left Sidebar', 'adroit'),
                'right' => esc_html__('Right Sidebar', 'adroit')
            ),
            'std' => 'default',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Left sidebar', 'adroit'),
            'id' => $prefix . 'left_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'adroit'),
            'visible' => array($prefix . 'sidebar','=', 'left' ),
        ),
        array(
            'name' => esc_html__('Right sidebar', 'adroit'),
            'id' => $prefix . 'right_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'adroit'),
            'visible' => array($prefix . 'sidebar','=', 'right' ),
        ),
        array(
            'name' => esc_html__('Page top spacing', 'adroit'),
            'id' => $prefix . 'page_top_spacing',
            'desc' => esc_html__("Enter your page top spacing (Example: 100px).", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Page bottom spacing', 'adroit'),
            'id' => $prefix . 'page_bottom_spacing',
            'desc' => esc_html__("Enter your page bottom spacing (Example: 100px).", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Extra page class', 'adroit'),
            'id' => $prefix . 'extra_page_class',
            'desc' => esc_html__('If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Background', 'adroit'),
            'id' => $prefix.'background_body',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the OUTER page.', 'adroit' ),
        ),
        array(
            'name' => esc_html__('Inner Background', 'adroit'),
            'id' => $prefix.'background_inner',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the INNER page.', 'adroit' ),
        )
    );



    $tabs_page = array(
        'header'  => array(
            'label' => esc_html__( 'Header', 'adroit' ),
            'icon'  => 'fa fa-desktop',
        ),
        'page_header' => array(
            'label' => esc_html__( 'Page Header', 'adroit' ),
            'icon'  => 'fa fa-bars',
        )
    );

    $fields_page = array(
        // Page Header
        array(

            'name' => esc_html__( 'Page Header', 'adroit' ),
            'id' => $prefix . 'page_header',
            'desc' => esc_html__( "Show Page Header.", 'adroit' ),
            'type' => 'select',
            'options' => array(
                ''          => esc_html__('Default', 'adroit'),
                'off'	    => esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'page_header',
        ),
        array(
            'name' => esc_html__( 'Page Header Custom Text', 'adroit' ),
            'id' => $prefix . 'page_header_custom',
            'desc' => esc_html__( "Enter cstom Text for page header.", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),
        array(
            'name' => esc_html__( 'Page header subtitle', 'adroit' ),
            'id' => $prefix . 'page_header_subtitle',
            'desc' => esc_html__( "Enter subtitle for page.", 'adroit' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),

        // Header
        array(
            'name'    => esc_html__( 'Header position', 'adroit' ),
            'type'     => 'select',
            'id'       => $prefix.'header_position',
            'desc'     => esc_html__( "Please choose header position", 'adroit' ),
            'options'  => array(
                'default' => esc_html__('Default', 'adroit'),
                'below' => esc_html__('Below Slideshow', 'adroit'),
            ),
            'std'  => 'default',
            'tab'  => 'header',
        ),
        array(
            'name' => esc_html__('Select Your Slideshow Type', 'adroit'),
            'id' => $prefix . 'slideshow_type',
            'desc' => esc_html__("You can select the slideshow type using this option.", 'adroit'),
            'type' => 'select',
            'options' => array(
                '' => esc_html__('Select Option', 'adroit'),
                'revslider' => esc_html__('Revolution Slider', 'adroit'),
                'layerslider' => esc_html__('Layer Slider', 'adroit'),
            ),
            'tab'  => 'header',
        ),
        array(
            'name' => esc_html__('Select Revolution Slider', 'adroit'),
            'id' => $prefix . 'rev_slider',
            'default' => true,
            'type' => 'revSlider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Revolution Slider.', 'adroit'),
            'visible' => array($prefix . 'slideshow_type', '=', 'revslider')
        ),
        array(
            'name' => esc_html__('Select Layer Slider', 'adroit'),
            'id' => $prefix . 'layerslider',
            'default' => true,
            'type' => 'layerslider',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Layer Slider.', 'adroit'),
            'visible' => array($prefix . 'slideshow_type', '=', 'layerslider')
        )
    );

    /**
     * For Page Options
     *
     */
    $meta_boxes[] = array(
        'id'        => 'page_meta_boxes',
        'title'     => esc_html__('Page Options', 'adroit'),
        'pages'     => array( 'page' ),
        'tabs'      => array_merge( $tabs,$tabs_page),
        'fields'    => array_merge( $fields,$fields_page),
    );


    $tabs_post = array(
        'post_general'  => array(
            'label' => esc_html__( 'General', 'adroit' ),
            'icon'  => 'fa fa-bars',
        ),
        'post_header'  => array(
            'label' => esc_html__( 'Header', 'adroit' ),
            'icon'  => 'fa fa-desktop',
        )
    );

    $fields_post = array(
        //General
        array(
            'type' => 'image_radio',
            'name' => esc_html__('Post layouts', 'adroit'),
            'desc' => esc_html__('Select the your post layout.', 'adroit'),
            'id'   => "{$prefix}blog_post_layout",
            'options' => array(
                ''    => array('url' => KT_FW_IMG . 'single/default.jpg', 'alt' => esc_html__('Default', 'adroit')),
                1     => array('url' => KT_FW_IMG . 'single/layout-1.jpg', 'alt' => esc_html__('Layout 1', 'adroit')),
                2     => array('url' => KT_FW_IMG . 'single/layout-2.jpg', 'alt' => esc_html__('Layout 2', 'adroit')),
                3     => array('url' => KT_FW_IMG . 'single/layout-3.jpg', 'alt' => esc_html__('Layout 3', 'adroit')),
                4     => array('url' => KT_FW_IMG . 'single/layout-4.jpg', 'alt' => esc_html__('Layout 4', 'adroit')),
                5     => array('url' => KT_FW_IMG . 'single/layout-5.jpg', 'alt' => esc_html__('Layout 5', 'adroit')),
                6     => array('url' => KT_FW_IMG . 'single/layout-6.jpg', 'alt' => esc_html__('Layout 6', 'adroit')),
            ),
            'attributes' => '',
            'std' => '',
            'tab'  => 'post_general',
        ),
        array(
            'name' => esc_html__('Previous & next buttons', 'adroit'),
            'id'   => "{$prefix}prev_next",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Author info', 'adroit'),
            'id'   => "{$prefix}author_info",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Social sharing', 'adroit'),
            'id'   => "{$prefix}social_sharing",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'adroit'),
                'off'		=> esc_html__('Hidden', 'adroit'),
                'on'		=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),
        array(
            'name' => esc_html__('Related articles', 'adroit'),
            'id'   => "{$prefix}related_acticles",
            'type' => 'select',
            'options' => array(
                ''      => esc_html__('Default', 'adroit'),
                'off'    => esc_html__('Hidden', 'adroit'),
                'on'	=> esc_html__('Show', 'adroit'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'adroit')
        ),

    );

    /**
     * For Posts Options
     *
     */
    $meta_boxes[] = array(
        'id' => 'post_meta_boxes',
        'title' => 'Post Options',
        'pages' => array('post'),
        'tabs'      => array_merge( $tabs_post, $tabs ),
        'fields'    => array_merge( $fields_post, $fields),
    );

    return $meta_boxes;
}


