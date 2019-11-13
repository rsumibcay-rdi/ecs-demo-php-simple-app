<?php
class MB_User_Meta_Loader {
	public static $meta_boxes = [];

	public function __construct() {
		add_filter( 'rwmb_meta_box_class_name', [ $this, 'change_meta_box_class_name' ], 10, 2 );

		add_filter( 'rwmb_meta_type', [ $this, 'change_meta_type' ], 10, 2 );

		add_filter( 'rwmb_meta_boxes', [ $this, 'load_meta_boxes_legacy' ], 9999 );

		add_action( 'user_edit_form_tag', [ $this, 'output_form_upload_attributes' ] );
	}

	/**
	 * Store meta boxes to static variable to make compatible with Admin Columns.
	 *
	 * @param  array $meta_boxes Array of meta boxes.
	 * @return array
	 */
	public function load_meta_boxes_legacy( $meta_boxes ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( empty( $meta_box['type'] ) || 'user' !== $meta_box['type'] ) {
				continue;
			}

			self::$meta_boxes[] = $meta_box;
		}

		return $meta_boxes;
	}

	/**
	 * Filter meta box class name.
	 *
	 * @param  string $class_name Meta box class name.
	 * @param  array  $meta_box   Meta box data.
	 * @return string
	 */
	public function change_meta_box_class_name( $class_name, $meta_box ) {
		if ( isset( $meta_box['type'] ) && 'user' === $meta_box['type'] ) {
			$class_name = 'MB_User_Meta_Box';
		}

		return $class_name;
	}

	/**
	 * Filter meta type from object type and object id.
	 *
	 * @param string $type        Meta type get from object type and object id.
	 * @param string $object_type Object type.
	 *
	 * @return string
	 */
	public function change_meta_type( $type, $object_type ) {
		return 'user' === $object_type ? 'user' : $type;
	}

	public function output_form_upload_attributes() {
		echo ' enctype="multipart/form-data"';
	}
}
