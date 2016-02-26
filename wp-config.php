<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'delphinus');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1H=W@T&$:-Y~1w%q2Hm.Pe>|OZbHpe!bL|y|`qe0n+IVZsop|g,mxG1`R7},YfXW');
define('SECURE_AUTH_KEY',  'k#:,L>t<AoJ|i@X15h*_<Z|+6=Vs* 0OMyiNU4hbg_Aiwve0yRfafX `9<dd:EHN');
define('LOGGED_IN_KEY',    ',y BW1/LJ%xMl8D;^K.IA[%Y!-3Zh3bp)?;-J,ohByvLj(@e8}L,QIhpQ,md>It}');
define('NONCE_KEY',        'P>ye?zDRysNBfVTcyXL@k(?_T|Y+)z<6A|P)JVH*D{6yf~pyRN>vgp#-i|NWJ:`!');
define('AUTH_SALT',        '@iNB2@q/sG&Ry;Fw I@1G>wZ+Gt%lLg1+C8 tQ,{B>aL,Pv<f-aO2*~u)<NRQT=0');
define('SECURE_AUTH_SALT', 'Q2wNd/`*1=iy486z_Fql}D|(uUejrd+3d)qRf8nFqFqSG^+&zKwL_Myk0MUIp>M@');
define('LOGGED_IN_SALT',   'RPhNdR:?nOxc6#l-.VpWUn1Std&n&bp..Y1N5kP_`G:Wpp6=V`q04!fNgLb::[n{');
define('NONCE_SALT',       '`;[,j0}</gv/HZvwV=afvOweyvF?4+VG]5 FU3eTTC0m-y_aNvJf?|P,U(`kT|mI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
