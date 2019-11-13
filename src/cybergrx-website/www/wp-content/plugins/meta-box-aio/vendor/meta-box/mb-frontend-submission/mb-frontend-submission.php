<?php
/**
 * Plugin Name: MB Frontend Submission
 * Plugin URI:  https://metabox.io/plugins/mb-frontend-submission
 * Description: Submit posts and custom fields in the frontend.
 * Version:     2.0.2
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: mb-frontend-submission
 * Domain Path: /languages/
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mb_frontend_submission_load' ) ) {
	/**
	 * Hook to 'init' with priority 10 to make sure all meta boxes are registered.
	 */
	add_action( 'init', 'mb_frontend_submission_load', 20 );

	/**
	 * Load plugin files after Meta Box is loaded
	 */
	function mb_frontend_submission_load() {
		if ( ! defined( 'RWMB_VER' ) ) {
			return;
		}

		include __DIR__ . '/vendor/autoload.php';

		if ( session_status() === PHP_SESSION_NONE ) {
			session_start();
		}

		define( 'MB_FRONTEND_SUBMISSION_DIR', __DIR__ );
		list( , $url ) = RWMB_Loader::get_path( MB_FRONTEND_SUBMISSION_DIR );
		define( 'MB_FRONTEND_SUBMISSION_URL', $url );

		load_plugin_textdomain( 'mb-frontend-submission', false, basename( MB_FRONTEND_SUBMISSION_DIR ) . '/languages' );

		$shortcode = new MBFS\Shortcode();
		$shortcode->init();
	}
}
