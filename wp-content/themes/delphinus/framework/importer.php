<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;



add_filter( 'kt_import_demo', 'kt_import_demo_delphinus' );
function kt_import_demo_delphinus( $demos ){
    $demos['demo1'] = array(
        'title' => 'Main',
        'previewlink' => 'http://delphinus.kitethemes.com/',
        'xml_count' => 1,
        'status' => sprintf(
            '<span class="%s">%s</span>',
            'demo-main',
            __('Main', 'delphinus')
        )
    );

    $demos['demo2'] = array(
        'title' => 'Home',
        'previewlink' => 'http://delphinus.kitethemes.com/home2',
        'xml_count' => 1
    );

    $demos['demo3'] = array(
        'title' => 'Home3',
        'previewlink' => 'http://delphinus.kitethemes.com/home3',
        'xml_count' => 1
    );

    $demos['demo4'] = array(
        'title' => 'Home4',
        'previewlink' => 'http://delphinus.kitethemes.com/home4',
        'xml_count' => 1
    );

    $demos['demo5'] = array(
        'title' => 'Home5',
        'previewlink' => 'http://delphinus.kitethemes.com/home5',
        'xml_count' => 1
    );

    $demos['demo6'] = array(
        'title' => 'Home6',
        'previewlink' => 'http://delphinus.kitethemes.com/home6',
        'xml_count' => 1
    );

    $demos['demo7'] = array(
        'title' => 'Home7',
        'previewlink' => 'http://delphinus.kitethemes.com/home7',
        'xml_count' => 1
    );

    $demos['demo8'] = array(
        'title' => 'Home8',
        'previewlink' => 'http://delphinus.kitethemes.com/home8',
        'xml_count' => 1
    );

    $demos['demo9'] = array(
        'title' => 'Home9',
        'previewlink' => 'http://delphinus.kitethemes.com/home9',
        'xml_count' => 1
    );

    return $demos;
}


if ( !function_exists( 'kt_extended_imported' ) ) {

    function kt_extended_imported( $demoid ) {


        /************************************************************************
         * Setting Menus
         *************************************************************************/

        $main_menu = get_term_by( 'name', __('Main menu', 'delphinus'), 'nav_menu' );
        $mobile = get_term_by( 'name', __('Main Menu', 'delphinus'), 'nav_menu' );
        $footer = get_term_by( 'name', __('Footer Navigation Menu', 'delphinus'), 'nav_menu' );

        // array of demos/homepages to check/select from
        $kt_menus = array(
            'demo1' => array(
                'primary' => $main_menu->term_id,
                'mobile' => $mobile->term_id,
                'footer' => $footer->term_id
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
            'demo1' => 'Home',
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
        );

        if ( isset( $kt_posts_pages[$demoid]  ) ) {
            $page = get_page_by_title( $kt_posts_pages[$demoid] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_for_posts', $page->ID );
            }
        }

    }
    add_action( 'kt_importer_after_content_import', 'kt_extended_imported');
}




function kt_importer_dir_delphinus( ) {
    return KT_THEME_DATA_DIR.'/';
}
add_filter('kt_importer_dir', 'kt_importer_dir_delphinus' );

function kt_importer_url_delphinus( ) {

    return KT_THEME_DATA.'/';
}
add_filter('kt_importer_url', 'kt_importer_url_delphinus' );

function kt_importer_opt_name_delphinus(  ) {
    return KT_THEME_OPTIONS;
}
add_filter('kt_importer_opt_name', 'kt_importer_opt_name_delphinus' );