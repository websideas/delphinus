<?php
//session_start();
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


define( 'KT_THEME_OPTIONS', 'mondova_option' );

define( 'KT_THEME_DIR', trailingslashit(get_template_directory()));
define( 'KT_THEME_URL', trailingslashit(get_template_directory_uri()));
define( 'KT_THEME_TEMP', KT_THEME_DIR.'templates/');
define( 'KT_THEME_DATA', KT_THEME_URL.'dummy-data/');
define( 'KT_THEME_DATA_DIR', KT_THEME_DIR.'dummy-data/');

define( 'KT_THEME_ASSETS', KT_THEME_URL . 'assets/');
define( 'KT_THEME_LIBS', KT_THEME_ASSETS . 'libs/');
define( 'KT_THEME_JS', KT_THEME_ASSETS . 'js/');
define( 'KT_THEME_CSS', KT_THEME_ASSETS . 'css/');
define( 'KT_THEME_IMG', KT_THEME_ASSETS . 'images/');

//Include framework
require KT_THEME_DIR .'framework/core.php';
