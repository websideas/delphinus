<?php
function delphinus_child_scripts() {
    wp_enqueue_style( 'delphinus-child', get_stylesheet_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'delphinus_child_scripts', 99);