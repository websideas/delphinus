<?php

if ( !function_exists( 'kt_admin_enqueue_scripts' ) ) {

    /**
     * Add stylesheet and script for admin
     *
     * @since       1.0
     * @return      void
     * @access      public
     */
    function kt_admin_enqueue_scripts( $hook_suffix ){
        wp_enqueue_style( 'font-awesome', KT_THEME_LIBS.'font-awesome/css/font-awesome.min.css');
        wp_enqueue_style( 'framework-core', KT_FW_CSS.'framework-core.css');
        wp_enqueue_style( 'jquery-chosen', KT_FW_LIBS.'/chosen/chosen.min.css');
        wp_enqueue_style( 'kt-delphinus', KT_THEME_LIBS . 'delphinus/style.css', array());

        wp_enqueue_script( 'jquery-chosen', KT_FW_LIBS.'/chosen/chosen.jquery.min.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'cookie', KT_FW_JS.'jquery.cookie.js', array('jquery'), KT_FW_VER, true);
        wp_enqueue_script( 'kt_icons', KT_FW_JS.'kt_icons.js', array('jquery'), KT_FW_VER, true);

        wp_enqueue_media();
        wp_enqueue_script( 'kt_image', KT_FW_JS.'kt_image.js', array('jquery'), KT_FW_VER, true);
        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => esc_html__('Select your image', 'delphinus' )
        ));

        if ( 'widgets.php' === $hook_suffix ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'underscore' );
            wp_enqueue_script( 'kt_color', KT_FW_JS.'kt_color.js', array('jquery'), KT_FW_VER, true);

        }


        wp_enqueue_script( 'framework-core', KT_FW_JS.'framework-core.js', array('jquery', 'jquery-ui-tabs'), KT_FW_VER, true);


    } // End kt_admin_enqueue_scripts.
    add_action( 'admin_enqueue_scripts', 'kt_admin_enqueue_scripts' );
}


