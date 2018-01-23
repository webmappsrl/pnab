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
define('DB_NAME', 'wp_brenta');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'B&CxIeh?wFpYm7 hYjO+2eL<VG}%Uw3CYCE~,iMBo*ln`)+j)fN`QhHDOFXu5/8u');
define('SECURE_AUTH_KEY',  '=r0r#D4yC6WO7|Pm@iDI*wGCXu)4(H:;#<r22[ThMDKP(-A}lg*oYH:u+N UqG<|');
define('LOGGED_IN_KEY',    '&c&x?H/=Wb>//@4l{[NCP`Wy[^Udoz@+7b1z1F|TM5=pwZ%[qz3N5L[%-C!+nq$#');
define('NONCE_KEY',        'lPoj-M2$(Mo_u7j7Uv?lFyXL8g:*&7VxpFn!==4DZ-&+&YqHA*pGJ/`](*,1Qp+,');
define('AUTH_SALT',        '@gdHTsM)Y+8.qAY:/_kW*ZiAAkJJZ~vg_&H-3,*yG@yLicU`KPufP+4XgB*U~3/7');
define('SECURE_AUTH_SALT', '1_+,:E0;-l{t>2O?A8%pD+?Gkuu?9umb__R+2^A=B +HlN=uRM(Nh0]X7-r0KNUy');
define('LOGGED_IN_SALT',   '=18/S1[r>IomL?-r_8Sluk3[+@yGF+Y}|I`?>aZ6hq--$KJ8,!KBskCWeE_QXKBL');
define('NONCE_SALT',       '-1JxeU<XZH`3v<56vY-bu+qX5k)jV]82mAhwO$XI!$C>k1e|ev+rfK82>MUG`sVu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define( 'WP_MEMORY_LIMIT', '256M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
define('FS_METHOD', 'direct');


/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

