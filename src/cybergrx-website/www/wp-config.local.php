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

if(file_exists(dirname(__FILE__) . '/zen-config.php') && include('zen-config.php')) return true;

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'wordpress');

/** MySQL hostname */
define('DB_HOST', 'mysql');

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
define('AUTH_KEY',         'qrz9Y#Ku]R+(E0x[FFlQQpb,:/8OiltX:>)EA,OHuB;W~oa*GI=bFt`1]h](vAia');
define('SECURE_AUTH_KEY',  'j)(T3IdL);+A|(wWh?12PqF,Ig6x=+- vI&4@]i6:$*~|]1O<0BWB}|[ww.)9;v=');
define('LOGGED_IN_KEY',    '1X>!D9|xG]1,Q|~Q/>4|V94i@Q<|q*@KPiW|i=M#;GM$v-e#&mqE6*rzthW0aa% ');
define('NONCE_KEY',        'd^bM@@h-)n=;;eC1](twckMM=M68Kl#3$&s4}b6R{/E/+97 A;RPMMpf*RDH05CT');
define('AUTH_SALT',        'h(jE+gSz_{-XFpFE*_/Qay6TyaL8O(|;T-|NW1{>O#sJky|[KQdgX[N`~NL_BTry');
define('SECURE_AUTH_SALT', '2U9F&o$u[.LNu#y|z-(UJ#0FI7*9|55N#;jJ8&S|W+?|UZOhu/y39@~p8i6/}MY+');
define('LOGGED_IN_SALT',   '$,oAM2!NxS!>6H5,TrGNzCp_@F<q8]Rlio3 UNN+})|lnb|%]ze%#33TE#-$-SNo');
define('NONCE_SALT',       'jk=0#Fwr(f]Z@e@6.w,>k_ye&VC/#!~zcONZ;J95#/+xaHg-)pb!Z1%XU[ku%dxM');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_5zuerr_';

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
define('WP_DEBUG', true);
define('WP_HOME', 'http://cybergrx.local');
define('WP_SITEURL', 'http://cybergrx.local');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
