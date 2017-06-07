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
define('DB_NAME', 'matrix_wprs');

/** MySQL database username */
define('DB_USER', 'matrix_wps');

/** MySQL database password */
define('DB_PASSWORD', 'DKtTUAU*ZH+a');

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
define('AUTH_KEY',         'aSz+4:ZOaL87UTx3op)NFMD?DR8(gh+.ib>~rT5J>V*]T:B!kr,`J|d<i;{TJC}.');
define('SECURE_AUTH_KEY',  'Tz-mB{LLJrYC#w#x^|(3ynmX(}+u>%)5dn%uSCJ=6F>w5Rd=}X}Xt9)^_~*+5FJB');
define('LOGGED_IN_KEY',    'cb6mfQ?c5 enm>FdkI.jkcSx5hlv.igS6EV+hO!n[+Z&:tGCmMwl~&TV<0fn~^A&');
define('NONCE_KEY',        'kIzU9qCAA)cNWz]m3E,#:1&]y X=Wu< ,#gLCl9AqNusq3h[fGZ*3)*UO/!kc)gi');
define('AUTH_SALT',        'sF,)LiRYx=#ikEd1N:SoJoK}RUldqh:D0E<4X<0(MMhlrm.uIm@w /xMGK1ZDNES');
define('SECURE_AUTH_SALT', '%bd.b]aD:>dhq @o.RuQ9pB_MB-tf=kYJM_cnjnPss<ZWA!k)1Or22J3~=%v0D=;');
define('LOGGED_IN_SALT',   'u6b2`+KhMaQk4T-n<lwSqpYuMhE-W5Co--o5kIi);<ebJq$H&X3a3bKOg6O5Jqz5');
define('NONCE_SALT',       'FN (kOF wv$Zw-f62D+kiE]--_(~h5PaQ; vXEfShDD1pOF}(XH2@(x#:P-].&Mm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'matrixwps_';

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
