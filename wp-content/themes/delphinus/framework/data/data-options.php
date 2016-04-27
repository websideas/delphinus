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
                'menu_title' => esc_html__('Theme Options', 'delphinus'),

                'page_title' => $this->theme->get('Name') . ' ' . esc_html__('Theme Options', 'delphinus'),
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
                'title' => esc_html__('Like us on Facebook', 'delphinus'),
                'icon' => 'el-icon-facebook'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/Kite-Themes/follow?ref=Kite-Themes',
                'title' => esc_html__('Follow us on Themeforest', 'delphinus'),
                'icon' => 'fa fa-wordpress'
            );

            $this->args['share_icons'][] = array(
                'url' => '#',
                'title' => esc_html__('Get Email Newsletter', 'delphinus'),
                'icon' => 'fa fa-envelope-o'
            );

            $this->args['share_icons'][] = array(
                'url' => 'http://themeforest.net/user/kite-themes/portfolio',
                'title' => esc_html__('Check out our works', 'delphinus'),
                'icon' => 'fa fa-briefcase'
            );
        }

        public function setSections()
        {

            $image_sizes = kt_get_image_sizes();

            $this->sections[] = array(
                'id'    => 'general',
                'title'  => esc_html__( 'General', 'delphinus' ),
                'icon'  => 'fa fa-cogs'
            );

            $this->sections[] = array(
                'id'    => 'general_layout',
                'title'  => esc_html__( 'General', 'delphinus' ),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Site boxed mod(?)', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'delphinus' ),
                        'options'  => array(
                            'full' => esc_html__('Full width Layout', 'delphinus'),
                            'boxed' => esc_html__('Boxed Layout', 'delphinus'),
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),

                    array(
                        'id' => 'use_page_loader',
                        'type' => 'switch',
                        'title' => esc_html__('Use Page Loader?', 'delphinus'),
                        'desc' => esc_html__('', 'delphinus'),
                        'default' => 0,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),

                    array(
                        'id'       => 'archive_placeholder',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Placeholder', 'delphinus' ),
                        'subtitle'     => esc_html__( "Placeholder for none image", 'delphinus' ),
                    ),

                    array(
                        'id' => 'notfound_page_type',
                        'type' => 'select',
                        'title' => esc_html__('404 Page', 'wingman'),
                        'desc' => '',
                        'options' => array(
                            'default' => esc_html__( 'Default', 'wingman' ) ,
                            'home' => esc_html__( 'Redirect Home', 'wingman' ) ,
                        ),
                        'default' => 'default',
                    ),

                )
            );
            /**
             *  Logos
             **/
            $this->sections[] = array(
                'id'            => 'logos_favicon',
                'title'         => esc_html__( 'Logos', 'delphinus' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'logos_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Logos settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'logo',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo', 'delphinus' ),
                    ),
                    array(
                        'id'       => 'logo_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo (Retina Version @2x)', 'delphinus' ),
                        'desc'     => esc_html__('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'delphinus')
                    ),



                    array(
                        'id'       => 'logo_light',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo light', 'delphinus' ),
                    ),
                    array(
                        'id'       => 'logo_light_retina',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Logo light(Retina Version @2x)', 'delphinus' ),
                        'desc'     => esc_html__('Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'delphinus')
                    ),

                )
            );

            /**
             *  Header
             **/
            $this->sections[] = array(
                'id'            => 'Header',
                'title'         => esc_html__( 'Header', 'delphinus' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(

                    array(
                        'id'       => 'header',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Header layout', 'delphinus' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'delphinus' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v2.jpg' ),
                            3 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v3.jpg' ),
                            4 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v4.jpg' ),
                            //5 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v5.jpg' ),
                            6 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v6.jpg' ),
                            7 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v7.jpg' ),
                            8 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'header/header-v8.jpg' ),
                        ),
                        'default'  => 1
                    ),
                    array(
                        'id'   => 'divide_id',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'header_shadow',
                        'type' => 'switch',
                        'title' => esc_html__('Header shadow', 'delphinus'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'delphinus' ),
                        'off'       => esc_html__( 'Disabled', 'delphinus' ),
                    ),
                    array(
                        'id' => 'header_search',
                        'type' => 'switch',
                        'title' => esc_html__('Search Icon', 'delphinus'),
                        'desc' => esc_html__('Enable the search Icon in the header.', 'delphinus'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'delphinus' ),
                        'off'       => esc_html__( 'Disabled', 'delphinus' ),
                    ),


                    array(
                        'id'   => 'header_socials',
                        'type' => 'kt_socials',
                        'title'    => __( 'Select your socials', 'delphinus' ),
                        'default' => 'facebook,twitter,instagram,linkedin'
                    ),
                )
            );
            /**
             *    Footer
             **/
            $this->sections[] = array(
                'id' => 'footer',
                'title' => esc_html__('Footer', 'delphinus'),
                'desc' => '',
                'subsection' => true,
                'fields' => array(
                    // Footer settings

                    array(
                        'id' => 'backtotop',
                        'type' => 'switch',
                        'title' => esc_html__('Back to top', 'delphinus'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),

                    array(
                        'id' => 'footer_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer settings', 'delphinus') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer',
                        'type' => 'switch',
                        'title' => esc_html__('Footer enable', 'delphinus'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),

                    // Footer Top settings
                    array(
                        'id' => 'footer_top_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer top settings', 'delphinus') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_top',
                        'type' => 'switch',
                        'title' => esc_html__('Footer top enable', 'delphinus'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),

                    // Footer widgets settings
                    array(
                        'id' => 'footer_widgets_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer widgets settings', 'delphinus') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_widgets',
                        'type' => 'switch',
                        'title' => esc_html__('Footer widgets enable', 'delphinus'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),
                    array(
                        'id' => 'footer_widgets_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer widgets layout', 'delphinus'),
                        'subtitle' => esc_html__('Select your footer widgets layout', 'delphinus'),
                        'options' => array(
                            'featured' => array('alt' => esc_html__('Layout 1', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-0.jpg'),
                            '3-3-3-3' => array('alt' => esc_html__('Layout 2', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-1.jpg'),
                            '6-3-3' => array('alt' => esc_html__('Layout 3', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-2.jpg'),
                            '3-3-6' => array('alt' => esc_html__('Layout 4', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-3.jpg'),
                            '6-6' => array('alt' => esc_html__('Layout 5', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-4.jpg'),
                            '4-4-4' => array('alt' => esc_html__('Layout 6', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-5.jpg'),
                            '8-4' => array('alt' => esc_html__('Layout 7', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-6.jpg'),
                            '4-8' => array('alt' => esc_html__('Layout 8', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-7.jpg'),
                            '3-6-3' => array('alt' => esc_html__('Layout 9', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-8.jpg'),
                            '12' => array('alt' => esc_html__('Layout 10', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-9.jpg'),
                        ),
                        'default' => 'featured'
                    ),

                    /* Footer Bottom */
                    array(
                        'id' => 'footer_bottom_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer bottom settings', 'delphinus') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_bottom',
                        'type' => 'switch',
                        'title' => esc_html__('Footer bottom enable', 'delphinus'),
                        'default' => false,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),
                    array(
                        'id' => 'footer_bottom_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer bottom layout', 'delphinus'),
                        'subtitle' => esc_html__('Select your footer bottom layout', 'delphinus'),
                        'options' => array(
                            '1' => array('alt' => esc_html__('Layout 1', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-bottom-1.png'),
                            '2' => array('alt' => esc_html__('Layout 2', 'delphinus'), 'img' => KT_FW_IMG . 'footer/footer-bottom-2.png'),
                        ),
                        'default' => '1'
                    ),

                    /* Footer copyright */
                    array(
                        'id' => 'footer_copyright_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer copyright settings', 'delphinus') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_copyright',
                        'type' => 'switch',
                        'title' => esc_html__('Footer copyright enable', 'delphinus'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                    ),
                    array(
                        'id'       => 'footer_copyright_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright layout', 'delphinus' ),
                        'subtitle'     => esc_html__( 'Select your preferred footer layout.', 'delphinus' ),
                        'options'  => array(
                            'centered' => esc_html__('Centered', 'delphinus'),
                            'sides' => esc_html__('Sides', 'delphinus' )
                        ),
                        'default'  => 'centered',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'footer_copyright_left',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright left', 'delphinus' ),
                        'options'  => array(
                            '' => esc_html__('Empty', 'delphinus' ),
                            'navigation' => esc_html__('Navigation', 'delphinus' ),
                            'socials' => esc_html__('Socials', 'delphinus' ),
                            'copyright' => esc_html__('Copyright', 'delphinus' ),
                        ),
                        'default'  => 'navigation'
                    ),
                    array(
                        'id'       => 'footer_copyright_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright right', 'delphinus' ),
                        'options'  => array(
                            '' => esc_html__('Empty', 'delphinus' ),
                            'navigation' => esc_html__('Navigation', 'delphinus' ),
                            'socials' => esc_html__('Socials', 'delphinus' ),
                            'copyright' => esc_html__('Copyright', 'delphinus' ),
                        ),
                        'default'  => 'copyright'
                    ),
                    array(
                        'id'   => 'footer_socials',
                        'type' => 'kt_socials',
                        'title'    => esc_html__( 'Select your socials', 'delphinus' ),
                    ),
                    array(
                        'id' => 'footer_copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Copyright Text', 'delphinus'),
                        'default' => '&copy; 2015 Delphinus'
                    ),
                )
            );


            /**
             *	Styling
             **/
            $this->sections[] = array(
                'id'			=> 'styling',
                'title'			=> esc_html__( 'Styling', 'delphinus' ),
                'desc'			=> '',
                'icon'	=> 'fa fa-pencil',
            );


            /**
             *	Styling Footer
             **/
            $this->sections[] = array(
                'id'			=> 'styling_footer',
                'title'			=> esc_html__( 'Footer', 'delphinus' ),
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'delphinus' ),
                        'default'   => array( ),
                        'output'      => array( '#footer' ),
                    ),

                    array(
                        'id'       => 'footer_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer padding', 'delphinus' ),
                        'default'  => array( )
                    ),

                    array(
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer Border', 'delphinus' ),
                        'output'   => array( '#footer' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'bottom'      => false,
                        'default'  => array( )
                    ),

                    // Footer top settings
                    array(
                        'id'       => 'footer_top_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer top settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer top Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer top Background with image, color, etc.', 'delphinus' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-top' ),
                    ),
                    array(
                        'id'       => 'footer_top_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-top' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer top padding', 'delphinus' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_top_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer top Border', 'delphinus' ),
                        'output'   => array( '#footer-top' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'top'      => false,
                        'default'  => array(

                        )
                    ),
                    // Footer widgets settings
                    array(
                        'id'       => 'footer_widgets_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer widgets settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer widgets Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer widgets Background with image, color, etc.', 'delphinus' ),
                        'default'   => array(  ),
                        'output'      => array( '#footer-area' ),
                    ),

                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Box widgets Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer Box widgets Background with image, color, etc.', 'delphinus' ),
                        'default'   => array( ),
                        'output'      => array( '.footer-area-right' ),
                    ),


                    array(
                        'id'       => 'footer_widgets_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-area' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer widgets padding', 'delphinus' ),
                        'default'  => array( )
                    ),

                    //Footer bottom settings
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer bottom settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'delphinus' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-bottom' ),
                    ),

                    array(
                        'id'       => 'footer_bottom_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer bottom padding', 'delphinus' ),
                        'default'  => array( ),
                        'subtitle' => 'Disable if you use instagram background',
                    ),

                    //Footer copyright settings
                    array(
                        'id'       => 'footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer copyright settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'footer_copyright_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer Copyright Border', 'delphinus' ),
                        'output'   => array( '#footer-copyright' ),
                        'all'      => false,
                        'left'     => false,
                        'right'    => false,
                        'bottom'      => false,
                        'default'  => array( )
                    ),

                    array(
                        'id'       => 'footer_copyright_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'delphinus' ),
                        'default'   => array( ),
                        'output'      => array( '#footer-copyright' ),
                    ),
                    array(
                        'id'       => 'footer_copyright_padding',
                        'type'     => 'spacing',
                        'mode'     => 'padding',
                        'left'     => false,
                        'right'    => false,
                        'output'   => array( '#footer-copyright' ),
                        'units'          => array( 'px' ),
                        'units_extended' => 'true',
                        'title'    => esc_html__( 'Footer copyright padding', 'delphinus' ),
                        'default'  => array( )
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'footer_socials_style',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials style', 'delphinus' ),
                        'options'  => array(
                            'accent' => esc_html__('Accent', 'delphinus' ),
                            'dark'   => esc_html__('Dark', 'delphinus' ),
                            'light'  => esc_html__('Light', 'delphinus' ),
                            'color'  => esc_html__('Color', 'delphinus' ),
                            'custom'  => esc_html__('Custom Color', 'delphinus' ),
                        ),
                        'default'  => 'custom'
                    ),
                    array(
                        'id'       => 'custom_color_social',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Footer socials Color', 'delphinus' ),
                        'default'  => '#707070',
                        'transparent' => false,
                        'required' => array('footer_socials_style','equals', array( 'custom' ) ),
                    ),
                    array(
                        'id'       => 'footer_socials_background',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials background', 'delphinus' ),
                        'options'  => array(
                            'empty'       => esc_html__('None', 'delphinus' ),
                            'rounded'   => esc_html__('Circle', 'delphinus' ),
                            'boxed'  => esc_html__('Square', 'delphinus' ),
                            'rounded-less'  => esc_html__('Rounded', 'delphinus' ),
                            'diamond-square'  => esc_html__('Diamond Square', 'delphinus' ),
                            'rounded-outline'  => esc_html__('Outline Circle', 'delphinus' ),
                            'boxed-outline'  => esc_html__('Outline Square', 'delphinus' ),
                            'rounded-less-outline'  => esc_html__('Outline Rounded', 'delphinus' ),
                            'diamond-square-outline'  => esc_html__('Outline Diamond Square', 'delphinus' ),
                        ),
                        'subtitle'     => esc_html__( 'Select background shape and style for social.', 'delphinus' ),
                        'default'  => 'empty'
                    ),
                    array(
                        'id'       => 'footer_socials_size',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials size', 'delphinus' ),
                        'options'  => array(
                            'small'       => esc_html__('Small', 'delphinus' ),
                            'standard'   => esc_html__('Standard', 'delphinus' ),
                        ),
                        'default'  => 'small'
                    ),
                    array(
                        'id'       => 'footer_socials_space_between_item',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Footer socials space between item', 'delphinus' ),
                        'default'  => '10'
                    ),
                )
            );

            /**
             *	Woocommerce
             **/
            $this->sections[] = array(
                'id'			=> 'woocommerce',
                'title'			=> esc_html__( 'Woocommerce', 'delphinus' ),
                'desc'			=> '',
                'icon'	=> 'fa fa-cart-arrow-down',
                'fields'		=> array(
                    array(
                        'id'       => 'shop_products_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Shop Products settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id' => 'shop_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'delphinus'),
                        'desc' => esc_html__('Show page header or?.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id'       => 'shop_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar configuration', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose sidebar for shop post", 'delphinus' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'delphinus'),
                            'left' => esc_html__('Left Sidebar', 'delphinus'),
                            'right' => esc_html__('Right Layout', 'delphinus')
                        ),
                        'default'  => 'left',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar left area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('shop_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'shop_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Sidebar right area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('shop_sidebar','equals','right'),
                        'clear' => false
                    ),

                    array(
                        'id'       => 'shop_products_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop: Products default Layout', 'delphinus' ),
                        'options'  => array(
                            'grid' => esc_html__('Grid', 'delphinus' ),
                            'lists' => esc_html__('Lists', 'delphinus' )
                        ),
                        'default'  => 'grid'
                    ),
                    array(
                        'id'       => 'shop_gird_cols',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Number column to display width gird mod', 'delphinus' ),
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
                        'title'    => esc_html__( 'Shop product effect', 'delphinus' ),
                        'options'  => array(
                            '1' => esc_html__('Effect 1', 'delphinus' ),
                            '2' => esc_html__('Effect 2', 'delphinus' ),
                            '3' => esc_html__('Effect 3', 'delphinus' )
                        ),
                        'default'  => '1'
                    ),
                    array(
                        'id'       => 'loop_shop_per_page',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Number of products displayed per page', 'delphinus' ),
                        'default'  => '12'
                    ),


                    // For Shop header
                    array(
                        'id'       => 'shop_header_products',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Shop Header Settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'shop_header_tool_bar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Shop Header', 'delphinus' ),
                        'desc'     => esc_html__('Select type shop header.', 'delphinus'),
                        'options'  => array(
                            '0' => esc_html__('Disable', 'delphinus' ),
                            '1' => esc_html__('Default', 'delphinus' ),
                            '2' => esc_html__('Categories', 'delphinus' )
                        ),
                        'default'  => '1'
                    ),
                    array(
                        'id'       => 'shop_header_orderby',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Categories - Order by', 'delphinus' ),
                        'desc'     => esc_html__('The column to use for ordering categories', 'delphinus'),
                        'options'  => array(
                            'id' => esc_html__('ID', 'delphinus' ),
                            'name' => esc_html__('Name/Menu-order', 'delphinus' ),
                            'slug' => esc_html__('Slug', 'delphinus' ),
                            'count' => esc_html__('Count', 'delphinus' ),
                            'term_group' => esc_html__('Term Group', 'delphinus' ),
                        ),
                        'default'  => 'slug',
                        'required' => array('shop_header_tool_bar','equals','2'),
                    ),

                    array(
                        'id'       => 'shop_header_order',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Categories - Order', 'delphinus' ),
                        'desc'     => esc_html__('Which direction to order categories', 'delphinus'),
                        'options'  => array(
                            'ASC' => esc_html__('ASC', 'delphinus' ),
                            'DESC' => esc_html__('DESC', 'delphinus' ),
                        ),
                        'default'  => 'ASC',
                        'required' => array('shop_header_tool_bar','equals','2'),
                    ),

                    array(
                        'id' => 'shop_header_filters',
                        'type' => 'switch',
                        'title' => esc_html__('Show Filters', 'delphinus'),
                        'desc' => esc_html__('Display filters in the shop header.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus'),
                        'required' => array('shop_header_tool_bar','equals','2'),
                    ),
                    array(
                        'id' => 'shop_header_search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'delphinus'),
                        'desc' => esc_html__('Display search box in the shop header.', 'delphinus'),
                        "default" => 1,
                        'on' =>  esc_html__('Enabled', 'delphinus'),
                        'off' => esc_html__('Disabled', 'delphinus'),
                        'required' => array('shop_header_tool_bar','equals','2'),
                    ),

                    // For Single Products
                    array(
                        'id'       => 'shop_single_product',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Single Product settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'product_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'delphinus'),
                        'desc' => esc_html__('Show page header or?.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id'       => 'product_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Product: Sidebar configuration', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose single product page ", 'delphinus' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'delphinus'),
                            'left' => esc_html__('Left Sidebar', 'delphinus'),
                            'right' => esc_html__('Right Layout', 'delphinus')
                        ),
                        'default'  => 'full',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Product: Sidebar left area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('product_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'product_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Product: Sidebar right area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
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
                        'content'  => '<div class="section-heading">'.esc_html__( 'Shop settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'time_product_new',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Time Product New', 'delphinus' ),
                        'default'  => '30',
                        'desc' => esc_html__('Time Product New ( unit: days ).', 'delphinus'),
                    ),
                )
            );

            /**
             *	Page header
             **/
            $this->sections[] = array(
                'id'			=> 'page_header_section',
                'title'			=> esc_html__( 'Page header', 'delphinus' ),
                'desc'			=> '',
                'icon'          => 'fa fa-header',
                'fields'		=> array(

                    array(
                        'id'       => 'title_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Page header settings', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'title_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page header layout', 'delphinus' ),
                        'subtitle'     => esc_html__( 'Select your preferred Page header layout.', 'delphinus' ),
                        'options'  => array(
                            'sides' => esc_html__('Sides', 'delphinus'),
                            'centered' => esc_html__('Centered', 'delphinus' ),
                        ),
                        'default'  => 'centered'
                    ),
                    /*

                    array(
                        'id'       => 'title_align',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Page header align', 'delphinus' ),
                        'subtitle'     => esc_html__( 'Please select page header align', 'delphinus' ),
                        'options'  => array(
                            'left' => esc_html__('Left', 'delphinus' ),
                            'center' => esc_html__('Center', 'delphinus'),
                            'right' => esc_html__('Right', 'delphinus')
                        ),
                        'default'  => 'center',
                        'clear' => false,
                        'desc' => esc_html__('Align don\'t support for layout Sides', 'delphinus')
                    ),
                    array(
                        'id'       => 'title_separator',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'Separator bettwen title and subtitle', 'delphinus' ),
                        'default'  => true,
                        'on'		=> esc_html__( 'Enabled', 'delphinus' ),
                        'off'		=> esc_html__( 'Disabled', 'delphinus' ),
                    ),


                    array(
                        'id'       => 'title_separator_color',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Separator Color', 'delphinus' ),
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
                        'title'    => esc_html__( 'Title padding', 'delphinus' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'title_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Background', 'delphinus' ),
                        'subtitle' => esc_html__( 'Page header with image, color, etc.', 'delphinus' ),
                        'output'      => array( '.page-header' )
                    ),

                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),

                    array(
                        'id'       => 'title_typography',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Typography title', 'delphinus' ),
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
                        'title'    => esc_html__( 'Typography sub title', 'delphinus' ),
                        'google'   => true,
                        'text-align'      => false,
                        'line-height'     => false,
                        'text-transform' => true,
                        'output'      => array( '.page-header .page-header-subtitle' )
                    ),
                    array(
                        'id'       => 'title_typography_breadcrumbs',
                        'type'     => 'typography',
                        'title'    => esc_html__( 'Typography breadcrumbs', 'delphinus' ),
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
                'title' => esc_html__('Page', 'delphinus'),
                'desc' => esc_html__('General Page Options', 'delphinus'),
                'icon' => 'fa fa-suitcase',
                'fields' => array(
                    array(
                        'id' => 'show_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'delphinus'),
                        'desc' => esc_html__('Show page header or?.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id'       => 'page_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'delphinus' ),
                        'options'  => array(
                            '' => esc_html__('No sidebars', 'delphinus'),
                            'left' => esc_html__('Left Sidebar', 'delphinus'),
                            'right' => esc_html__('Right Layout', 'delphinus')
                        ),
                        'default'  => '',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'page_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose default layout", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','left')
                        //'clear' => false
                    ),

                    array(
                        'id'       => 'page_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose page layout", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('page_sidebar','equals','right')
                        //'clear' => false
                    ),

                    array(
                        'id' => 'show_page_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Show comments on page ?', 'delphinus'),
                        'desc' => esc_html__('Show or hide the readmore button.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),

                )
            );
            /**
             * General Blog
             *
             */
            $this->sections[] = array(
                'title' => esc_html__('Blog', 'delphinus'),
                'icon' => 'fa fa-pencil',
                'desc' => esc_html__('General Blog Options', 'delphinus')
            );

            /**
             *  Archive settings
             **/
            $this->sections[] = array(
                'id'            => 'archive_section',
                'title'         => esc_html__( 'Archive', 'delphinus' ),
                'desc'          => 'Archive post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'archive_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Archive post general', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'archive_page_header',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page header', 'delphinus'),
                        'desc' => esc_html__('Show page header or?.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id'       => 'archive_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar configuration', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose archive page ", 'delphinus' ),
                        'options'  => array(
                            'full' => esc_html__('No sidebars', 'delphinus'),
                            'left' => esc_html__('Left Sidebar', 'delphinus'),
                            'right' => esc_html__('Right Layout', 'delphinus')
                        ),
                        'default'  => 'right',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_left',
                        'type' => 'select',
                        'title'    => esc_html__( 'Sidebar left area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
                        'data'     => 'sidebars',
                        'default'  => 'primary-widget-area',
                        'required' => array('archive_sidebar','equals','left'),
                        'clear' => false
                    ),
                    array(
                        'id'       => 'archive_sidebar_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Sidebar right area', 'delphinus' ),
                        'subtitle'     => esc_html__( "Please choose left sidebar ", 'delphinus' ),
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
                        'title' => esc_html__('Loop Style', 'delphinus'),
                        'desc' => '',
                        'options' => array(
                            'classic' => esc_html__( 'Classic', 'delphinus' ),
                            'list' => esc_html__( 'List', 'delphinus' ),
                            'grid' => esc_html__( 'Grid', 'delphinus' ),
                            'masonry' => esc_html__( 'Masonry', 'delphinus' ),
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'archive_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns on desktop', 'delphinus'),
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
                        'title' => esc_html__('Posts per page', 'delphinus'),
                        'desc' => esc_html__("Insert the total number of pages.", 'delphinus'),
                        'default' => 14,
                    ),
                    array(
                        'id' => 'archive_excerpt_length',
                        'type' => 'text',
                        'title' => esc_html__('Excerpt Length', 'delphinus'),
                        'desc' => esc_html__("Insert the number of words you want to show in the post excerpts.", 'delphinus'),
                        'default' => 35,
                    ),

                    array(
                        'id' => 'archive_readmore',
                        'type' => 'select',
                        'title' => esc_html__('Readmore button', 'delphinus'),
                        'desc' => '',
                        'options' => array(
                            'none' => esc_html__( 'None', 'js_composer' ) ,
                            'link' => esc_html__( 'Link', 'js_composer' ) ,
                        ),
                        'default' => 'none',
                    ),

                    array(
                        'id' => 'archive_pagination',
                        'type' => 'select',
                        'title' => esc_html__('Pagination Type', 'delphinus'),
                        'desc' => esc_html__('Select the pagination type.', 'delphinus'),
                        'options' => array(
                            'normal' => esc_html__( 'Normal pagination', 'delphinus' ),
                            'button' => esc_html__( 'Next - Previous button', 'delphinus' ),
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
                'title'         => esc_html__( 'Single Post', 'delphinus' ),
                'desc'          => 'Single post settings',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'blog_single_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Single post general', 'delphinus' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'single_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Single layout', 'delphinus' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'delphinus' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 2', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-2.jpg' ),
                            3 => array( 'alt' => esc_html__( 'Layout 3', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-3.jpg' ),
                            4 => array( 'alt' => esc_html__( 'Layout 4', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-4.jpg' ),
                            5 => array( 'alt' => esc_html__( 'Layout 5', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-5.jpg' ),
                            6 => array( 'alt' => esc_html__( 'Layout 6', 'delphinus' ), 'img' => KT_FW_IMG . 'single/layout-6.jpg' ),
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
                        'title'    => esc_html__( 'Image size', 'delphinus' ),
                        'desc' => esc_html__("Select image size.", 'delphinus'),
                        'default' => 'full'
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id' => 'single_share_box',
                        'type' => 'switch',
                        'title' => esc_html__('Share box in posts', 'delphinus'),
                        'desc' => esc_html__('Show share box in blog posts.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id' => 'single_next_prev',
                        'type' => 'switch',
                        'title' => esc_html__('Previous & next buttons', 'delphinus'),
                        'desc' => esc_html__('Show Previous & next buttons in blog posts.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id' => 'single_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author info in posts', 'delphinus'),
                        'desc' => esc_html__('Show author info in blog posts.', 'delphinus'),
                        "default" => 1,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id' => 'single_related',
                        'type' => 'switch',
                        'title' => esc_html__('Related posts', 'delphinus'),
                        'desc' => esc_html__('Show related posts in blog posts.', 'delphinus'),
                        "default" => 0,
                        'on' => esc_html__('Enabled', 'delphinus'),
                        'off' =>esc_html__('Disabled', 'delphinus')
                    ),
                    array(
                        'id'       => 'single_related_type',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Related Query Type', 'delphinus' ),
                        'options'  => array(
                            'categories' => esc_html__('Categories', 'delphinus'),
                            'tags' => esc_html__('Tags', 'delphinus'),
                            'author' => esc_html__('Author', 'delphinus')
                        ),
                        'required' => array('single_related','equals','1'),
                        'default'  => 'categories',
                    )
                )
            );



            /**
             *	Socials Link
             **/

            $this->sections[] = array(
                'id'			=> 'social',
                'title'			=> esc_html__( 'Socials', 'delphinus' ),
                'desc'			=> esc_html__('Social and share settings', 'delphinus'),
                'icon'	        => 'fa fa-facebook',
                'fields'		=> array(

                    array(
                        'id' => 'twitter',
                        'type' => 'text',
                        'title' => esc_html__('Twitter', 'delphinus'),
                        'subtitle' => esc_html__("Your Twitter username (no @).", 'delphinus'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'facebook',
                        'type' => 'text',
                        'title' => esc_html__('Facebook', 'delphinus'),
                        'subtitle' => esc_html__("Your Facebook page/profile url", 'delphinus'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest', 'delphinus'),
                        'subtitle' => esc_html__("Your Pinterest username", 'delphinus'),
                        'default' => '#'
                    ),
                    array(
                        'id' => 'dribbble',
                        'type' => 'text',
                        'title' => esc_html__('Dribbble', 'delphinus'),
                        'subtitle' => esc_html__("Your Dribbble username", 'delphinus'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'vimeo',
                        'type' => 'text',
                        'title' => esc_html__('Vimeo', 'delphinus'),
                        'subtitle' => esc_html__("Your Vimeo username", 'delphinus'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'tumblr',
                        'type' => 'text',
                        'title' => esc_html__('Tumblr', 'delphinus'),
                        'subtitle' => esc_html__("Your Tumblr username", 'delphinus'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'skype',
                        'type' => 'text',
                        'title' => esc_html__('Skype', 'delphinus'),
                        'subtitle' => esc_html__("Your Skype username", 'delphinus'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'linkedin',
                        'type' => 'text',
                        'title' => esc_html__('LinkedIn', 'delphinus'),
                        'subtitle' => esc_html__("Your LinkedIn page/profile url", 'delphinus'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'googleplus',
                        'type' => 'text',
                        'title' => esc_html__('Google+', 'delphinus'),
                        'subtitle' => esc_html__("Your Google+ page/profile URL", 'delphinus'),
                        'desc' => '',
                        'default' => '#'
                    ),
                    array(
                        'id' => 'youtube',
                        'type' => 'text',
                        'title' => esc_html__('YouTube', 'delphinus'),
                        'subtitle' => esc_html__("Your YouTube username", 'delphinus'),
                        'desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id' => 'instagram',
                        'type' => 'text',
                        'title' => esc_html__('Instagram', 'delphinus'),
                        'subtitle' => esc_html__("Your Instagram username", 'delphinus'),
                        'desc' => '',
                        'default' => ''
                    )
                )
            );

            /**
             *	Popup
             **/
            $this->sections[] = array(
                'id'			=> 'popup',
                'title'			=> esc_html__( 'Popup', 'delphinus' ),
                'icon'	=> 'fa fa-bullhorn',
                'fields'		=> array(
                    array(
                        'id'		=> 'enable_popup',
                        'type'		=> 'switch',
                        'title'		=> esc_html__( 'Enable Popup', 'delphinus' ),
                        'subtitle'	=> esc_html__( '', 'delphinus'),
                        "default"	=> false,
                        'on'		=> esc_html__( 'On', 'delphinus' ),
                        'off'		=> esc_html__( 'Off', 'delphinus' ),
                    ),
                    array(
                        'id'		=> 'disable_popup_mobile',
                        'type'		=> 'switch',
                        'title'		=> esc_html__( 'Disable Popup on Mobile', 'delphinus' ),
                        'subtitle'	=> esc_html__( '', 'delphinus'),
                        "default"	=> false,
                        'on'		=> esc_html__( 'On', 'delphinus' ),
                        'off'		=> esc_html__( 'Off', 'delphinus' ),
                        'required' => array('enable_popup','equals', 1)
                    ),

                    array(
                        'id'            => 'time_show',
                        'type'          => 'slider',
                        'title'         => __( 'Time to show', 'delphinus' ),
                        'desc'          => __( 'Delay time for show. (seconds)', 'delphinus' ),
                        'default'       => 0,
                        'min'           => 0,
                        'step'          => 1,
                        'max'           => 20,
                        'display_value' => 'text',
                        'required'      => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id'       => 'popup_image',
                        'type'     => 'media',
                        'url'      => true,
                        'compiler' => true,
                        'title'    => esc_html__( 'Popup Image', 'delphinus' ),
                        'default'  => array(
                            'url' => KT_THEME_IMG.'popup_image.jpg'
                        ),
                        'required'      => array('enable_popup','equals', 1)
                    ),
                    array(
                        'id'       => 'content_popup',
                        'type'     => 'editor',
                        'title'    => esc_html__( 'Popup Content', 'delphinus' ),
                        'subtitle' => esc_html__( '', 'delphinus' ),
                        'required' => array('enable_popup','equals', 1),
                        'default'  => '<h3>NEWSLETTER</h3><p>Subscribe to the Universal mailing list to receive updates on new arrivals, offers and other discount information.</p>',
                    ),
                    array(
                        'id'       => 'popup_form',
                        'type'     => 'textarea',
                        'title'    => __( 'Popup form', 'delphinus' ),
                        'desc'     => __( 'You can use shortcode or Embed code in here.', 'delphinus' ),
                        'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                    ),


                )
            );


            /**
             *  Advanced
             **/
            $this->sections[] = array(
                'id'            => 'advanced',
                'title'         => esc_html__( 'Advanced', 'delphinus' ),
                'desc'          => '',
                'icon'  => 'fa fa-cog',
            );

            /**
             *  Advanced Social Share
             **/
            $this->sections[] = array(
                'id'            => 'share_section',
                'title'         => esc_html__( 'Social Share', 'delphinus' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(
                    array(
                        'id'       => 'social_share',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox', // checkbox or text
                        'title'    => esc_html__( 'Social Share', 'delphinus' ),
                        'desc'     => esc_html__( 'Reorder and Enable/Disable Social Share Buttons.', 'delphinus' ),
                        'options'  => array(
                            'facebook' => esc_html__('Facebook', 'delphinus'),
                            'twitter' => esc_html__('Twitter', 'delphinus'),
                            'google_plus' => esc_html__('Google+', 'delphinus'),
                            'pinterest' => esc_html__('Pinterest', 'delphinus'),
                            'linkedin' => esc_html__('Linkedin', 'delphinus'),
                            'tumblr' => esc_html__('Tumblr', 'delphinus'),
                            'mail' => esc_html__('Mail', 'delphinus'),
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

