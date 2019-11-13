<?php
/**
 * Get field edit content
 *
 * @param  string $type Input Type
 *
 * @return string html
 */
function mbb_get_field_edit_content( $type ) {
	if ( 'switch' === $type ) {
		$class = 'Switcher';
	} else {
		$class = str_replace( ' ', '', ucwords( str_replace( '_', ' ', $type ) ) );
	}
	$class = "MBB\Fields\\$class";
	new $class;
}

function mbb_get_attribute_content( $attribute, $param = '', $label = '', $add_button = '' ) {
	$attribute = str_replace( '_', '-', $attribute );

	$default_label = MBB\Attribute::has_label( $param ) ? MBB\Attribute::get_label( $param ) : str_title( $param );
	$label         = $label ?: $default_label;

	ob_start();
	include MBB_DIR . "views/attributes/$attribute.php";
	return ob_get_clean();
}

/**
 * Get post type for displaying on Meta Box Settings
 *
 * @return array Post types
 */
function mbb_get_post_types() {
	$unsupported = [
		// WordPress built-in post types.
		'revision',
		'nav_menu_item',
		'customize_changeset',
		'oembed_cache',
		'custom_css',
		'user_request',
		'wp_block',

		// Meta Box post types.
		'meta-box',
		'mb-post-type',
		'mb-taxonomy',
	];
	$post_types  = get_post_types( [], 'objects' );
	$post_types  = array_diff_key( $post_types, array_flip( $unsupported ) );
	$post_types  = array_map( function( $post_type ) {
		return [
			'slug'         => $post_type->name,
			'name'         => $post_type->labels->singular_name,
			'hierarchical' => $post_type->hierarchical,
		];
	}, $post_types );

	return array_values( $post_types );
}

/**
 * Get taxonomies for displaying dropdown for taxonomy and taxonomy_advanced fields
 *
 * @return array
 */
function mbb_get_taxonomies() {
	$unsupported = ['link_category', 'nav_menu', 'post_format'];
	$taxonomies  = get_taxonomies( '', 'objects' );
	$taxonomies  = array_diff_key( $taxonomies, array_flip( $unsupported ) );
	$taxonomies  = array_map( function( $taxonomy ) {
		return [
			'slug'         => $taxonomy->name,
			'name'         => $taxonomy->labels->singular_name,
			'hierarchical' => $taxonomy->hierarchical,
		];
	}, $taxonomies );

	return array_values( $taxonomies );
}

function mbb_get_page_templates() {
	$templates = get_page_templates();

	return $templates;
}

function mbb_get_templates() {
	$post_types = mbb_get_post_types();

	$templates = [];
	foreach ( $post_types as $post_type ) {
		$post_type_templates = get_page_templates( null, $post_type['slug'] );
		foreach ( $post_type_templates as $name => $file ) {
			$templates[] = [
				'name'           => $name,
				'file'           => $file,
				'post_type'      => $post_type['slug'],
				'post_type_name' => $post_type['name'],
				'id'             => "{$post_type['slug']}:{$file}",
			];
		}
	}

	return $templates;
}

function mbb_get_post_formats() {
	if ( ! current_theme_supports( 'post-formats' ) ) {
		return [];
	}
	$post_formats = get_theme_support( 'post-formats' );

	return is_array( $post_formats[0] ) ? $post_formats[0] : [];
}

function mbb_get_setting_pages() {
	$pages = array();
	$settings_pages = apply_filters( 'mb_settings_pages', array() );
	foreach ( $settings_pages as $settings_page ) {
		$title = '';
		if ( ! empty( $settings_page['menu_title'] ) ) {
			$title = $settings_page['menu_title'];
		} elseif ( ! empty( $settings_page['page_title'] ) ) {
			$title = $settings_page['page_title'];
		}
		$pages[$settings_page['id']] = array(
			'id'    => $settings_page['id'],
			'title' => $title,
		);
	}
	return $pages;
}

function mbb_get_categories() {
	$categories = get_categories();

	$cats = array();

	foreach ( $categories as $cat ) {
		$cats[ $cat->term_id ] = $cat->name;
	}

	return $cats;
}

function mbb_get_terms() {
	$taxonomies = wp_list_pluck( mbb_get_taxonomies(), 'slug' );
	$terms      = get_terms( [
		'taxonomy'   => $taxonomies,
		'hide_empty' => false,
	] );

	return $terms;
}

function mbb_get_posts() {
	global $wpdb;
	$posts = $wpdb->get_results( "SELECT ID, post_title, post_name, post_type FROM $wpdb->posts", ARRAY_A );
	return $posts;
}

/**
 * Array of Menu item on builder GUI
 *
 * Todo: Remove it and use default field type and field value
 *
 * @return array Menu structure
 */
function mbb_get_builder_menu() {
	$menu = array(
		__( 'Basic', 'meta-box-builder' ) => [
			'text'            => __( 'Text', 'meta-box-builder' ),
			'email'           => __( 'Email', 'meta-box-builder' ),
			'url'             => __( 'URL', 'meta-box-builder' ),
			'number'          => __( 'Number', 'meta-box-builder' ),
			'checkbox'        => __( 'Checkbox', 'meta-box-builder' ),
			'checkbox_list'   => __( 'Checkbox List', 'meta-box-builder' ),
			'button'          => __( 'Button', 'meta-box-builder' ),
			'button_group'    => __( 'Button Group', 'meta-box-builder' ),
			'password'        => __( 'Password', 'meta-box-builder' ),
			'radio'           => __( 'Radio', 'meta-box-builder' ),
			'select'          => __( 'Select', 'meta-box-builder' ),
			'select_advanced' => __( 'Select Advanced', 'meta-box-builder' ),
			'textarea'        => __( 'Textarea', 'meta-box-builder' ),
			'hidden'          => __( 'Hidden', 'meta-box-builder' ),
			'range'           => __( 'Range', 'meta-box-builder' ),
		],

		__( 'Advanced', 'meta-box-builder' ) => [
			'image_select'  => __( 'Image Select', 'meta-box-builder' ),
			'color'         => __( 'Color Picker', 'meta-box-builder' ),
			'oembed'        => __( 'oEmbed', 'meta-box-builder' ),
			'slider'        => __( 'Slider', 'meta-box-builder' ),
			'wysiwyg'       => __( 'WYSIWYG', 'meta-box-builder' ),
			'autocomplete'  => __( 'Autocomplete', 'meta-box-builder' ),
			'fieldset_text' => __( 'Fieldset Text', 'meta-box-builder' ),
			'text_list'     => __( 'Text List', 'meta-box-builder' ),
			'background'    => __( 'Background', 'meta-box-builder' ),
			'switch'        => __( 'Switch', 'meta-box-builder' ),
			'map'           => __( 'Google Maps', 'meta-box-builder' ),
			'custom_html'   => __( 'Custom HTML', 'meta-box-builder' ),
			'osm'           => __( 'Open Street Map', 'meta-box-builder' ),
			'date'          => __( 'Date', 'meta-box-builder' ),
			'datetime'      => __( 'Date Time', 'meta-box-builder' ),
			'time'          => __( 'Time', 'meta-box-builder' ),
		],

		__( 'WordPress', 'meta-box-builder' ) => [
			'post'              => __( 'Post', 'meta-box-builder' ),
			'taxonomy'          => __( 'Taxonomy', 'meta-box-builder' ),
			'taxonomy_advanced' => __( 'Taxonomy Advanced', 'meta-box-builder' ),
			'user'              => __( 'User', 'meta-box-builder' ),
			'sidebar'           => __( 'Sidebar', 'meta-box-builder' ),
		],

		__( 'Upload', 'meta-box-builder' ) => [
			'file'           => __( 'HTML File', 'meta-box-builder' ),
			'file_advanced'  => __( 'File Advanced', 'meta-box-builder' ),
			'file_upload'    => __( 'File Upload', 'meta-box-builder' ),
			'file_input'     => __( 'File Input', 'meta-box-builder' ),
			'image'          => __( 'HTML Image', 'meta-box-builder' ),
			'single_image'   => __( 'Single Image', 'meta-box-builder' ),
			'image_advanced' => __( 'Image Advanced', 'meta-box-builder' ),
			'image_upload'   => __( 'Image Upload', 'meta-box-builder' ),
			'video'          => __( 'Video', 'meta-box-builder' ),
		],

		__( 'Layout', 'meta-box-builder' ) => [
			'heading' => __( 'Heading', 'meta-box-builder' ),
			'divider' => __( 'Divider', 'meta-box-builder' ),
		],
	);

	if ( mbb_is_extension_active( 'meta-box-tabs' ) ) {
		$menu['Layout']['tab'] = __( 'Tab', 'meta-box-builder' );
	}
	if ( mbb_is_extension_active( 'meta-box-group' ) ) {
		$menu['Layout']['group'] = __( 'Group', 'meta-box-builder' );
	}

	return $menu;
}

if ( ! function_exists( 'str_title' ) ) {
	/**
	 * Convert snake case or normal case to title case
	 *
	 * @param  String $str String to be convert
	 *
	 * @return String As Title
	 */
	function str_title( $str ) {
		$str = str_replace( '_', ' ', $str );

		return ucwords( $str );
	}
}

if ( ! function_exists( 'array_unflatten' ) ) {
	/**
	 * Convert flatten collection (with dot notation) to multiple dimmensionals array
	 *
	 * @param  Collection $collection Collection to be flatten
	 *
	 * @return Array
	 */
	function array_unflatten( $collection ) {
		$collection = (array) $collection;

		$output = array();

		foreach ( $collection as $key => $value ) {
			array_set( $output, $key, $value );

			if ( is_array( $value ) && ! strpos( $key, '.' ) ) {
				$nested = array_unflatten( $value );

				$output[ $key ] = $nested;
			}
		}

		return $output;
	}
}


if ( ! function_exists( 'array_set' ) ) {
	function array_set( &$array, $key, $value ) {
		if ( is_null( $key ) ) {
			return $array = $value;
		}

		$keys = explode( '.', $key );

		while ( count( $keys ) > 1 ) {
			$key = array_shift( $keys );

			// If the key doesn't exist at this depth, we will just create an empty array
			// to hold the next value, allowing us to create the arrays to hold final
			// values at the correct depth. Then we'll keep digging into the array.
			if ( ! isset( $array[ $key ] ) || ! is_array( $array[ $key ] ) ) {
				$array[ $key ] = array();
			}

			$array =& $array[ $key ];
		}

		$array[ array_shift( $keys ) ] = $value;

		return $array;
	}
}

if ( ! function_exists( 'ends_with' ) ) {
	/**
	 * Determine if a given string ends with a given substring.
	 *
	 * @param  string       $haystack
	 * @param  string|array $needles
	 *
	 * @return bool
	 */
	function ends_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( (string) $needle === substr( $haystack, - strlen( $needle ) ) ) {
				return true;
			}
		}

		return false;
	}
}

/**
 * Get All WP Dashicon for displaying in Tab or Tooltip
 *
 * @return Array List of WP Dashicon
 */
function mbb_get_dashicons() {
	return array(
		'dashicons-admin-appearance',
		'dashicons-admin-collapse',
		'dashicons-admin-comments',
		'dashicons-admin-generic',
		'dashicons-admin-home',
		'dashicons-admin-links',
		'dashicons-admin-media',
		'dashicons-admin-network',
		'dashicons-admin-page',
		'dashicons-admin-plugins',
		'dashicons-admin-post',
		'dashicons-admin-settings',
		'dashicons-admin-site',
		'dashicons-admin-tools',
		'dashicons-admin-users',
		'dashicons-album',
		'dashicons-align-center',
		'dashicons-align-left',
		'dashicons-align-none',
		'dashicons-align-right',
		'dashicons-analytics',
		'dashicons-archive',
		'dashicons-arrow-down-alt2',
		'dashicons-arrow-down-alt',
		'dashicons-arrow-down',
		'dashicons-arrow-left-alt2',
		'dashicons-arrow-left-alt',
		'dashicons-arrow-left',
		'dashicons-arrow-right-alt2',
		'dashicons-arrow-right-alt',
		'dashicons-arrow-right',
		'dashicons-arrow-up-alt2',
		'dashicons-arrow-up-alt',
		'dashicons-arrow-up',
		'dashicons-art',
		'dashicons-awards',
		'dashicons-backup',
		'dashicons-book-alt',
		'dashicons-book',
		'dashicons-building',
		'dashicons-businessman',
		'dashicons-calendar-alt',
		'dashicons-calendar',
		'dashicons-camera',
		'dashicons-carrot',
		'dashicons-cart',
		'dashicons-category',
		'dashicons-chart-area',
		'dashicons-chart-bar',
		'dashicons-chart-line',
		'dashicons-chart-pie',
		'dashicons-clipboard',
		'dashicons-clock',
		'dashicons-cloud',
		'dashicons-controls-back',
		'dashicons-controls-forward',
		'dashicons-controls-pause',
		'dashicons-controls-play',
		'dashicons-controls-repeat',
		'dashicons-controls-skipback',
		'dashicons-controls-skipforward',
		'dashicons-controls-volumeoff',
		'dashicons-controls-volumeon',
		'dashicons-dashboard',
		'dashicons-desktop',
		'dashicons-dismiss',
		'dashicons-download',
		'dashicons-editor-aligncenter',
		'dashicons-editor-alignleft',
		'dashicons-editor-alignright',
		'dashicons-editor-bold',
		'dashicons-editor-break',
		'dashicons-editor-code',
		'dashicons-editor-contract',
		'dashicons-editor-customchar',
		'dashicons-editor-distractionfree',
		'dashicons-editor-expand',
		'dashicons-editor-help',
		'dashicons-editor-indent',
		'dashicons-editor-insertmore',
		'dashicons-editor-italic',
		'dashicons-editor-justify',
		'dashicons-editor-kitchensink',
		'dashicons-editor-ol',
		'dashicons-editor-outdent',
		'dashicons-editor-paragraph',
		'dashicons-editor-paste-text',
		'dashicons-editor-paste-word',
		'dashicons-editor-quote',
		'dashicons-editor-removeformatting',
		'dashicons-editor-rtl',
		'dashicons-editor-spellcheck',
		'dashicons-editor-strikethrough',
		'dashicons-editor-textcolor',
		'dashicons-editor-ul',
		'dashicons-editor-underline',
		'dashicons-editor-unlink',
		'dashicons-editor-video',
		'dashicons-edit',
		'dashicons-email-alt',
		'dashicons-email',
		'dashicons-excerpt-view',
		'dashicons-exerpt-view',
		'dashicons-external',
		'dashicons-facebook-alt',
		'dashicons-facebook',
		'dashicons-feedback',
		'dashicons-flag',
		'dashicons-format-aside',
		'dashicons-format-audio',
		'dashicons-format-chat',
		'dashicons-format-gallery',
		'dashicons-format-image',
		'dashicons-format-links',
		'dashicons-format-quote',
		'dashicons-format-standard',
		'dashicons-format-status',
		'dashicons-format-video',
		'dashicons-forms',
		'dashicons-googleplus',
		'dashicons-grid-view',
		'dashicons-groups',
		'dashicons-hammer',
		'dashicons-heart',
		'dashicons-id-alt',
		'dashicons-id',
		'dashicons-images-alt2',
		'dashicons-images-alt',
		'dashicons-image-crop',
		'dashicons-image-flip-horizontal',
		'dashicons-image-flip-vertical',
		'dashicons-image-rotate-left',
		'dashicons-image-rotate-right',
		'dashicons-index-card',
		'dashicons-info',
		'dashicons-leftright',
		'dashicons-lightbulb',
		'dashicons-list-view',
		'dashicons-location-alt',
		'dashicons-location',
		'dashicons-lock',
		'dashicons-marker',
		'dashicons-media-archive',
		'dashicons-media-audio',
		'dashicons-media-code',
		'dashicons-media-default',
		'dashicons-media-document',
		'dashicons-media-interactive',
		'dashicons-media-spreadsheet',
		'dashicons-media-text',
		'dashicons-media-video',
		'dashicons-megaphone',
		'dashicons-menu',
		'dashicons-microphone',
		'dashicons-migrate',
		'dashicons-minus',
		'dashicons-money',
		'dashicons-nametag',
		'dashicons-networking',
		'dashicons-no-alt',
		'dashicons-no',
		'dashicons-palmtree',
		'dashicons-performance',
		'dashicons-phone',
		'dashicons-playlist-audio',
		'dashicons-playlist-video',
		'dashicons-plus-alt',
		'dashicons-plus',
		'dashicons-portfolio',
		'dashicons-post-status',
		'dashicons-post-trash',
		'dashicons-pressthis',
		'dashicons-products',
		'dashicons-randomize',
		'dashicons-redo',
		'dashicons-rss',
		'dashicons-schedule',
		'dashicons-screenoptions',
		'dashicons-search',
		'dashicons-share1',
		'dashicons-share-alt2',
		'dashicons-share-alt',
		'dashicons-share',
		'dashicons-shield-alt',
		'dashicons-shield',
		'dashicons-slides',
		'dashicons-smartphone',
		'dashicons-smiley',
		'dashicons-sort',
		'dashicons-sos',
		'dashicons-star-empty',
		'dashicons-star-filled',
		'dashicons-star-half',
		'dashicons-store',
		'dashicons-tablet',
		'dashicons-tagcloud',
		'dashicons-tag',
		'dashicons-testimonial',
		'dashicons-text',
		'dashicons-tickets-alt',
		'dashicons-tickets',
		'dashicons-translation',
		'dashicons-trash',
		'dashicons-twitter',
		'dashicons-undo',
		'dashicons-universal-access-alt',
		'dashicons-universal-access',
		'dashicons-update',
		'dashicons-upload',
		'dashicons-vault',
		'dashicons-video-alt2',
		'dashicons-video-alt3',
		'dashicons-video-alt',
		'dashicons-visibility',
		'dashicons-welcome-add-page',
		'dashicons-welcome-comments',
		'dashicons-welcome-edit-page',
		'dashicons-welcome-learn-more',
		'dashicons-welcome-view-site',
		'dashicons-welcome-widgets-menus',
		'dashicons-welcome-write-blog',
		'dashicons-wordpress-alt',
		'dashicons-wordpress',
	);
}

function mbb_get_current_tab() {
	return filter_input( INPUT_GET, 'tab' ) ?: 'fields';
}

function mbb_is_extension_active( $extension ) {
	$functions = [
		'mb-comment-meta'            => 'mb_comment_meta_load',
		'mb-custom-table'            => 'mb_custom_table_load',
		'mb-frontend-submission'     => 'mb_frontend_submission_load',
		'mb-settings-page'           => 'mb_settings_page_load',
		'mb-term-meta'               => 'mb_term_meta_load',
		'mb-user-meta'               => 'mb_user_meta_load',
		'meta-box-columns'           => 'mb_columns_add_markup',
		'meta-box-conditional-logic' => 'mb_conditional_logic_load',
	];
	$classes = [
		'meta-box-group'           => 'RWMB_Group',
		'meta-box-include-exclude' => 'MB_Include_Exclude',
		'meta-box-show-hide'       => 'MB_Show_Hide',
		'meta-box-tabs'            => 'MB_Tabs',
	];

	if ( isset( $functions[ $extension ] ) ) {
		return function_exists( $functions[ $extension ] );
	}
	if ( isset( $classes[ $extension ] ) ) {
		return class_exists( $classes[ $extension ] );
	}
	return false;
}

function mbb_tooltip( $content ) {
	return '<button type="button" class="mbb-tooltip" data-tippy-content="' . esc_attr( $content ) . '"><span class="dashicons dashicons-editor-help"></span></button>';
}