<?php
/**
 * The base configuration for WordPress
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/* Select config file based on environment.
* The APP_ENV value may be set as an Apache directive SetEnv within
* an apache vhost config file:
* For example:
* 
* SetEnv APP_ENV development
* 
*/
if ( getenv('APP_ENV') ) {
    define('ENVIRONMENT', getenv('APP_ENV'));
} else {
    define('ENVIRONMENT', 'production');
}

require_once(ABSPATH . 'wp-config.' . ENVIRONMENT . '.php');
