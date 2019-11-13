<?php
/**
 * Plugin Name: Meta Box AIO
 * Plugin URI:  https://metabox.io/pricing/
 * Description: All Meta Box extensions in one package.
 * Version:     1.8.1
 * Author:      MetaBox.io
 * Author URI:  https://metabox.io
 * License:     GPL2+
 * Text Domain: meta-box-aio
 * Domain Path: /languages/
 *
 * @package    Meta Box
 * @subpackage Meta Box AIO
 */

defined( 'ABSPATH' ) || die;

require __DIR__ . '/vendor/autoload.php';
$mbaio_loader = new MBAIO\Loader;

// Always load some default extensions.
$mbaio_loader->load_extensions( ['meta-box-updater', 'mb-settings-page'] );

new MBAIO\Settings;

if ( is_admin() ) {
	new MBAIO\DashboardWidget;
}
