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
             *  Header
             **/
            $this->sections[] = array(
                'id'            => 'Header',
                'title'         => esc_html__( 'Header', 'adroit' ),
                'desc'          => '',
                'subsection' => true,
                'fields'        => array(

                    array(
                        'id'       => 'header',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Header layout', 'adroit' ),
                        'subtitle' => esc_html__( 'Please choose header layout', 'adroit' ),
                        'options'  => array(
                            1 => array( 'alt' => esc_html__( 'Layout 1', 'adroit' ), 'img' => KT_FW_IMG . 'header/header-v1.jpg' ),
                            2 => array( 'alt' => esc_html__( 'Layout 2', 'adroit' ), 'img' => KT_FW_IMG . 'header/header-v2.jpg' ),
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
                        'title' => esc_html__('Header shadow', 'adroit'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'adroit' ),
                        'off'       => esc_html__( 'Disabled', 'adroit' ),
                    ),
                    array(
                        'id' => 'header_search',
                        'type' => 'switch',
                        'title' => esc_html__('Search Icon', 'adroit'),
                        'desc' => esc_html__('Enable the search Icon in the header.', 'adroit'),
                        "default" => 1,
                        'on'        => esc_html__( 'Enabled', 'adroit' ),
                        'off'       => esc_html__( 'Disabled', 'adroit' ),
                    ),


                    array(
                        'id'   => 'footer_socials',
                        'type' => 'kt_socials',
                        'title'    => __( 'Select your socials', 'adroit' ),
                    ),
                )
            );
            /**
             *    Footer
             **/
            $this->sections[] = array(
                'id' => 'footer',
                'title' => esc_html__('Footer', 'adroit'),
                'desc' => '',
                'subsection' => true,
                'fields' => array(
                    // Footer settings

                    array(
                        'id' => 'backtotop',
                        'type' => 'switch',
                        'title' => esc_html__('Back to top', 'adroit'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),

                    array(
                        'id' => 'footer_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer settings', 'adroit') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer',
                        'type' => 'switch',
                        'title' => esc_html__('Footer enable', 'adroit'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),

                    // Footer Top settings
                    array(
                        'id' => 'footer_top_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer top settings', 'adroit') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_top',
                        'type' => 'switch',
                        'title' => esc_html__('Footer top enable', 'adroit'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),

                    // Footer widgets settings
                    array(
                        'id' => 'footer_widgets_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer widgets settings', 'adroit') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_widgets',
                        'type' => 'switch',
                        'title' => esc_html__('Footer widgets enable', 'adroit'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),
                    array(
                        'id' => 'footer_widgets_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer widgets layout', 'adroit'),
                        'subtitle' => esc_html__('Select your footer widgets layout', 'adroit'),
                        'options' => array(
                            'featured' => array('alt' => esc_html__('Layout 1', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-0.jpg'),
                            '3-3-3-3' => array('alt' => esc_html__('Layout 2', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-1.jpg'),
                            '6-3-3' => array('alt' => esc_html__('Layout 3', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-2.jpg'),
                            '3-3-6' => array('alt' => esc_html__('Layout 4', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-3.jpg'),
                            '6-6' => array('alt' => esc_html__('Layout 5', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-4.jpg'),
                            '4-4-4' => array('alt' => esc_html__('Layout 6', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-5.jpg'),
                            '8-4' => array('alt' => esc_html__('Layout 7', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-6.jpg'),
                            '4-8' => array('alt' => esc_html__('Layout 8', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-7.jpg'),
                            '3-6-3' => array('alt' => esc_html__('Layout 9', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-8.jpg'),
                            '12' => array('alt' => esc_html__('Layout 10', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-9.jpg'),
                        ),
                        'default' => 'featured'
                    ),

                    /* Footer Bottom */
                    array(
                        'id' => 'footer_bottom_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer bottom settings', 'adroit') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_bottom',
                        'type' => 'switch',
                        'title' => esc_html__('Footer bottom enable', 'adroit'),
                        'default' => false,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),
                    array(
                        'id' => 'footer_bottom_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Footer bottom layout', 'adroit'),
                        'subtitle' => esc_html__('Select your footer bottom layout', 'adroit'),
                        'options' => array(
                            '1' => array('alt' => esc_html__('Layout 1', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-bottom-1.png'),
                            '2' => array('alt' => esc_html__('Layout 2', 'adroit'), 'img' => KT_FW_IMG . 'footer/footer-bottom-2.png'),
                        ),
                        'default' => '1'
                    ),

                    /* Footer copyright */
                    array(
                        'id' => 'footer_copyright_heading',
                        'type' => 'raw',
                        'content' => '<div class="section-heading">' . esc_html__('Footer copyright settings', 'adroit') . '</div>',
                        'full_width' => true
                    ),
                    array(
                        'id' => 'footer_copyright',
                        'type' => 'switch',
                        'title' => esc_html__('Footer copyright enable', 'adroit'),
                        'default' => true,
                        'on' => esc_html__('Enabled', 'adroit'),
                        'off' => esc_html__('Disabled', 'adroit'),
                    ),
                    array(
                        'id'       => 'footer_copyright_layout',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright layout', 'wingman' ),
                        'subtitle'     => esc_html__( 'Select your preferred footer layout.', 'wingman' ),
                        'options'  => array(
                            'centered' => esc_html__('Centered', 'wingman'),
                            'sides' => esc_html__('Sides', 'wingman' )
                        ),
                        'default'  => 'centered',
                        'clear' => false
                    ),
                    array(
                        'id'       => 'footer_copyright_left',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright left', 'wingman' ),
                        'options'  => array(
                            '' => esc_html__('Empty', 'wingman' ),
                            'navigation' => esc_html__('Navigation', 'wingman' ),
                            'socials' => esc_html__('Socials', 'wingman' ),
                            'copyright' => esc_html__('Copyright', 'wingman' ),
                        ),
                        'default'  => 'navigation'
                    ),
                    array(
                        'id'       => 'footer_copyright_right',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer copyright right', 'wingman' ),
                        'options'  => array(
                            '' => esc_html__('Empty', 'wingman' ),
                            'navigation' => esc_html__('Navigation', 'wingman' ),
                            'socials' => esc_html__('Socials', 'wingman' ),
                            'copyright' => esc_html__('Copyright', 'wingman' ),
                        ),
                        'default'  => 'copyright'
                    ),
                    array(
                        'id'   => 'footer_socials',
                        'type' => 'kt_socials',
                        'title'    => esc_html__( 'Select your socials', 'wingman' ),
                    ),
                    array(
                        'id' => 'footer_copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Footer Copyright Text', 'adroit'),
                        'default' => '&copy; 2015 Delphinus'
                    ),
                )
            );

            /**
             *	Styling
             **/
            $this->sections[] = array(
                'id'			=> 'styling',
                'title'			=> esc_html__( 'Styling', 'wingman' ),
                'desc'			=> '',
                'icon'	=> 'icon-Palette',
            );


            /**
             *	Styling Footer
             **/
            $this->sections[] = array(
                'id'			=> 'styling_footer',
                'title'			=> esc_html__( 'Footer', 'wingman' ),
                'subsection' => true,
                'fields'		=> array(
                    array(
                        'id'       => 'footer_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer padding', 'wingman' ),
                        'default'  => array( )
                    ),

                    array(
                        'id'       => 'footer_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer Border', 'wingman' ),
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
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer top settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer top Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer top Background with image, color, etc.', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer top padding', 'wingman' ),
                        'default'  => array( )
                    ),
                    array(
                        'id'       => 'footer_top_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer top Border', 'wingman' ),
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
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer widgets settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer widgets Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer widgets Background with image, color, etc.', 'wingman' ),
                        'default'   => array(  ),
                        'output'      => array( '#footer-area' ),
                    ),

                    array(
                        'id'       => 'footer_widgets_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Box widgets Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer Box widgets Background with image, color, etc.', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer widgets padding', 'wingman' ),
                        'default'  => array( )
                    ),

                    //Footer bottom settings
                    array(
                        'id'       => 'footer_bottom_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer bottom settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),
                    array(
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => esc_html__( 'Footer Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer bottom padding', 'wingman' ),
                        'default'  => array( ),
                        'subtitle' => 'Disable if you use instagram background',
                    ),

                    //Footer copyright settings
                    array(
                        'id'       => 'footer_copyright_heading',
                        'type'     => 'raw',
                        'content'  => '<div class="section-heading">'.esc_html__( 'Footer copyright settings', 'wingman' ).'</div>',
                        'full_width' => true
                    ),

                    array(
                        'id'       => 'footer_copyright_border',
                        'type'     => 'border',
                        'title'    => esc_html__( 'Footer Copyright Border', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer Background', 'wingman' ),
                        'subtitle' => esc_html__( 'Footer Background with image, color, etc.', 'wingman' ),
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
                        'title'    => esc_html__( 'Footer copyright padding', 'wingman' ),
                        'default'  => array( )
                    ),
                    array(
                        'type' => 'divide',
                        'id' => 'divide_fake',
                    ),
                    array(
                        'id'       => 'footer_socials_style',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials style', 'wingman' ),
                        'options'  => array(
                            'accent' => esc_html__('Accent', 'wingman' ),
                            'dark'   => esc_html__('Dark', 'wingman' ),
                            'light'  => esc_html__('Light', 'wingman' ),
                            'color'  => esc_html__('Color', 'wingman' ),
                            'custom'  => esc_html__('Custom Color', 'wingman' ),
                        ),
                        'default'  => 'custom'
                    ),
                    array(
                        'id'       => 'custom_color_social',
                        'type'     => 'color',
                        'title'    => esc_html__( 'Footer socials Color', 'wingman' ),
                        'default'  => '#707070',
                        'transparent' => false,
                        'required' => array('footer_socials_style','equals', array( 'custom' ) ),
                    ),
                    array(
                        'id'       => 'footer_socials_background',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials background', 'wingman' ),
                        'options'  => array(
                            'empty'       => esc_html__('None', 'wingman' ),
                            'rounded'   => esc_html__('Circle', 'wingman' ),
                            'boxed'  => esc_html__('Square', 'wingman' ),
                            'rounded-less'  => esc_html__('Rounded', 'wingman' ),
                            'diamond-square'  => esc_html__('Diamond Square', 'wingman' ),
                            'rounded-outline'  => esc_html__('Outline Circle', 'wingman' ),
                            'boxed-outline'  => esc_html__('Outline Square', 'wingman' ),
                            'rounded-less-outline'  => esc_html__('Outline Rounded', 'wingman' ),
                            'diamond-square-outline'  => esc_html__('Outline Diamond Square', 'wingman' ),
                        ),
                        'subtitle'     => esc_html__( 'Select background shape and style for social.', 'wingman' ),
                        'default'  => 'empty'
                    ),
                    array(
                        'id'       => 'footer_socials_size',
                        'type'     => 'select',
                        'title'    => esc_html__( 'Footer socials size', 'wingman' ),
                        'options'  => array(
                            'small'       => esc_html__('Small', 'wingman' ),
                            'standard'   => esc_html__('Standard', 'wingman' ),
                        ),
                        'default'  => 'small'
                    ),
                    array(
                        'id'       => 'footer_socials_space_between_item',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Footer socials space between item', 'wingman' ),
                        'default'  => '10'
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

