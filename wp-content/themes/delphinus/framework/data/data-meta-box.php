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

    $menus_arr = array('' => esc_html__('Default', 'delphinus'));
    foreach ( $menus as $menu ) {
        $menus_arr[$menu->term_id] = esc_html( $menu->name );
    }

    $rev_options = array();

    if ( class_exists( 'RevSlider' ) ) {
        $revSlider = new RevSlider();
        $arrSliders = $revSlider->getArrSliders();

        if(!empty($arrSliders)){
            foreach($arrSliders as $slider){
                $rev_options[$slider->getParam("alias")] = $slider->getParam("title");
            }
        }
    }

    $ls_options = array();
    if ( is_plugin_active( 'LayerSlider/layerslider.php' ) ) {
        global $wpdb;
        $table_name = $wpdb->prefix . "layerslider";
        $sliders = $wpdb->get_results( "SELECT * FROM ".$table_name." WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY date_c ASC LIMIT 100" );
        if ( $sliders != null && !empty( $sliders ) ) {
            foreach ( $sliders as $item ) :
                $ls_options[$item->id] = $item->name;
            endforeach;
        }
    }

    /**
     * For Testimonial
     *
     */

    $meta_boxes[] = array(
        'title'  => esc_html__('Testimonial Settings','delphinus'),
        'pages'  => array( 'kt_testimonial' ),
        'fields' => array(
            array(
                'name' => esc_html__( 'Company Name / Job Title', 'delphinus' ),
                'id' => $prefix . 'testimonial_company',
                'desc' => esc_html__( "Please type the text for Company Name / Job Title here.", 'delphinus' ),
                'type'  => 'text',
            ),
            array(
                'name' => esc_html__( "URL to Author's Website", 'delphinus' ),
                'id' => $prefix . 'testimonial_link',
                'desc' => esc_html__( "Please type the text for link here.", 'delphinus' ),
                'type'  => 'text',
            )
        ),
    );



    $sidebars = array();

    foreach($GLOBALS['wp_registered_sidebars'] as $sidebar){
        $sidebars[$sidebar['id']] = ucwords( $sidebar['name'] );
    }


    $tabs = array(
        'page_layout' => array(
            'label' => esc_html__( 'Layout', 'delphinus' ),
            'icon'  => 'fa fa-columns',
        ),
        'page_background' => array(
            'label' => esc_html__( 'Background', 'delphinus' ),
            'icon'  => 'fa fa-picture-o',
        )

    );

    $fields = array(



        //Page layout
        array(
            'name' => esc_html__('Type Page Options', 'delphinus'),
            'id'   => "{$prefix}type_page",
            'type' => 'select',
            'options' => array(
                'bullet' => esc_html__('Row Bullet', 'delphinus'),
                //'onepage' => esc_html__('One Page Navigation', 'delphinus'),
            ),
            'std'  => '1',
            'tab'  => 'page_layout',
            'placeholder' => esc_html__('Default', 'delphinus'),
            'desc' => esc_html__('Choose type of page display.', 'delphinus'),
        ),
        array(
            'name' => esc_html__('Sidebar configuration', 'delphinus'),
            'id' => $prefix . 'sidebar',
            'desc' => esc_html__("Choose the sidebar configuration for the detail page.<br/><b>Note: Cart and checkout, My account page always use no sidebars.</b>", 'delphinus'),
            'type' => 'select',
            'options' => array(
                'full' => esc_html__('No sidebars', 'delphinus'),
                'left' => esc_html__('Left Sidebar', 'delphinus'),
                'right' => esc_html__('Right Sidebar', 'delphinus')
            ),
            'placeholder' => esc_html__('Default', 'delphinus'),
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Left sidebar', 'delphinus'),
            'id' => $prefix . 'left_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'delphinus'),
            'visible' => array($prefix . 'sidebar','=', 'left' ),
        ),
        array(
            'name' => esc_html__('Right sidebar', 'delphinus'),
            'id' => $prefix . 'right_sidebar',
            'type' => 'select',
            'tab'  => 'page_layout',
            'options' => $sidebars,
            'desc' => esc_html__("Select your sidebar.", 'delphinus'),
            'visible' => array($prefix . 'sidebar','=', 'right' ),
        ),
        array(
            'name' => esc_html__('Page top spacing', 'delphinus'),
            'id' => $prefix . 'page_top_spacing',
            'desc' => esc_html__("Enter your page top spacing (Example: 100px).", 'delphinus' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Page bottom spacing', 'delphinus'),
            'id' => $prefix . 'page_bottom_spacing',
            'desc' => esc_html__("Enter your page bottom spacing (Example: 100px).", 'delphinus' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Extra page class', 'delphinus'),
            'id' => $prefix . 'extra_page_class',
            'desc' => esc_html__('If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.', 'delphinus' ),
            'type'  => 'text',
            'tab'  => 'page_layout',
        ),
        array(
            'name' => esc_html__('Background', 'delphinus'),
            'id' => $prefix.'background_body',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the OUTER page.', 'delphinus' ),
        ),
        array(
            'name' => esc_html__('Inner Background', 'delphinus'),
            'id' => $prefix.'background_inner',
            'type'  => 'background',
            'tab'  => 'page_background',
            'desc' => esc_html__('The option that will be used as the INNER page.', 'delphinus' ),
        )
    );



    $tabs_page = array(
        'header'  => array(
            'label' => esc_html__( 'Header', 'delphinus' ),
            'icon'  => 'fa fa-desktop',
        ),
        'page_header' => array(
            'label' => esc_html__( 'Page Header', 'delphinus' ),
            'icon'  => 'fa fa-bars',
        )
    );

    $fields_page = array(
        // Page Header
        array(

            'name' => esc_html__( 'Page Header', 'delphinus' ),
            'id' => $prefix . 'page_header',
            'desc' => esc_html__( "Show Page Header.", 'delphinus' ),
            'type' => 'select',
            'options' => array(
                'off'	    => esc_html__('Hidden', 'delphinus'),
                'on'		=> esc_html__('Show', 'delphinus'),
            ),
            'std'  => '',
            'placeholder' => esc_html__('Default', 'delphinus'),
            'tab'  => 'page_header',
        ),
        array(
            'name' => esc_html__( 'Page Header Custom Text', 'delphinus' ),
            'id' => $prefix . 'page_header_custom',
            'desc' => esc_html__( "Enter cstom Text for page header.", 'delphinus' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),
        array(
            'name' => esc_html__( 'Page header subtitle', 'delphinus' ),
            'id' => $prefix . 'page_header_subtitle',
            'desc' => esc_html__( "Enter subtitle for page.", 'delphinus' ),
            'type'  => 'text',
            'tab'  => 'page_header',
            'visible' => array($prefix . 'page_header', '!=', 'off')
        ),

        // Header
        array(
            'name' => esc_html__('Main Navigation Location', 'delphinus'),
            'id'   => "{$prefix}header_main_menu",
            'type' => 'select',
            'options' => $menus_arr,
            'std'  => '',
            'tab'  => 'header',
            'desc' => esc_html__('Choose which menu location to be used in this page. If left blank, Primary Menu will be used.', 'delphinus'),
        ),


        array(
            'name'    => esc_html__( 'Header layout', 'delphinus' ),
            'type'     => 'select',
            'id'       => $prefix.'header_layout',
            'desc'     => esc_html__( "Please choose header layout", 'delphinus' ),
            'options'  => array(
                '1' => esc_html__('Layout 1', 'delphinus'),
                '2' => esc_html__('Layout 2', 'delphinus'),
                '3' => esc_html__('Layout 3', 'delphinus'),
                '4' => esc_html__('Layout 4', 'delphinus'),
                '5' => esc_html__('Layout 5', 'delphinus'),
                '6' => esc_html__('Layout 6', 'delphinus'),
                '7' => esc_html__('Layout 7', 'delphinus'),
            ),
            'placeholder' => esc_html__('Default', 'delphinus'),
            'std'  => 'default',
            'tab'  => 'header',
        ),


        array(
            'name'    => esc_html__( 'Header position', 'delphinus' ),
            'type'     => 'select',
            'id'       => $prefix.'header_position',
            'desc'     => esc_html__( "Please choose header position", 'delphinus' ),
            'options'  => array(
                'below' => esc_html__('Below Slideshow', 'delphinus'),
                'transparent' => esc_html__('Transparent', 'delphinus'),
            ),
            'placeholder' => esc_html__('Default', 'delphinus'),
            'std'  => 'default',
            'tab'  => 'header',
        ),




        array(
            'name' => __('Transparent header Color Scheme', 'delphinus'),
            'id'   => "{$prefix}header_scheme",
            'type' => 'select',
            'options' => array(
                'light'		=> __('Light', 'delphinus'),
            ),
            'placeholder' => esc_html__('Dark', 'delphinus'),
            'tab'  => 'header',
            'visible' => array($prefix . 'header_position', '=' , 'transparent' ),
            'desc'     => esc_html__( "Please choose transparent color scheme", 'delphinus' ),
        ),
        array(
            'name' => esc_html__('Select Your Slideshow Type', 'delphinus'),
            'id' => $prefix . 'slideshow_type',
            'desc' => esc_html__("You can select the slideshow type using this option.", 'delphinus'),
            'type' => 'select',
            'options' => array(
                'revslider' => esc_html__('Revolution Slider', 'delphinus'),
                'layerslider' => esc_html__('Layer Slider', 'delphinus'),
                'custom' => esc_html__('Custom Slider', 'delphinus'),
            ),
            'placeholder' => esc_html__('Select Option', 'delphinus'),
            'tab'  => 'header',
        ),
        array(
            'name' => esc_html__('Select Revolution Slider', 'delphinus'),
            'id' => $prefix . 'rev_slider',
            'default' => true,
            'type' => 'select',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Revolution Slider.', 'delphinus'),
            'visible' => array($prefix . 'slideshow_type', '=', 'revslider'),
            'options' => $rev_options,
            'placeholder' => esc_html__('Select Option', 'delphinus'),
        ),
        array(
            'name' => esc_html__('Select Layer Slider', 'delphinus'),
            'id' => $prefix . 'layerslider',
            'default' => true,
            'type' => 'select',
            'tab'  => 'header',
            'desc' => esc_html__('Select the Layer Slider.', 'delphinus'),
            'visible' => array($prefix . 'slideshow_type', '=', 'layerslider'),
            'options' => $ls_options,
            'placeholder' => esc_html__('Select Option', 'delphinus'),
        ),
        array(
            'name'        => __( 'Custom Slider', 'delphinus' ),
            'id'          => $prefix.'slideshow_custom',
            'type'        => 'textarea',
            'tab'  => 'header',
            'desc' => esc_html__('Put your shortcode in here.', 'delphinus'),
            'visible' => array($prefix . 'slideshow_type', '=', 'custom'),
            'rows'        => 5,
        ),
    );

    /**
     * For Client
     *
     */

    $meta_boxes[] = array(
        'id' => 'client_meta_boxes',
        'title' => 'Client Options',
        'pages' => array( 'kt_client' ),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(

            array(
                'name' => esc_html__( 'Link Client', 'delphinus' ),
                'id' => $prefix . 'link_client',
                'desc' => esc_html__( "Link Client.", 'delphinus' ),
                'type'  => 'text',
            ),

        )
    );

    /**
     * For Page Options
     *
     */
    $meta_boxes[] = array(
        'id'        => 'page_meta_boxes',
        'title'     => esc_html__('Page Options', 'delphinus'),
        'pages'     => array( 'page' ),
        'tabs'      => array_merge( $tabs,$tabs_page),
        'fields'    => array_merge( $fields,$fields_page),
    );


    $tabs_post = array(
        'post_general'  => array(
            'label' => esc_html__( 'General', 'delphinus' ),
            'icon'  => 'fa fa-bars',
        ),
        'post_header'  => array(
            'label' => esc_html__( 'Header', 'delphinus' ),
            'icon'  => 'fa fa-desktop',
        )
    );

    $fields_post = array(
        //General
        array(
            'type' => 'image_radio',
            'name' => esc_html__('Post layouts', 'delphinus'),
            'desc' => esc_html__('Select the your post layout.', 'delphinus'),
            'id'   => "{$prefix}blog_post_layout",
            'options' => array(
                ''    => array('url' => KT_FW_IMG . 'single/default.jpg', 'alt' => esc_html__('Default', 'delphinus')),
                1     => array('url' => KT_FW_IMG . 'single/layout-1.jpg', 'alt' => esc_html__('Layout 1', 'delphinus')),
                2     => array('url' => KT_FW_IMG . 'single/layout-2.jpg', 'alt' => esc_html__('Layout 2', 'delphinus')),
                3     => array('url' => KT_FW_IMG . 'single/layout-3.jpg', 'alt' => esc_html__('Layout 3', 'delphinus')),
                4     => array('url' => KT_FW_IMG . 'single/layout-4.jpg', 'alt' => esc_html__('Layout 4', 'delphinus')),
                5     => array('url' => KT_FW_IMG . 'single/layout-5.jpg', 'alt' => esc_html__('Layout 5', 'delphinus')),
                6     => array('url' => KT_FW_IMG . 'single/layout-6.jpg', 'alt' => esc_html__('Layout 6', 'delphinus')),
            ),
            'attributes' => '',
            'std' => '',
            'tab'  => 'post_general',
        ),
        array(
            'name' => esc_html__('Previous & next buttons', 'delphinus'),
            'id'   => "{$prefix}prev_next",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'delphinus'),
                'off'		=> esc_html__('Hidden', 'delphinus'),
                'on'		=> esc_html__('Show', 'delphinus'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'delphinus')
        ),
        array(
            'name' => esc_html__('Author info', 'delphinus'),
            'id'   => "{$prefix}author_info",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'delphinus'),
                'off'		=> esc_html__('Hidden', 'delphinus'),
                'on'		=> esc_html__('Show', 'delphinus'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'delphinus')
        ),
        array(
            'name' => esc_html__('Social sharing', 'delphinus'),
            'id'   => "{$prefix}social_sharing",
            'type' => 'select',
            'options' => array(
                ''    => esc_html__('Default', 'delphinus'),
                'off'		=> esc_html__('Hidden', 'delphinus'),
                'on'		=> esc_html__('Show', 'delphinus'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'delphinus')
        ),
        array(
            'name' => esc_html__('Related articles', 'delphinus'),
            'id'   => "{$prefix}related_acticles",
            'type' => 'select',
            'options' => array(
                ''      => esc_html__('Default', 'delphinus'),
                'off'    => esc_html__('Hidden', 'delphinus'),
                'on'	=> esc_html__('Show', 'delphinus'),
            ),
            'std'  => '',
            'tab'  => 'post_general',
            'desc' => esc_html__('Select "Default" to use settings in Theme Options', 'delphinus')
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


    /**
     * Product Settings
     *
     */
    $meta_boxes[] = array(
        'title'  => __('Product Settings','delphinus'),
        'pages'  => array( 'product' ),
        'fields' => array(
            //General
            array(
                'name' => esc_html__('Product layout', 'delphinus'),
                'id' => $prefix . 'detail_layout',
                'desc' => esc_html__("Choose the layout for the product detail display.", 'delphinus'),
                'type' => 'select',
                'placeholder' => esc_html__('Default', 'delphinus'),
                'options' => array(
                    'layout1' => esc_html__('Layout 1', 'delphinus'),
                    'layout2' => esc_html__('Layout 2', 'delphinus'),
                    'layout3' => esc_html__('Layout 3', 'delphinus'),
                ),
            ),
            array(
                'name'        => __( 'Short Description in List view', 'delphinus' ),
                'id'          => $prefix.'short_description',
                'desc'        => __( 'You can optionally write a short description here, which shows in List view (Product Archive).', 'delphinus' ),
                'type'        => 'textarea',
                'placeholder' => __( 'Empty if you want use Product Short Description', 'delphinus' ),
                'rows'        => 5,
            ),
            array(
                'id'               => $prefix .'image',
                'name'             => __( 'Image transparent', 'delphinus' ),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
                'desc' => esc_html__("Select image for carousel featured. (", 'delphinus'),
            ),
            array(
                'name' => __('Disposition', 'delphinus'),
                'id' => $prefix . 'box_size',
                'desc' => __('Select disposition for Packery display', 'delphinus'),
                'type'     => 'select',
                'options'  => array(
                    'landscape' => __('Landscape (2x1)', 'delphinus'),
                    'portrait' => __('Portrait (1x2)', 'delphinus'),
                    'wide' => __('Wide (2x2)', 'delphinus'),
                    'big' => __('Big (3x2)', 'delphinus'),
                ),
                'std'  => 'normal'
            ),
        ),
    );
    
    
    return $meta_boxes;
}


