<?php
    if ( kt_is_wc()){
        $text = (is_user_logged_in ()) ? esc_html__('My Account', 'delphinus') : esc_html__('Login/Register', 'delphinus');
        printf(
            '<li><a href="%s">%s</a>',
            get_permalink( get_option('woocommerce_myaccount_page_id') ),
            $text
        );
    }
?>