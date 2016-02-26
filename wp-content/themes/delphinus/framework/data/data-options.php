<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


if ( ! class_exists( 'KT_config' ) ) {

    class KT_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings()
        {

            $this->theme = wp_get_theme();
            $this->setArguments();
            $this->setSections();
            if (!isset($this->args['opt_name'])) {
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setArguments()
        {

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => KT_THEME_OPTIONS,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $this->theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $this->theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Theme Options', 'adroit'),

                'page_title' => $this->theme->get('Name') . ' ' . esc_html__('Theme Options', 'adroit'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                // Show the time the page took to load, etc
                'update_notice' => false,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => false,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => 'dashicons-art',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => 'theme_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => true,
                // REMOVE
            );

            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/kitethemes/',
                'title' => esc_html__('Like us on Facebook', 'adroit'),
                'icon' => 'el-icon-facebook'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/Kite-Themes/follow?ref=Kite-Themes',
                'title' => esc_html__('Follow us on Themeforest', 'adroit'),
                'icon' => 'fa fa-wordpress'
            );

            $this->args['share_icons'][] = array(
                'url' => '#',
                'title' => esc_html__('Get Email Newsletter', 'adroit'),
                'icon' => 'fa fa-envelope-o'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/kite-themes/portfolio',
                'title' => esc_html__('Check out our works', 'adroit'),
                'icon' => 'fa fa-briefcase'
            );
        }

        public function setSections()
        {

            $image_sizes = kt_get_image_sizes();

            $this->sections[] = array(
                'id'    => 'general',
                'title'  => esc_html__( 'General', 'adroit' ),
                'icon'  => 'fa fa-cogs'
            );

            $this->sections[] = array(
                'id'    => 'general_layout',
                'title'  => esc_html__( 'General', 'adroit' ),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Site boxed mod(?)', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'adroit' ),
                        'options'  => array(
                            'full' => esc_html__('Full width Layout', 'adroit'),
                            'boxed' => esc_html__('Boxed Layout', 'adroit'),
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_placeholder',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Placeholder', 'adroit' ),
                        'subtitle'     => esc_html__( "Placeholder for none image", 'adroit' ),
                    ),
                )
            );
            /**
             *  Logos
             **/
            $this->sections[] = array(
                'id'            => 'logos_favicon',
                'title'         => esc_html__( 'Logos', 'adroit' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'logos_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Logos settings', 'adroit' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo', 'adroit' ),
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo (Retina Version @2x)', 'adroit' ),
                        'desc'     => esc_html__('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'adroit')
                    ),
                )
            );

            /**
             *	Woocommerce
             **/
            $this->sections[] = array(
                'id'			=> 'woocommerce',
                'title'			=> esc_html__( 'Woocommerce', 'wingman' ),
                'desc'			=> '',
                'icon'	=> 'icon-Full-Cart',
                'fields'		=> array(
                    array(
                        'id'       => 'shop_products_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Shop Products settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id' => 'shop_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'wingman'),
                        'desc' => esc_html__('Show page header or?.', 'wingman'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'wingman'),
                        'off' =>esc_html__('Disabled', 'wingman')
                    ),
                    array(
                        'id'       => 'shop_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar configuration', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose sidebar for shop post", 'wingman' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'wingman'),
                            'left' => esc_html__('Left Sidebar', 'wingman'),
                            'right' => esc_html__('Right Layout', 'wingman')
                        ),
                        'default'  => 'left',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar left area', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'wingman' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('shop_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar right area', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'wingman' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('shop_sidebar','equals','right'),
                        'clear' => false
                    ),

                    array(
                        'id'       => 'shop_products_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Products default Layout', 'wingman' ),
                        'options'  => array(
                            'grid' => esc_html__('Grid', 'wingman' ),
                            'lists' => esc_html__('Lists', 'wingman' )
                        ),
                        'default'  => 'grid'
                    ),
                    array(
                        'id'       => 'shop_gird_cols',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Number column to display width gird mod', 'wingman' ),
                        'options'  => array(
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                        ),
                        'default'  => 3,
                    ),
                    array(
                        'id'       => 'shop_products_effect',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop product effect', 'wingman' ),
                        'options'  => array(
                            '1' => esc_html__('Effect 1', 'wingman' ),
                            '2' => esc_html__('Effect 2', 'wingman' ),
                            '3' => esc_html__('Effect 3', 'wingman' )
                        ),
                        'default'  => '1'
                    ),
                    array(
                        'id'       => 'loop_shop_per_page',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Number of products displayed per page', 'wingman' ),
                        'default'  => '12'
                    ),

                    // For Single Products
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'shop_single_product',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Single Product settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'product_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'wingman'),
                        'desc' => esc_html__('Show page header or?.', 'wingman'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'wingman'),
                        'off' =>esc_html__('Disabled', 'wingman')
                    ),
                    array(
                        'id'       => 'product_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Product: Sidebar configuration', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose single product page ", 'wingman' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'wingman'),
                            'left' => esc_html__('Left Sidebar', 'wingman'),
                            'right' => esc_html__('Right Layout', 'wingman')
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Product: Sidebar left area', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'wingman' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('product_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Product: Sidebar right area', 'wingman' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'wingman' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('product_sidebar','equals','right'),
                        'clear' => false
                    ),

                    //Slider effect: Lightbox - Zoom
                    //Product description position - Tab, Below
                    //Product reviews position - Tab,Below
                    //Social Media Sharing Buttons
                    //Single Product Gallery Type

                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'shop_single_product',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Shop Product settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'time_product_new',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Time Product New', 'wingman' ),
                        'default'  => '30',
                        'desc' => esc_html__('Time Product New ( unit: days ).', 'wingman'),
                    ),
                )
            );

            /**
             *	Page header
             **/
            $this->sections[] = array(
                'id'			=> 'page_header_section',
                'title'			=> esc_html__( 'Page header', 'wingman' ),
                'desc'			=> '',
                'icon'          => 'icon-Add-SpaceBeforeParagraph',
                'fields'		=> array(

                    array(
                        'id'       => 'title_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Page header settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'title_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page header layout', 'wingman' ),
                        'subtitle'     => esc_html__( 'Select your preferred Page header layout.', 'wingman' ),
                        'options'  => array(
                            'sides' => esc_html__('Sides', 'wingman'),
                            'centered' => esc_html__('Centered', 'wingman' ),
                        ),
                        'default'  => 'centered',
                        'clear' => false
                    ),

                    array(
                        'id'       => 'title_align',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page header align', 'wingman' ),
                        'subtitle'     => esc_html__( 'Please select page header align', 'wingman' ),
                        'options'  => array(
                            'left' => esc_html__('Left', 'wingman' ),
                            'center' => esc_html__('Center', 'wingman'),
                            'right' => esc_html__('Right', 'wingman')
                        ),
                        'default'  => 'center',
                        'clear' => false,
                        'desc' => esc_html__('Align don\'t support for layout Sides', 'wingman')
                    ),
                    array(
                        'id'       => 'title_separator',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Separator bettwen title and subtitle', 'wingman' ),
                        'default'  => true,
                        'on'		=> esc_html__( 'Enabled', 'wingman' ),
                        'off'		=> esc_html__( 'Disabled', 'wingman' ),
                    ),

                    /*
                    array(
                        'id'       => 'title_separator_color',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Separator Color', 'wingman' ),
                        'default'  => '',
                        'transparent' => false,
                        'background-repeat'     => false,
                        'background-attachment' => false,
                        'background-position'   => false,
                        'background-image'      => false,
                        'background-size'       => false,
                        'preview'               => false,
                        'output'   => array( '.page-header .page-header-separator' ),
                    ),


                    array(
                        'id'       => 'title_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '.page-header' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Title padding', 'wingman' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'title_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Page header with image, color, etc.', 'wingman' ),
                        'output'      => array( '.page-header' )
                    ),

                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),

                    array(
                        'id'       => 'title_typography',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Typography title', 'wingman' ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'letter-spacing'  => true,
                        'text-transform' => true,
                        'output'      => array( '.page-header h1.page-header-title' ),
                        'default'  => array(
                            'font-family'     => 'Josefin Slab',
                            'text-transform' => 'uppercase',
                            'font-weight' => '700'
                        ),
                    ),
                    array(
                        'id'       => 'title_typography_subtitle',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Typography sub title', 'wingman' ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array( '.page-header .page-header-subtitle' )
                    ),
                    array(
                        'id'       => 'title_typography_breadcrumbs',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Typography breadcrumbs', 'wingman' ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'output'      => array( '.page-header .breadcrumbs', '.page-header .breadcrumbs a' )
                    ),
                    */
                )
            );

            /**
             * General page
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Page', 'adroit'),
                'desc' => esc_html__('General Page Options', 'adroit'),
                'icon' => 'fa fa-suitcase',
                'fields' => array(
                    array(
                        'id' => 'show_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'adroit'),
                        'desc' => esc_html__('Show page header or?.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'adroit' ),
                        'options'  => array(
                            '' => esc_html__('No sidebars', 'adroit'),
                            'left' => esc_html__('Left Sidebar', 'adroit'),
                            'right' => esc_html__('Right Layout', 'adroit')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'page_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose default layout", 'adroit' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','left')
                        //'clear' => false
                    ),

                    array(
                        'id'       => 'page_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'adroit' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','right')
                        //'clear' => false
                    ),

                    array(
                        'id' => 'show_page_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Show comments on page ?', 'adroit'),
                        'desc' => esc_html__('Show or hide the readmore button.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),

                )
            );
            /**
             * General Blog
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Blog', 'adroit'),
                'icon' => 'fa fa-pencil',
                'desc' => esc_html__('General Blog Options', 'adroit')
            );

            /**
             *  Archive settings
             **/
            $this->sections[] = array(
                'id'            => 'archive_section',
                'title'         => esc_html__( 'Archive', 'adroit' ),
                'desc'          => 'Archive post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'archive_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Archive post general', 'adroit' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'archive_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'adroit'),
                        'desc' => esc_html__('Show page header or?.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'adroit' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'adroit'),
                            'left' => esc_html__('Left Sidebar', 'adroit'),
                            'right' => esc_html__('Right Layout', 'adroit')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'adroit' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('archive_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'adroit' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'adroit' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('archive_sidebar','equals','right'),
                        'clear' => false
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'archive_loop_style',
                        'type' => 'select',
                        'title' => esc_html__('Loop Style', 'adroit'),
                        'desc' => '',
                        'options' => array(
                            'classic' => esc_html__( 'classic', 'adroit' ),
                            'list' => esc_html__( 'List', 'adroit' ),
                            'grid' => esc_html__( 'Grid', 'adroit' ),
                            'masonry' => esc_html__( 'Masonry', 'adroit' ),
                            'zigzag' => esc_html__( 'ZigZag', 'adroit' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'archive_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns on desktop', 'adroit'),
                        'desc' => '',
                        'options' => array(
                            '2' => esc_html__( '2 columns', 'js_composer' ) ,
                            '3' => esc_html__( '3 columns', 'js_composer' ) ,
                            '4' => esc_html__( '4 columns', 'js_composer' ) ,
                        ),
                        'default' => '2',
                        'required' => array('archive_loop_style','equals', array( 'grid', 'masonry' ) ),
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'archive_posts_per_page',
                        'type' => 'text',
                        'title' => esc_html__('Posts per page', 'adroit'),
                        'desc' => esc_html__("Insert the total number of pages.", 'adroit'),
                        'default' => 14,
                    ),
                    array(
                        'id' => 'archive_excerpt_length',
                        'type' => 'text',
                        'title' => esc_html__('Excerpt Length', 'adroit'),
                        'desc' => esc_html__("Insert the number of words you want to show in the post excerpts.", 'adroit'),
                        'default' => 35,
                    ),
                    array(
                        'id' => 'archive_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'adroit'),
                        'desc' => esc_html__('Select the pagination type.', 'adroit'),
                        'options' => array(
                            'normal' => esc_html__( 'Normal pagination', 'adroit' ),
                            'button' => esc_html__( 'Next - Previous button', 'adroit' ),
                        ),
                        'default' => 'normal'
                    ),
                )
            );


            /**
             *  Single post settings
             **/
            $this->sections[] = array(
                'id'            => 'post_single_section',
                'title'         => esc_html__( 'Single Post', 'adroit' ),
                'desc'          => 'Single post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'blog_single_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Single post general', 'adroit' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'single_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single layout', 'adroit' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'adroit' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 2', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-2.jpg' ),
                            3 => array( 'alt' => esc_html__( 'Layout 3', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-3.jpg' ),
                            4 => array( 'alt' => esc_html__( 'Layout 4', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-4.jpg' ),
                            5 => array( 'alt' => esc_html__( 'Layout 5', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-5.jpg' ),
                            6 => array( 'alt' => esc_html__( 'Layout 6', 'adroit' ), 'img' => KT_FW_IMG . 'single/layout-6.jpg' ),
                        ),
                        'default'  => 1
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'   => 'single_image_size',
                        'type' => 'select',
                        'options' => $image_sizes,
                        'title'    => esc_html__( 'Image size', 'adroit' ),
                        'desc' => esc_html__("Select image size.", 'adroit'),
                        'default' => 'full'
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'single_share_box',
                        'type' => 'switch',
                        'title' => esc_html__('Share box in posts', 'adroit'),
                        'desc' => esc_html__('Show share box in blog posts.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id' => 'single_next_prev',
                        'type' => 'switch',
                        'title' => esc_html__('Previous & next buttons', 'adroit'),
                        'desc' => esc_html__('Show Previous & next buttons in blog posts.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id' => 'single_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author info in posts', 'adroit'),
                        'desc' => esc_html__('Show author info in blog posts.', 'adroit'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id' => 'single_related',
                        'type' => 'switch',
                        'title' => esc_html__('Related posts', 'adroit'),
                        'desc' => esc_html__('Show related posts in blog posts.', 'adroit'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' =>esc_html__('Disabled', 'adroit')
                    ),
                    array(
                        'id'       => 'single_related_type',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Related Query Type', 'adroit' ),
                        'options'  => array(
                            'categories' => esc_html__('Categories', 'adroit'),
                            'tags' => esc_html__('Tags', 'adroit'),
                            'author' => esc_html__('Author', 'adroit')
                        ),
                        'required' => array('single_related','equals','1'),
                        'default'  => 'categories',
                    )
                )
            );


            /**
             *  Advanced
             **/
            $this->sections[] = array(
                'id'            => 'advanced',
                'title'         => esc_html__( 'Advanced', 'adroit' ),
                'desc'          => '',
                'icon'  => 'fa fa-cog',
            );

            /**
             *  Advanced Social Share
             **/
            $this->sections[] = array(
                'id'            => 'share_section',
                'title'         => esc_html__( 'Social Share', 'adroit' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'social_share',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox', // checkbox or text
                        'title'    => esc_html__( 'Social Share', 'adroit' ),
                        'desc'     => esc_html__( 'Reorder and Enable/Disable Social Share Buttons.', 'adroit' ),
                        'options'  => array(
                            'facebook' => esc_html__('Facebook', 'adroit'),
                            'twitter' => esc_html__('Twitter', 'adroit'),
                            'google_plus' => esc_html__('Google+', 'adroit'),
                            'pinterest' => esc_html__('Pinterest', 'adroit'),
                            'linkedin' => esc_html__('Linkedin', 'adroit'),
                            'tumblr' => esc_html__('Tumblr', 'adroit'),
                            'mail' => esc_html__('Mail', 'adroit'),
                        ),
                        'default'  => array(
                            'facebook' => true,
                            'twitter' => true,
                            'google_plus' => true,
                            'pinterest' => false,
                            'linkedin' => false,
                            'tumblr' => false,
                            'mail' => false,
                        )
                    )
                )
            );


        }
    }

    global $reduxConfig;
    $reduxConfig = new KT_config();

} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}

