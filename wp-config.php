<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'www-data' );

/** MySQL database password */
define( 'DB_PASSWORD', 'www' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
define('FS_METHOD', 'direct');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'p61|=(LVltu-WsD6}{|SH5;&mjQe,[s[q@LUKw!=QmSCX1le3.Y]%H]0(KSR4)OL');
define('SECURE_AUTH_KEY',  'oa72xVX4>|`u]{Rf5~*+|M^LG--9vC<VhJ|D+2>vn3Cw2iep^XfD:M=58A@ECiVY');
define('LOGGED_IN_KEY',    'NC]K9|C> ?n>^1z9J;?;_1Wm],,FvT!]L{A)Y]{QWNjOP <8SzTck5 t}d 1N@o/');
define('NONCE_KEY',        '_%0;>*d+vm-ZmUGjJ74A@jC@A].xbkM-gMsexXViDPRq5:.^XE=]A M[7~*D,*T.');
define('AUTH_SALT',        'h|,:<(ArPbU;FT-D`aF4_($}vT96T#oP{;b!.ab3j7SnFt+}X5Vb<y?_49MRd3PZ');
define('SECURE_AUTH_SALT', 'W>]kt-Fth`Gw&ci=x{Pf$-+e(Bw!t::wk8en@}H,hP~9.>1(Z;<pc@$S0vyDQ-@L');
define('LOGGED_IN_SALT',   '%2.{}7.O2w$*/cA_-YR|}-_P^m2-WXKut;g7d&?M)iF0T:9:C_YIsxP$9(`bULz%');
define('NONCE_SALT',       '</{%t[o69%:jGHymhpRP08Xo12ua1c!&#p5?#p3WL2A(|297qeNa(^O&D*`f>`$~');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
