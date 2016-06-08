<?php
/*
Plugin Name: Delphinus Import Demo Content
Description: Replicate any of the Delphinus example sites in just a few clicks!
Author: KiteThemes
Author URI: http://kitethemes.com
Version: 1.0
Text Domain: kt_importer
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

define( 'DEL_PLUGIN', __FILE__ );
define( 'DEL_PLUGIN_BASENAME', plugin_basename( DEL_PLUGIN ) );
define( 'DEL_PLUGIN_DIR', untrailingslashit( dirname( DEL_PLUGIN ) ) );
define( 'DEL_PLUGIN_URL', plugins_url('', __FILE__) );



class KT_IMPORTER_DEMOS
{

    public $kt_importer_dir         =  '';
    public $kt_importer_url         =  '';
    public $kt_importer_opt_name    =  '';
    public $theme_options_file      =  '';
    public $widgets_file_name       =  '';
    public $content_file_name       =  '';
    public $demoid                  =  '';

    /**
     * Start up
     */
    public function __construct()
    {

        if( !is_admin() )
            return;

        add_action( 'admin_init', array( $this, 'kt_importer_init' ));
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'kt_importer_scripts' ));
        add_action( 'wp_ajax_kt_importer_content', array( $this,'kt_importer_content_callback') );
        add_action( 'wp_ajax_kt_importer_options', array( $this,'kt_importer_options_callback') );
        add_action( 'wp_ajax_kt_importer_widgets', array( $this,'kt_importer_widgets_callback') );


    }

    function kt_importer_init(){
        load_plugin_textdomain( 'delphinus_importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

        $this->kt_importer_dir = apply_filters('kt_importer_dir', DEL_PLUGIN_DIR.'/dummy-data/');
        $this->kt_importer_url = apply_filters('kt_importer_url', DEL_PLUGIN_URL.'/dummy-data/');
        $this->kt_importer_opt_name = apply_filters('kt_importer_opt_name', 'delphinus_option');

    }



    function kt_importer_content_callback(){

        $this->demoid = sanitize_title($_POST['demo']);
        $count = ( isset($_POST['count']) ) ? intval($_POST['count']) : 0;

        if($count){
            if ( !defined( 'WP_LOAD_IMPORTERS' ) ) define( 'WP_LOAD_IMPORTERS', true );

            require_once ABSPATH . 'wp-admin/includes/import.php';

            if ( !class_exists( 'WP_Importer' ) ) {
                $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                require_once $class_wp_importer;
            }

            if ( !class_exists( 'WP_Import' ) ) {
                $class_wp_import = dirname( __FILE__ ) .'/includes/wordpress-importer.php';
                require_once $class_wp_import;
            }

            $this->content_file_name = $this->kt_importer_dir.$this->demoid.'/content_'.$count.'.xml';

            if ( !is_file( $this->content_file_name ) ) {
                echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";
            } else {
                $wp_import = new WP_Import();
                $wp_import->fetch_attachments = true;
                $returned_value = $wp_import->import( $this->content_file_name );

                if ( is_wp_error($returned_value) ){
                    echo "An Error Occurred During Import";
                }

            }
        }else{
            //Content imported successfully
            do_action( 'kt_importer_after_content_import', $this->demoid );
        }

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    function kt_importer_options_callback(){
        $this->demoid = sanitize_title($_POST['demo']);
        $this->theme_options_file = $this->kt_importer_dir.$this->demoid.'/theme-options.json';

        if ( !empty( $this->theme_options_file ) && is_file( $this->theme_options_file ) ) {

            // File exists?
            if ( ! file_exists( $this->theme_options_file ) ) {
                wp_die(
                    __( 'Theme options Import file could not be found. Please try again.', 'delphinus_importer' ),
                    '',
                    array( 'back_link' => true )
                );
            }

            // Get file contents and decode
            $data = file_get_contents( $this->theme_options_file );
            $data = json_decode( $data, true );
            $data = maybe_unserialize( $data );

            if ( !empty( $data ) || is_array( $data ) ) {

                // Hook before import
                $data = apply_filters( 'kt_importer_import_theme_options', $data );
                update_option( $this->kt_importer_opt_name, $data );
            }

            do_action( 'kt_importer_after_theme_options_import', $this->demoid, $this->theme_options_file );

        }

        wp_die(); // this is required to terminate immediately and return a proper response

    }



    function kt_importer_widgets_callback(){
        $this->demoid = sanitize_title($_POST['demo']);
        $this->widgets_file_name = $this->kt_importer_dir.$this->demoid.'/widgets.json';

        // File exists?
        if ( ! file_exists( $this->widgets_file_name ) ) {
            wp_die(
                __( 'Widget Import file could not be found. Please try again.', 'delphinus_importer' ),
                '',
                array( 'back_link' => true )
            );
        }

        // Get file contents and decode
        $data = file_get_contents( $this->widgets_file_name );

        $data = json_decode( $data );

        // Import the widget data
        // Make results available for display on import/export page
        $this->widget_import_results = $this->import_widgets( $data );


        wp_die(); // this is required to terminate immediately and return a proper response
    }

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @since 1.0
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name'] = $widget['name'];

            }

        }
        return apply_filters( 'kt_importer_import_widget_available_widgets', $available_widgets );

    }

    /**
     * Import widget JSON data
     *
     * @since 1.0
     * @global array $wp_registered_sidebars
     * @param object  $data JSON widget data from .wie file
     * @return array Results array
     */
    public function import_widgets( $data ) {

        global $wp_registered_sidebars;

        // Have valid data?
        // If no data or could not decode
        if ( empty( $data ) || ! is_object( $data ) ) {
            return;
        }

        // Hook before import
        $data = apply_filters( 'kt_importer_theme_import_widget_data', $data );

        // Get all available widgets site supports
        $available_widgets = $this->available_widgets();

        // Get all existing widget instances
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            $widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
        }

        // Begin results
        $results = array();

        // Loop import data's sidebars
        foreach ( $data as $sidebar_id => $widgets ) {

            // Skip inactive widgets
            // (should not be in export file)
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Check if sidebar is available on this site
            // Otherwise add widgets to inactive, and say so
            if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
                $sidebar_available = true;
                $use_sidebar_id = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message = '';
            } else {
                $sidebar_available = false;
                $use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                $sidebar_message_type = 'error';
                $sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'delphinus_importer' );
            }

            // Result for sidebar
            $results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
            $results[$sidebar_id]['message_type'] = $sidebar_message_type;
            $results[$sidebar_id]['message'] = $sidebar_message;
            $results[$sidebar_id]['widgets'] = array();

            // Loop widgets
            foreach ( $widgets as $widget_instance_id => $widget ) {

                $fail = false;

                // Get id_base (remove -# from end) and instance ID number
                $id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
                $instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

                // Does site support this widget?
                if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
                    $fail = true;
                    $widget_message_type = 'error';
                    $widget_message = __( 'Site does not support widget', 'delphinus_importer' ); // explain why widget not imported
                }

                // Filter to modify settings before import
                // Do before identical check because changes may make it identical to end result (such as URL replacements)
                $widget = apply_filters( 'kt_importer_import_widget_settings', $widget );

                // Does widget with identical settings already exist in same sidebar?
                if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

                    // Get existing widgets in this sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' );
                    $sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

                    // Loop widgets with ID base
                    $single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
                    foreach ( $single_widget_instances as $check_id => $check_widget ) {

                        // Is widget in same sidebar and has identical settings?
                        if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

                            $fail = true;
                            $widget_message_type = 'warning';
                            $widget_message = __( 'Widget already exists', 'delphinus_importer' ); // explain why widget not imported

                            break;

                        }

                    }

                }

                // No failure
                if ( ! $fail ) {

                    // Add widget instance
                    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
                    $single_widget_instances[] = (array) $widget; // add it

                    // Get the key it was given
                    end( $single_widget_instances );
                    $new_instance_id_number = key( $single_widget_instances );

                    // If key is 0, make it 1
                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                    if ( '0' === strval( $new_instance_id_number ) ) {
                        $new_instance_id_number = 1;
                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                        unset( $single_widget_instances[0] );
                    }

                    // Move _multiwidget to end of array for uniformity
                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                        $multiwidget = $single_widget_instances['_multiwidget'];
                        unset( $single_widget_instances['_multiwidget'] );
                        $single_widget_instances['_multiwidget'] = $multiwidget;
                    }

                    // Update option with new widget
                    update_option( 'widget_' . $id_base, $single_widget_instances );

                    // Assign widget instance to sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                    $new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
                    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

                    // Success message
                    if ( $sidebar_available ) {
                        $widget_message_type = 'success';
                        $widget_message = __( 'Imported', 'delphinus_importer' );
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message = __( 'Imported to Inactive', 'delphinus_importer' );
                    }

                }

                // Result for widget instance
                $results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                $results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : __( 'No Title', 'delphinus_importer' ); // show "No Title" if widget instance is untitled
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

            }

        }

        // Hook after import
        do_action( 'kt_importer_import_widget_after_import' );

        // Return results
        return apply_filters( 'kt_importer_import_widget_results', $results );

    }









    /**
     * Add scripts
     *
     *
     */
    function kt_importer_scripts(){
        wp_enqueue_style( 'kt-importer-css', plugins_url( '/assets/css/kt-importer.css', __FILE__ ) );
        wp_enqueue_script( 'kt-importer-js', plugins_url( '/assets/js/kt-importer.js', __FILE__ ), array( 'jquery' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {

        // This page will be under "Settings"
        add_menu_page(
            __('Install Demos', 'delphinus_importer'),
            __('Install Demos', 'delphinus_importer'),
            'manage_options',
            'kt-importer-demos',
            array( $this, 'create_admin_page' ),
            'dashicons-megaphone',
            61
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {

        $demos = apply_filters( 'kt_import_demo', array() );

        ?>
        <div class="wrap kt-importer-demos">
            <h1><?php _e('Demo Content Importer', 'delphinus_importer' ); ?></h1>

            <?php

                $note = '';
                $importer_errors = array();
                $max_execution_time  = ini_get("max_execution_time");
                $max_input_time      = ini_get("max_input_time");
                $upload_max_filesize = ini_get("upload_max_filesize");

                if ($max_execution_time < 120) {
                    $importer_errors[] = '<li><strong>Maximum Execution Time (max_execution_time) : </strong>' . $max_execution_time . ' seconds. <span style="color:red"> Recommended max_execution_time should be at least 120 Seconds.</span></li>';
                }
                if ($max_input_time < 120)
                    $importer_errors[] = '<li><strong>Maximum Input Time (max_input_time) : </strong>' . $max_input_time . ' seconds. <span style="color:red"> Recommended max_input_time should be at least 120 Seconds.</span></li>';

                if(intval(WP_MEMORY_LIMIT) < 40){
                    $importer_errors[] = '<li><strong>WordPress Memory Limit (WP_MEMORY_LIMIT) : </strong>' . WP_MEMORY_LIMIT . ' <span style="color:red"> Recommended memory limit should be at least 40MB.</span></li>';
                }
                if (intval($upload_max_filesize) < 15) {
                    $importer_errors[] = '<li><strong>Maximum Upload File Size (upload_max_filesize) : </strong>' . $upload_max_filesize . ' <span style="color:red"> Recommended Maximum Upload Filesize should be at least 15MB.</li>';
                }

                if(count($importer_errors)){
                    $note .= '<ul>'.implode('', $importer_errors).'</ul>';
                }

                $note .= sprintf('<p>%s</p>',__('Make sure you have installed all recommended plugins from WordPress repository (WordPress.org) and built-in plugins which come in the full package', 'delphinus_importer'));

                $note = apply_filters('kt_importer_note', $note);

                if($note){
                    printf(
                        '<div class="kt-importer-note"><h2>%s</h2>%s</div>',
                        __('Please Read!', 'delphinus_importer'),
                        $note
                    );
                }

            ?>


            <div class="theme-browser rendered">
                <div class="themes">
                    <?php foreach($demos as $id => $demo){ ?>
                        <div class="theme">
                            <div class="theme-screenshot">
                                <img alt="<?php echo esc_attr($demo['title']) ?>" src="<?php echo esc_url($this->kt_importer_url.$id) ?>/screen-image.jpg">
                            </div>
                            <h2 class="theme-name"><?php echo esc_html($demo['title']) ?></h2>
                            <?php if(!isset($demo['coming'])){ ?>
                                <div class="theme-actions">
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="button button-primary kt-importer-imported">
                                        <?php esc_html_e('Imported', 'delphinus_importer') ?>
                                    </a>
                                    <a href="#" class="button button-primary kt-importer-button" data-id="<?php echo esc_attr($id); ?>" data-count="<?php echo intval($demo['xml_count']); ?>">
                                        <?php esc_html_e('Install', 'delphinus_importer') ?>
                                    </a>
                                    <a href="<?php echo esc_url($demo['previewlink']); ?>" target="_blank" class="button button-primary">
                                        <?php esc_html_e('Live Preview', 'delphinus_importer') ?>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php
                            if(isset($demo['status'])){
                                printf('<div class="theme-status">%s</div>', $demo['status']);
                            }
                            ?>
                            <div class="demo-import-loader">
                                <div class="demo-import-process"><span></span></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
    }
}


$kt_importer_demos = new KT_IMPORTER_DEMOS();












add_filter( 'kt_import_demo', 'kt_import_demo_delphinus' );
function kt_import_demo_delphinus( $demos ){
    $demos['demo1'] = array(
        'title' => 'Main',
        'previewlink' => 'http://delphinus.kitethemes.com/',
        'xml_count' => 6,
        'status' => sprintf(
            '<span class="%s">%s</span>',
            'demo-main',
            __('Main', 'delphinus')
        )
    );

    $demos['demo2'] = array(
        'title' => 'Home 2',
        'previewlink' => 'http://delphinus.kitethemes.com/home2',
        'xml_count' => 7
    );

    $demos['demo3'] = array(
        'title' => 'Home3',
        'previewlink' => 'http://delphinus.kitethemes.com/home3',
        'xml_count' => 9
    );

    $demos['demo4'] = array(
        'title' => 'Home4',
        'previewlink' => 'http://delphinus.kitethemes.com/home4',
        'xml_count' => 7
    );

    $demos['demo5'] = array(
        'title' => 'Home5',
        'previewlink' => 'http://delphinus.kitethemes.com/home5',
        'xml_count' => 7
    );

    $demos['demo6'] = array(
        'title' => 'Home6',
        'previewlink' => 'http://delphinus.kitethemes.com/home6',
        'xml_count' => 7
    );

    $demos['demo7'] = array(
        'title' => 'Home7',
        'previewlink' => 'http://delphinus.kitethemes.com/home7',
        'xml_count' => 6
    );

    $demos['demo8'] = array(
        'title' => 'Home8',
        'previewlink' => 'http://delphinus.kitethemes.com/home8',
        'xml_count' => 7
    );

    $demos['demo9'] = array(
        'title' => 'Home9',
        'previewlink' => 'http://delphinus.kitethemes.com/home9',
        'xml_count' => 6
    );

    return $demos;
}


if ( !function_exists( 'kt_extended_imported' ) ) {

    function kt_extended_imported( $demoid ) {


        /************************************************************************
         * Import slider(s) for the current demo being imported
         *************************************************************************/

        if ( class_exists( 'RevSlider' ) ) {

            $wbc_sliders_array = array(
                'demo1' => array('slider-home.zip', 'showcase-carousel.zip'),
                'demo2' => array('slider-home.zip'),
                'demo4' => array('slider-homepage-2.zip'),
                'demo5' => array('slider-homepage-2.zip', 'new-collection.zip'),
                'demo6' => array('slider-homepage-2.zip'),
                'demo7' => array('slider-homepage-7.zip'),
                'demo8' => array('slider-homepage-8.zip')
            );
            if ( isset( $wbc_sliders_array[$demoid]  ) ) {
                $wbc_slider_import = $wbc_sliders_array[$demoid];

                if(is_array($wbc_slider_import)){
                    foreach($wbc_slider_import as $import){
                        $import = DEL_PLUGIN_DIR.'/dummy-data/revslider/'.$import;
                        echo $import;
                        if ( file_exists( $import ) ) {
                            $slider = new RevSlider();
                            $slider->importSliderFromPost( true, true, $import );
                        }
                    }
                }
            }
        }

        /************************************************************************
         * Setting Menus
         *************************************************************************/

        $main_menu = get_term_by( 'name', esc_html__('Main menu', 'delphinus'), 'nav_menu' );
        $vertical = get_term_by( 'name', esc_html__('Vertical Navigation Menu', 'delphinus'), 'nav_menu' );


        // array of demos/homepages to check/select from
        $kt_menus = array(
            'demo1' => array(
                'primary' => $main_menu->term_id
            ),
            'demo2' => array(
                'primary' => $main_menu->term_id
            ),
            'demo3' => array(
                'primary' => $main_menu->term_id
            ),
            'demo4' => array(
                'primary' => $main_menu->term_id
            ),
            'demo5' => array(
                'primary' => $main_menu->term_id
            ),
            'demo6' => array(
                'primary' => $main_menu->term_id
            ),
            'demo7' => array(
                'primary' => $main_menu->term_id,
                'vertical' => $vertical->term_id,
            ),
            'demo8' => array(
                'primary' => $main_menu->term_id
            ),
            'demo9' => array(
                'primary' => $main_menu->term_id
            ),
        );

        if ( isset( $kt_menus[$demoid]  ) ) {
            set_theme_mod( 'nav_menu_locations',$kt_menus[$demoid]);
        }


        /************************************************************************
         * Set HomePage
         *************************************************************************/

        // array of demos/homepages to check/select from
        $kt_home_pages = array(
            'demo1' => 'Home page',
            'demo2' => 'Home page',
            'demo3' => 'Home page',
            'demo4' => 'Home page',
            'demo5' => 'Home page',
            'demo6' => 'Home page',
            'demo7' => 'Home page',
            'demo8' => 'Home page',
            'demo9' => 'Shop',
        );

        if ( isset( $kt_home_pages[$demoid]  ) ) {
            $page = get_page_by_title( $kt_home_pages[$demoid] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );
            }
        }

        /************************************************************************
         * Set Posts page
         *************************************************************************/

        // array of demos/Posts page to check/select from
        $kt_posts_pages = array(
            'demo1' => 'Blog',
            'demo2' => 'Blog',
            'demo3' => 'Blog',
            'demo4' => 'Blog',
            'demo5' => 'Blog',
            'demo6' => 'Blog',
            'demo7' => 'Blog',
            'demo8' => 'Blog',
            'demo9' => 'Blog',
        );

        if ( isset( $kt_posts_pages[$demoid]  ) ) {
            $page = get_page_by_title( $kt_posts_pages[$demoid] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_for_posts', $page->ID );
            }
        }

        /************************************************************************
         * Set MegaMenu
         *************************************************************************/

        kt_update_megamenu('Home', array('columns' => '2', 'width' => 'half', 'position' => 'center'));
        kt_update_megamenu('Shop styles', array('layout' => 'table'));
        kt_update_megamenu('Elements',  array('columns' => '3', 'width' => 'three', 'position' => 'center', 'layout' => 'table'));
        kt_update_megamenu('Features', array('layout' => 'table'));



        $page_title = '2 Column with sidebar';
        $menu_item = get_page_by_title( $page_title, 'OBJECT', 'nav_menu_item' );
        update_post_meta($menu_item->ID, '_menu_item_url', home_url( '/shop/?sidebar=left&cols=2'));

        $page_title = '3 Column with sidebar';
        $menu_item = get_page_by_title( $page_title, 'OBJECT', 'nav_menu_item' );
        update_post_meta($menu_item->ID, '_menu_item_url', home_url( '/shop/?sidebar=left&cols=3'));

        $page_title = '3 Column';
        $menu_item = get_page_by_title( $page_title, 'OBJECT', 'nav_menu_item' );
        update_post_meta($menu_item->ID, '_menu_item_url', home_url( '/shop/?sidebar=&cols=3'));

        $page_title = '4 Column';
        $menu_item = get_page_by_title( $page_title, 'OBJECT', 'nav_menu_item' );
        update_post_meta($menu_item->ID, '_menu_item_url', home_url( '/shop/?sidebar=&cols=4'));


        $woocommerce_shop_page_id = get_page_by_title( 'Shop', 'OBJECT', 'page' );
        update_option('woocommerce_shop_page_id', $woocommerce_shop_page_id->ID);

        $woocommerce_cart_page_id = get_page_by_title( 'Cart', 'OBJECT', 'page' );
        update_option('woocommerce_cart_page_id', $woocommerce_cart_page_id->ID);

        $woocommerce_checkout_page_id = get_page_by_title( 'Checkout', 'OBJECT', 'page' );
        update_option('woocommerce_checkout_page_id', $woocommerce_checkout_page_id->ID);

        $woocommerce_myaccount_page_id = get_page_by_title( 'My Account', 'OBJECT', 'page' );
        update_option('woocommerce_myaccount_page_id', $woocommerce_myaccount_page_id->ID);


    }
    add_action( 'kt_importer_after_content_import', 'kt_extended_imported');
}

function kt_update_megamenu($title, $args = array()){

    $default = array(
        'columns' => '4',
        'width' => 'full',
        'layout' => 'default',
        'position' => 'center'
    );

    $args = wp_parse_args( $args, $default );

    $menu_item = get_page_by_title( $title, 'OBJECT', 'nav_menu_item' );
    update_post_meta($menu_item->ID, '_menu_item_megamenu_enable', 'enabled');
    update_post_meta($menu_item->ID, '_menu_item_megamenu_columns', $args['columns']); // 4, 3, 2
    update_post_meta($menu_item->ID, '_menu_item_megamenu_width', $args['width']); // full, half, three, four, five
    update_post_meta($menu_item->ID, '_menu_item_megamenu_layout', $args['layout']);
    update_post_meta($menu_item->ID, '_menu_item_megamenu_position', $args['position']); // center, left-menubar, right-menubar, left-parent, right-parent

}
