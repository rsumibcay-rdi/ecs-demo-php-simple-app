<?php
namespace MBAIO;

class Loader {
	public function __construct() {
		// Use 'init' hook to make the filter 'mb_aio_extensions' can be used in themes or other plugins that loaded after this plugin.
		// Priority -5  make sure it runs before any required hook required by premium extensions.
		add_action( 'init', array( $this, 'load_extensions' ), -5 );
	}

	public function load_extensions( $extensions = [] ) {
		$extensions = empty( $extensions ) ? $this->get_enabled_extensions() : $extensions;

		foreach ( $extensions as $extension ) {
			require_once self::get_extension_file( $extension );
		}
	}

	private function get_enabled_extensions() {
		$option     = get_option( 'meta_box_aio' );
		$extensions = isset( $option['extensions'] ) ? $option['extensions'] : array();
		$extensions = apply_filters( 'mb_aio_extensions', $extensions );
		$extensions = array_unique( $extensions );

		return $extensions;
	}

	public static function get_extension_file( $extension ) {
		$files = array_merge(
			array(
				$extension => $extension,
			),
			array(
				'meta-box-text-limiter' => 'text-limiter',
				'meta-box-yoast-seo'    => 'mb-yoast-seo',
			)
		);
		$file  = $files[$extension];
		return dirname( __DIR__ ) . "/vendor/meta-box/$extension/$file.php";
	}
}
