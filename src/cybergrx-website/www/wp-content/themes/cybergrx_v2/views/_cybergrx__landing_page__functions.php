<?php
////////////////////////////////////////////////////////////////////////////
// REMOVE GUTENBERG EDITOR
// https://www.billerickson.net/disabling-gutenberg-certain-templates/
////////////////////////////////////////////////////////////////////////////
/**
 * Templates and Page IDs without editor
 *
 */
function ea_disable_editor( $id = false ) {

	$excluded_templates = array(
		'views/template__cybergrx.php',
		'views/template__landing_page.php'
	);

	$excluded_ids = array(
		// get_option( 'page_on_front' )
	);

	if( empty( $id ) )
		return false;

	$id = intval( $id );
	$template = get_page_template_slug( $id );

	return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg by template
 *
 */
function ea_disable_gutenberg( $can_edit, $post_type ) {

	if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
		return $can_edit;

	if( ea_disable_editor( $_GET['post'] ) )
		$can_edit = false;

	return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

// /**
//  * Disable Classic Editor by template
//  *
//  */
// function ea_disable_classic_editor() {
//
// 	$screen = get_current_screen();
// 	if( 'page' !== $screen->id || ! isset( $_GET['post']) )
// 		return;
//
// 	if( ea_disable_editor( $_GET['post'] ) ) {
// 		remove_post_type_support( 'page', 'editor' );
// 	}
//
// }
// add_action( 'admin_head', 'ea_disable_classic_editor' );


////////////////////////////////////////////////////////////////////////////////////
// GET SECTION ARRAY
////////////////////////////////////////////////////////////////////////////////////
function poxy_get___section_array() {
	$array = [
		'section__cybergrx__hero' => 'Hero',
		'section__cybergrx__content' => 'Content',
		'section__cybergrx__cta' => 'CTA',
		'section__cybergrx__resources' => 'Resoures',
		'section__cybergrx__form' => 'Hubspot Form',
	];
	return $array;
}
// function poxy_get___section_array() {
// 	$arr = [];
// 	global $POXY_GLOBAL__SECTION__PRESET__ARRAY;
// 	foreach($POXY_GLOBAL__SECTION__PRESET__ARRAY as $option) {
// 		$selected = '';
// 		$str = basename($option, ".php");
// 		$prefix = 'section__';
// 		$preset_prefix = 'section__preset__';
// 		$value = substr($str, strlen($prefix));
// 		$value = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
// 		$select_name = $value;
// 		$select_name = str_replace("_"," ",$select_name);
// 		$select_name = ucwords($select_name);
// 		$arr[$str] = $select_name;
// 	}
// 	return $arr;
// }

function poxy_meta_form_array() {
	$array = array('form_1' => 'Form 1');
	return $array;
}

function poxy_get__theme__colors() {
	$color_array = [
		'gray' => 'Light Gray',
		'gray_dark' => 'Dark Gray',
		'blue' => 'Blue',
		'white' => 'White',
		'orange' => 'Orange',
		'navy' => 'Navy',
	];
	return $color_array;
}

function poxy_meta_item_array() {
	$array = array('item' => 'Item 1');
	return $array;
}

function poxy_get___footer__bgc() {
	return 'black';
}


function poxy_get___video_type($url) {
  if (strpos($url, 'youtube') > 0) {
      return 'youtube';
  } elseif (strpos($url, 'vimeo') > 0) {
      return 'vimeo';
  } else {
      return 'unknown';
  }
}

// add_action( 'admin_init', 'hide_editor' );
// function hide_editor() {
//   // Get the Post ID.
//   $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
//   if( !isset( $post_id ) ) return;
//   // Hide the editor on a page with a specific page template
//   // Get the name of the Page Template file.
//   $template_file = get_post_meta($post_id, '_wp_page_template', true);
//
//   if($template_file == 'views/template__cybergrx.php'){ // the filename of the page template
//     remove_post_type_support('page', 'editor');
//   }
// }

//////////////////////////////////////////
// CREATE METABOX CONTAINER
//////////////////////////////////////////
// add_filter( 'rwmb_meta_boxes', 'poxy_meta___test' );
// function poxy_meta___test( $meta_boxes ) {
// 	$mb_count = [1];
// 	foreach ($mb_count as $mb) {
// 		$prefix = 'poxy_meta___test_'.$mb.'__';
// 		$meta_boxes[] = array(
// 			'id' => $prefix,
// 			'title' => 'META TEST ' . $mb,
// 			'post_types' => array( 'page' ),
// 			'context' => 'normal',
// 			'priority' => 'high',
// 			'autosave' => true,
// 			'fields' => array(
// 				array( 'id' => "{$prefix}location", 'name' => 'TEXTAREA', 'type' => 'textarea'),
// 			)
// 		);
// 	}
// 	return $meta_boxes;
// }






////////////////////////////////////////////////////////////////////////////////////
// METABOX CONTAINER
////////////////////////////////////////////////////////////////////////////////////
// function add_admin_scripts( $hook ) {
//     // load script on new post page
//     // if ( $hook == 'post-new.php' ) {
//     //     wp_enqueue_script( 'group_meta_boxes', get_bloginfo('template_directory').'/assets/js/admin.js' );
//     // }
// 		wp_enqueue_script( 'group_meta_boxes', get_bloginfo('template_directory').'/assets/js/admin.js' );
// 		// wp_enqueue_script( 'group_meta_boxes', get_bloginfo('template_directory').'/assets/css/poxy_dashboard.css' );
// }
// add_action('admin_enqueue_scripts','add_admin_scripts',10,1);


////////////////////////////////////////////////////////////////////////////////////
// PAGE BUILDER DYNAMICALLY ADD FIELDS
////////////////////////////////////////////////////////////////////////////////////
function poxy_get_builder_sections($section__name, $section__hash='') {
	$prefix = 'poxy_meta___';
	$section__name = $section__name;
	if (substr($section__name, 0, strlen($prefix)) == $prefix) {
	  $section__name = substr($section__name, strlen($prefix));
	}
	$section_full_array = [];
	$ptypes = get_post_types();
	$args = array(
		'post_type' => array('page'),
		'posts_per_page' => -1,
		'post_status' => array('any')
	);
	$sections = new WP_Query( $args );
	while ($sections->have_posts()) {
		$sections->the_post();
		$id = poxy_id();
		$section_array = [];
		if ( metadata_exists( 'post', $id, '_poxy__builder__sections__group' ) ) {
			$meta_value = get_post_meta( $id, '_poxy__builder__sections__group', true );
			foreach($meta_value as $value) {

				// $key = key($value);
				// if( $section__name == $value[$key]) {
				// 	$section_array[] = $value[$key];
				// }

				$name = '_poxy__builder__sections__group__section';
				$hash = '_poxy__builder__sections__group__section__id';

				if($section__hash && isset($value[$hash])) {
					if($section__hash == $value[$hash]) {
						$section_array[] = $value[$name];
					}
				} else {
					if( $section__name == $value[$name]) {
						$section_array[] = $value[$name];
					}
				}




			}
			if(!empty($section_array)) {
				$section_full_array[$id] = $section_array;
			}
		}
	}
	// FULL ARRAY OF IDS THAT ARE USING THE SECTION
	// return $section_full_array;
	$id_include_array = [];
	foreach($section_full_array as $key => $val) {
		$id_include_array[] = $key;
	}
	// $id_include_array = [];
	return $id_include_array;
	// return $section_full_array;
}



////////////////////////////////////////////////////////////////////////////////////
// PAGE BUILDER GLOABL META SETTINGS
////////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_register_meta__builder__sections' );
function poxy_register_meta__builder__sections( $meta_boxes ) {

	// $current_section_array = [];
	// $section_array = [];
	// global $POXY_GLOBAL__SECTION__PRESET__ARRAY;
	//
	// foreach($POXY_GLOBAL__SECTION__PRESET__ARRAY as $option) {
	// 	$selected = '';
	// 	$str = basename($option, ".php");
	// 	$section_prefix = 'section__';
	// 	$preset_prefix = 'section__preset__';
	//
	// 	$value = substr($str, strlen($section_prefix));
	// 	$value = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
	// 	$select_name = $value;
	// 	$select_name = str_replace("_"," ",$select_name);
  //   $select_name = ucwords($select_name);
	//
	// 	$section_array[$str] = $select_name;
	// }
	//
  // $item_array = [];
	// global $POXY_GLOBAL__ITEM__PRESET__ARRAY;
	// foreach($POXY_GLOBAL__ITEM__PRESET__ARRAY as $option) {
	// 	$selected = '';
	// 	$str = basename($option, ".php");
	// 	$item_prefix = 'item__';
	// 	$preset_prefix = 'item__preset__';
	// 	$value = substr($str, strlen($item_prefix));
	// 	$value = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
	// 	$select_name = $value;
	// 	$select_name = str_replace("_"," ",$select_name);
  //   $select_name = ucwords($select_name);
	// 	$item_array[$str] = $select_name;
	// }

	$section_array = poxy_get___section_array();

	$color_array = poxy_get__theme__colors();

	$prefix = '_poxy__builder__';
	$ptypes = get_post_types();
	$meta_boxes[] = array(
		'title' => __( 'BUILDER SECTIONS', 'poxy' ),
		'post_types' => $ptypes,
		'include' => array(
			'template' => array(
				'views/template__cybergrx.php',
				'views/template__landing_page.php'
			),
		),
		'context' => 'after_editor',
		'fields' => array(
			array(
				'id' => "{$prefix}sections__group",
				// 'name' => 'Branches',
				'type'   => 'group',
				'clone'  => true,
				'sort_clone' => true,
				// 'collapsible' => true,
				'group_title' => array( 'field' => "{$prefix}sections__group__section" ),
				'fields' => array(

					array('name' => 'Template', 'id' => "{$prefix}sections__group__section", 'type' => 'select', 'options' => $section_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Section', 'columns' => 4,
						'attributes' => array(
							'disabled'  => false,
							'required'  => true,
							'readonly'  => false,
						),
					),

					array('name' => 'Menu Title', 'id' => "{$prefix}sections__group__section__title", 'type' => 'text', 'columns' => 4,
						'attributes' => array(
							'disabled'  => false,
							'required'  => true,
							'readonly'  => false,
						),
				 	),
					array('name' => 'Menu Item', 'id' => "{$prefix}sections__group__section__menu_disable", 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Hidden', 'off_label' => 'Visible', 'columns' => 4,
						// 'attributes' => array(
						// 	'disabled'  => false,
						// 	'required'  => true,
						// 	'readonly'  => false,
						// ),
				 	),

					array(
						'id' => "{$prefix}sections__group__section__id",
						'name' => 'ID',
						'type' => 'text',
						'columns' => 2,
						'attributes' => array(
					    'disabled'  => false,
					    'required'  => true,
					    'readonly'  => true,
						),
					),

				)
			)
		)
	);
	return $meta_boxes;
}






/////////////////////////////////////////////////////////////////////////////////
// POXY META HELPERS
/////////////////////////////////////////////////////////////////////////////////

function poxy_meta_prefix($function_name, $hash='') {
	$prefix = $hash ? 'poxy_meta___' . $function_name . '__' . $hash . '__' : 'poxy_meta___' . $function_name . '__';
  return $prefix;
}

function poxy_meta_title($function_name) {
  $prefix = 'poxy_meta___section__';
  $value = substr($function_name, strlen($prefix));
  $value = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
  $select_name = $value;
  $select_name = str_replace("_"," ",$select_name);
  $select_name = ucwords($select_name);

	$select_name = substr(strstr($select_name," "), 1);

  return $select_name;
}

function poxy_meta_include($function_name, $hash='') {
  $prefix = 'poxy_meta___';
	$hash = $hash ? $hash : '';
	if (substr($function_name, 0, strlen($prefix)) == $prefix) {
	    $function_name = substr($function_name, strlen($prefix));
	}
  return poxy_get_builder_sections($function_name, $hash);
}


function poxy_meta_args($function_name) {
  $args = array(
    'id' => $function_name,
    'color_array' => poxy_get__theme__colors(),
		'item_array' => [],
    'title' => poxy_meta_title($function_name),
    'prefix' => $function_name . '__',
    'post_types' => get_post_types(),
    'include' => array('ID' => poxy_meta_include($function_name) ),
  );
  return $args;
}


// NOT SURE IF THIS IS FASTEST WAY
function poxy_get___meta_section_hash($function_name) {
	$prefix = 'poxy_meta___';
	$section__name = $function_name;
	if (substr($section__name, 0, strlen($prefix)) == $prefix) {
	  $section__name = substr($section__name, strlen($prefix));
	}
	$hash_arr = [];
	$pid_arr = poxy_meta_include($function_name);
	if($pid_arr) {
		foreach ($pid_arr as $id) {
			$prefix = '_poxy__builder__sections__';
			$group = rwmb_meta("{$prefix}group", '', $id) ? rwmb_meta("{$prefix}group", '', $id) : false;
			if(!empty($group)) {
			  foreach ( $group as $v ) {
					$section = isset($v["{$prefix}group__section"]) ? $v["{$prefix}group__section"] : '';
					if($section == $section__name) {
						$hash = isset($v["{$prefix}group__section__id"]) ? $v["{$prefix}group__section__id"] : '';
				    $hash_arr[] = $hash;
					}
				}
			}
		}
	}
	return $hash_arr;
}

// NOT SURE IF THIS IS FASTEST WAY
function poxy_get___meta_section_title($function_name, $section_hash) {
	$section_title = '';
	$prefix = 'poxy_meta___';
	$section__name = $function_name;
	if (substr($section__name, 0, strlen($prefix)) == $prefix) {
	  $section__name = substr($section__name, strlen($prefix));
	}
	$hash_arr = [];
	$pid_arr = poxy_meta_include($function_name);
	if($pid_arr) {
		foreach ($pid_arr as $id) {
			$prefix = '_poxy__builder__sections__';
			$group = rwmb_meta("{$prefix}group", '', $id) ? rwmb_meta("{$prefix}group", '', $id) : false;
			if(!empty($group)) {
			  foreach ( $group as $v ) {
					$section = isset($v["{$prefix}group__section"]) ? $v["{$prefix}group__section"] : '';
					if($section == $section__name) {
						$hash = isset($v["{$prefix}group__section__id"]) ? $v["{$prefix}group__section__id"] : '';
						if($hash == $section_hash) {
							$section_title = isset($v["{$prefix}group__section__title"]) ? $v["{$prefix}group__section__title"] : '';
						}
					}
				}
			}
		}
	}
	return $section_title;
}



/////////////////////////////////////////////////////////////////////////////////
// META FIELDS - SECTION
/////////////////////////////////////////////////////////////////////////////////
function poxy_args___meta_section($function_name, $hash='') {

	$metabox_title = poxy_meta_title($function_name);
	$metabox_title = poxy_get___meta_section_title($function_name, $hash) ? poxy_get___meta_section_title($function_name, $hash) : $metabox_title;
	$hash_title = $hash ? ' - (' . $hash . ')' : '';
	$hash_prefix = $hash ? '__' . $hash : '';

	$meta = array(
		'id' => $function_name . $hash_prefix,
		// 'title' => poxy_meta_title($function_name . $hash),
		// 'title' => poxy_meta_title($function_name),
		// 'title' => $metabox_title . ' | ' . poxy_meta_title($function_name) . ' ' . $hash_title,
		'title' => $metabox_title . '  <span style="background:#888; color:#fff; text-transform:uppercase; letter-spacing:0.5px; padding: 2px 5px 2px; line-height:0; margin-left:9px; font-size:10px; border-radius: 3px;">' . poxy_meta_title($function_name) . '</span>',
		'post_types' => get_post_types(),
    'include' => array('ID' => poxy_meta_include($function_name, $hash) ),
		'tabs' => array(
				'content' => array( 'label' => 'Content', 'icon'  => '', ),
				'design' => array( 'label' => 'Design', 'icon'  => '', ),
				// 'seo' => array( 'label' => 'SEO', 'icon'  => '', ),
        ),
		'tab_style' => 'box',
		// 'tab_style' => '',
		'fields' => array()
	);
	$args = array(
		'item_array' => [],
		'color_array' => poxy_get__theme__colors(),
		'prefix' => $function_name . $hash_prefix . '__',
		'meta' => $meta,
	);
  return $args;
}


function poxy_push___meta_button( $prefix, $meta_boxes ) {

  // $meta_box_fields = $meta_boxes['fields'];
  $color_array = poxy_get__theme__colors();

  $button_meta_arr[] = array('id' => "{$prefix}section__divider", 'type' => 'divider');
  $button_meta_arr[] = array('id' => "{$prefix}button__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4 );
	$button_meta_arr[] = array('id' => "{$prefix}button__title", 'name' => __( 'Button Title:', 'poxy' ), 'type' => 'text' );
	$button_meta_arr[] = array('id' => "{$prefix}button__url", 'name' => __( 'Button URL:', 'poxy' ), 'type' => 'text' );
	$button_meta_arr[] = array('id' => "{$prefix}button__target", 'name' => __( 'Open in new tab:', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', );

	foreach($button_meta_arr as $button_meta) {
		array_push($meta_boxes['fields'], $button_meta );
  }


  return $meta_boxes;
}



function poxy_push___meta_section( $prefix, $meta_boxes, $args=[] ) {
	$metabox_general_arr = [];
	$mCount = 0;
	$color_array = poxy_get__theme__colors();

	// LOOP SECTION META FEILDS AND ADD SETTINGS
	foreach($meta_boxes['fields'] as $meta) {
		$mCount++;
		// if(!isset($meta['tab'])) {
		// 	$meta['tab'] = 'content';
		// 	array_push($metabox_general_arr, $meta);
		// }
		$meta['tab'] = 'content';
		array_push($metabox_general_arr, $meta);

		// ////////////////////////////////////////
		// AUTOMATE TEXT FIELD SETTINGS
		// ////////////////////////////////////////
		// if($meta['type'] == 'text' || $meta['type'] == 'textarea') {
		// 	$text_args = [];
		// 	$meta_prefix = $meta['id'];
		// 	$text_args[] = array('id' => "{$meta_prefix}__customize", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Customize', 'off_label' => 'Customize', 'tab' => 'general', 'columns' => 4 );
		//
		// 	$text_args[] = array('id' => "{$meta_prefix}__txc", 'name' => __( 'Color', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'tab' => 'general', 'columns' => 3,  'visible' => ["{$meta_prefix}__customize", "!=", 0] );
		// 	$text_args[] = array('id' => "{$meta_prefix}__font_size", 'name' => __( 'Font Size:', 'poxy' ),
		// 		'type' => 'slider',
		//     'prefix' => 't',
		//     'suffix' => '',
		//     'js_options' => array( 'min'   => 0, 'max'   => 10, 'step'  => 1, ),
		// 		'visible' => ["{$meta_prefix}__customize", "!=", 0],
		// 		'tab' => 'general',
		// 		'columns' => 4,
		// 	);
		//
		// 	if(!empty($text_args)) {
		// 		foreach($text_args as $text_arg) {
		// 			array_push($metabox_general_arr, $text_arg);
		// 		}
		// 	}
		// }

	}
	$meta_boxes['fields'] = $metabox_general_arr;

  // $meta_box_fields = $meta_boxes['fields'];


	$tab_array = [];
  // $tab_array = array( 'content' => array( 'label' => 'Content' ), 'section'  => array( 'label' => 'Section' ));

	// $advanced_settings[] = $tab_array

	// if(in_array('design', $args)) {
	//
	// 	$meta_boxes['tabs']['design'] = array( 'label' => 'Design', 'icon'  => '', );
	// 	// $advanced_settings[] = array('id' => "{$prefix}design__bgi", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// 	$advanced_settings[] = array('id' => "{$prefix}design__bgc", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// 	$advanced_settings[] = array('id' => "{$prefix}design__title__txc", 'name' => __( 'Title Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// 	$advanced_settings[] = array('id' => "{$prefix}design__content__txc", 'name' => __( 'Text Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	//
  // }


	if(in_array('video', $args)) {

		// $meta_boxes['tabs']['video'] = array( 'label' => 'Video', 'icon'  => '', );
		// // $tab_array['video'] = array( 'label' => 'Video test' );
		//
		// $advanced_settings[] = array('id' => "{$prefix}video__divider", 'name' => __( 'Video Settings:', 'poxy' ), 'type' => 'heading', 'tab' => 'video');
		// $advanced_settings[] = array('id' => "{$prefix}video__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enabled', 'off_label' => 'Disabled', 'tab' => 'video' );
		// $advanced_settings[] = array(
    //   'id' => "{$prefix}video__group",
    //   'type'   => 'group',
    //   'clone'  => true,
    //   'sort_clone' => true,
		// 	'visible' => ["{$prefix}video__enable", "!=", 0],
		// 	'tab' => 'video',
    //   'fields' => array(
    //     array('id' => "{$prefix}video__group__id", 'name' => __( 'Vimeo Video ID:', 'poxy' ), 'type' => 'oembed', 'columns' => 4,   )
    //   )
    // );
  }

	/////////////////////////////////
	// 	OVERLAY META SETTINGS
	/////////////////////////////////
	if(in_array('overlay', $args)) {

		$meta_boxes['tabs']['overlay'] = array( 'label' => 'Overlay', 'icon'  => '', );
		$advanced_settings[] = array('id' => "{$prefix}overlay__divider", 'name' => __( 'Overlay Settings:', 'poxy' ), 'type' => 'heading', 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disabled', 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__opacity", 'name' => __( 'Opacity:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => '%',
	    'js_options' => array(
	        'min'   => 0,
	        'max'   => 1,
	        'step'  => 0.01,
	    ),
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient__divider", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'heading', 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay');
		$advanced_settings[] = array('id' => "{$prefix}overlay__bgc__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disabled', 'tab' => 'overlay' );


		// BACKGROUND COLOR
		$advanced_settings[] = array('id' => "{$prefix}overlay__bgc", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__bgc__opacity", 'name' => __( 'Background Color Opacity:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => '%',
	    'js_options' => array(
	        'min'   => 0,
	        'max'   => 1,
	        'step'  => 0.01,
	    ),
			'columns' => 4,
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);

		// GRADIENT 1
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__divider", 'name' => __( 'Gradient 1:', 'poxy' ), 'type' => 'heading', 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay');
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disabled', 'columns' => 6, 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__color", 'name' => __( 'Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 12, 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__opacity", 'name' => __( 'Opacity:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => '%',
	    'js_options' => array(
        'min'   => 0,
        'max'   => 100,
        'step'  => 1,
	    ),
			'columns' => 4,
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__size", 'name' => __( 'Size:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => '%',
	    'js_options' => array(
        'min'   => 0,
        'max'   => 100,
        'step'  => 1,
	    ),
			'columns' => 4,
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_1__deg", 'name' => __( 'Deg:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => 'deg',
	    'js_options' => array(
        'min'   => 0,
        'max'   => 360,
        'step'  => 5,
	    ),
			'columns' => 4,
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);

		// GRADIENT 2
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_2__divider", 'name' => __( 'Gradient 2:', 'poxy' ), 'type' => 'heading', 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay');
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_2__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disabled', 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_2__color", 'name' => __( 'Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}overlay__enable", "!=", 0], 'tab' => 'overlay' );
		$advanced_settings[] = array('id' => "{$prefix}overlay__gradient_2__opacity", 'name' => __( 'Opacity:', 'poxy' ),
			'type' => 'slider',
	    'prefix' => '',
	    'suffix' => '%',
	    'js_options' => array(
	        'min'   => 0,
	        'max'   => 100,
	        'step'  => 1,
	    ),
			'columns' => 4,
			'visible' => ["{$prefix}overlay__enable", "!=", 0],
			'tab' => 'overlay'
		);

  }

	if(in_array('button', $args)) {

		$meta_boxes['tabs']['button'] = array( 'label' => 'Button', 'icon'  => '', );

		$advanced_settings[] = array('id' => "{$prefix}button__divider", 'name' => __( 'Button Settings:', 'poxy' ), 'type' => 'heading', 'tab' => 'button');
		$advanced_settings[] = array('id' => "{$prefix}button__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disabled', 'tab' => 'button' );

		// $advanced_settings[] = array('id' => "{$prefix}button__action", 'name' => 'Button Action', 'type' => 'radio', 'options' => array( 'default' => 'Default', 'lightbox' => 'Lightbox', 'custom-script' => 'Custom Script' ), 'visible' => ["{$prefix}button__enable", "!=", 0], 'tab' => 'button', 'std' => 'default' );
		$advanced_settings[] = array('id' => "{$prefix}button__action", 'name' => 'Button Action', 'type' => 'radio', 'options' => array( 'default' => 'Default', 'custom-script' => 'Custom Script' ), 'visible' => ["{$prefix}button__enable", "!=", 0], 'tab' => 'button', 'std' => 'default' );


		$advanced_settings[] = array('id' => "{$prefix}button__title", 'name' => __( 'Button Title:', 'poxy' ), 'type' => 'text', 'columns' => 4, 'visible' => [["{$prefix}button__enable", "!=", 0],["{$prefix}button__action", "=", 'default']], 'tab' => 'button'  );

		$advanced_settings[] = array('id' => "{$prefix}button__url", 'name' => __( 'Button URL:', 'poxy' ), 'type' => 'text', 'columns' => 4, 'visible' => [["{$prefix}button__enable", "!=", 0],["{$prefix}button__action", "=", 'default']], 'tab' => 'button'  );
		$advanced_settings[] = array('id' => "{$prefix}button__target", 'name' => __( 'Open in new tab:', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4, 'visible' => [["{$prefix}button__enable", "!=", 0],["{$prefix}button__action", "=", 'default']], 'tab' => 'button' );

		$advanced_settings[] = array('id' => "{$prefix}button__oembed", 'name' => __( 'Video:', 'poxy' ), 'type' => 'oembed', 'columns' => 4, 'visible' => [["{$prefix}button__enable", "!=", 0], ["{$prefix}button__action", "=", 'lightbox']], 'tab' => 'button'  );
		$advanced_settings[] = array('id' => "{$prefix}button__custom_script", 'name' => __( 'Custom Script:', 'poxy' ), 'type' => 'textarea', 'columns' => 12, 'visible' => [["{$prefix}button__enable", "!=", 0], ["{$prefix}button__action", "=", 'custom-script']], 'tab' => 'button'  );

		// $advanced_settings[] = array('id' => "{$prefix}button__advanced_settings", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Advanced Settings', 'off_label' => 'Advanced Settings', 'visible' => ["{$prefix}button__enable", "!=", 0], 'tab' => 'button' );
		$advanced_settings[] = array('id' => "{$prefix}button__bgc", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );
		// $advanced_settings[] = array('id' => "{$prefix}button__bgc__hover", 'name' => __( 'Background Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );
		// $advanced_settings[] = array('id' => "{$prefix}button__boc", 'name' => __( 'Border Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );
		// $advanced_settings[] = array('id' => "{$prefix}button__boc__hover", 'name' => __( 'Border Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );
		// $advanced_settings[] = array('id' => "{$prefix}button__txc", 'name' => __( 'Text Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );
		// $advanced_settings[] = array('id' => "{$prefix}button__txc__hover", 'name' => __( 'Text Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], 'tab' => 'button' );

  }




	$meta_boxes['tabs']['design'] = array( 'label' => 'Design', 'icon'  => '', );
  // $advanced_settings[] = array('id' => "{$prefix}section__divider", 'type' => 'divider');

	// $advanced_settings[] = array('id' => "{$prefix}section__divider", 'name' => __( 'Advanced Section Settings:', 'poxy' ), 'type' => 'heading', 'tab' => 'advanced');

  // $advanced_settings[] = array('id' => "{$prefix}settings", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Hide', 'off_label' => 'Show', 'columns' => 3, 'tab' => 'advanced' );
  // $advanced_settings[] = array('id' => "{$prefix}advanced_settings__enabled", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4, 'tab' => 'design' );

  $advanced_settings[] = array('id' => "{$prefix}section__divider_2", 'name' => 'Section Design', 'type' => 'heading', 'tab' => 'design');
  $advanced_settings[] = array('id' => "{$prefix}section__bgc", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
  $advanced_settings[] = array('id' => "{$prefix}section__bgi", 'name' => __( 'Background Image:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'image_advanced', 'columns' => 4, 'tab' => 'design');

	if(in_array('video', $args)) {
		$advanced_settings[] = array('id' => "{$prefix}video__divider", 'name' => __( 'Video Settings:', 'poxy' ), 'type' => 'heading', 'tab' => 'design');
		$advanced_settings[] = array('id' => "{$prefix}video__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enabled', 'off_label' => 'Disabled', 'tab' => 'design' );
		$advanced_settings[] = array(
			'id' => "{$prefix}video__group",
			'type'   => 'group',
			'clone'  => true,
			'sort_clone' => true,
			'visible' => ["{$prefix}video__enable", "!=", 0],
			'tab' => 'design',
			'fields' => array(
				array('id' => "{$prefix}video__group__id", 'name' => __( 'Vimeo Video ID:', 'poxy' ), 'type' => 'oembed', 'columns' => 4,   )
			)
		);
	}

	$advanced_settings[] = array('id' => "{$prefix}section__text__divider", 'name' => 'Text Design', 'type' => 'heading', 'tab' => 'design');
	$advanced_settings[] = array('id' => "{$prefix}title__txc", 'name' => __( 'Title Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// $advanced_settings[] = array('id' => "{$prefix}sub_title__txc", 'name' => __( 'Sub Title Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	$advanced_settings[] = array('id' => "{$prefix}content__txc", 'name' => __( 'Content Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );

  // $advanced_settings[] = array('id' => "{$prefix}section__heading__divider", 'type' => 'divider', 'tab' => 'design');
  // $advanced_settings[] = array('id' => "{$prefix}section__heading__txc", 'name' => __( 'Heading Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// $advanced_settings[] = array('id' => "{$prefix}section__content__txc", 'name' => __( 'Heading Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'placeholder' => 'Select a Color', 'columns' => 4, 'tab' => 'design' );
	// // $advanced_settings[] = array('id' => "{$prefix}section__heading__txc", 'name' => __( 'Heading Size:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );



	// $meta_boxes['tabs']['seo'] = array( 'label' => 'SEO', 'icon'  => '', );


	foreach($advanced_settings as $advanced_setting) {
		array_push($meta_boxes['fields'], $advanced_setting );
  }

	if(!empty($tab_array)) {
		foreach($tab_array as $tab) {
			if(isset($meta_boxes['tabs'])) {
				array_push($meta_boxes['tabs'], $tab );
			}
	  }
	}

  // $meta_boxes['fields'] = $advanced_settings;
  //- $meta_boxes['tabs'] = $tab_array;

  return $meta_boxes;
}





function poxy_args___section($function_name, $args) {

	$id = is_array($args) ? $args['id'] : $args;

	$hash = is_array($args) ? $args['hash'] : '';

  // $id = ( poxy_get_page_type() == 'home' ) ? get_option( 'page_for_posts' ) : $id;
	// if (!is_tax()) {
	//   $id = poxy_id();
	//   $title_1 = rwmb_meta("{$prefix}title_1", '', $id) ? rwmb_meta("{$prefix}title_1", '', $id) : get_the_title($id);
	//   $content = rwmb_meta("{$prefix}content", '', $id) ? rwmb_meta("{$prefix}content", '', $id) : get_the_content($id);
	//   $content = wpautop($content);
  // } else {
	//   $id = get_queried_object()->term_id;
	//   $content = get_queried_object()->description;
  // }

  // $id = $id ? $id : poxy_id();
  $prefix = poxy_meta_prefix($function_name, $hash);
	$section__hash = $hash ? $hash : '';
	$featured_image = get_post_thumbnail_id($id);
	$custom_meta = '';
  $section__id = $function_name;
  $section__bgi = '';
	$section__bgc = '';
  $section__heading__txc = '';
  $section__classes = '';
  $section__heading__classes = '';

  // $advanced_settings__enabled = rwmb_meta("{$prefix}advanced_settings__enabled", '', $id) ? 'bgc__'.rwmb_meta("{$prefix}advanced_settings__enabled", '', $id) : false;
	//
  // if($advanced_settings__enabled) {
  //   $section__bgc = rwmb_meta("{$prefix}section__bgc", '', $id) ? 'bgc__'.rwmb_meta("{$prefix}section__bgc", '', $id) : '';
  //   $section__bgi = rwmb_meta("{$prefix}section__bgi", '', $id) ? rwmb_meta("{$prefix}section__bgi", '', $id) : '';
  //   $section__heading__txc = rwmb_meta("{$prefix}section__heading__txc", '', $id) ? 'txc__'.rwmb_meta("{$prefix}section__heading__txc", '', $id) : '';
	//
  //   $section__classes[] = $section__bgc;
  //   $section__heading__classes[] = $section__heading__txc;
	//
  //   $section__classes = implode(' ', $section__classes);
  //   $section__heading__classes = implode(' ', $section__heading__classes);
  // }

	// $section__bgc = rwmb_meta("{$prefix}section__bgc", '', $id) ? 'bgc__' . rwmb_meta("{$prefix}section__bgc", '', $id) : '';
	$section__bgc = rwmb_meta("{$prefix}section__bgc", '', $id) ? rwmb_meta("{$prefix}section__bgc", '', $id) : '';
	$section__bgi = rwmb_meta("{$prefix}section__bgi", '', $id) ? rwmb_meta("{$prefix}section__bgi", '', $id) : '';
	$section__heading__txc = rwmb_meta("{$prefix}section__heading__txc", '', $id) ? 'txc__'.rwmb_meta("{$prefix}section__heading__txc", '', $id) : '';

	// $section__classes = [];
	// $section__classes[] = $section__bgc;
	//
	// $section__heading__classes[] = $section__heading__txc;
	//
	// $section__classes = implode(' ', $section__classes);
	// $section__heading__classes = implode(' ', $section__heading__classes);

	// CUSTOM META VARS
	$custom_meta = [];
	if (function_exists('poxy_meta___' . $function_name)) {
		if($hash) {

			$fields = call_user_func('poxy_meta___' . $function_name, ['hash' => $hash] );

			$fields = $fields[0]['fields'];

			// $custom_meta = $fields;

			foreach($fields as $field) {
				$key = str_replace($prefix, '', $field['id']);
				// if($field['id'] contains 'oembed') {
				if ((strpos($field['id'], 'oembed') !== false || strpos($field['id'], 'video') !== false)) {
					$value = rwmb_get_value($field['id'], '', $id) ? rwmb_get_value($field['id'], '', $id) : '';
				} else {
					$value = rwmb_meta($field['id'], '', $id) ? rwmb_meta($field['id'], '', $id) : '';
				}
				$custom_meta[$key] = $value;
			}

		} else {

			$fields = call_user_func('poxy_meta___' . $function_name, [] );
			$fields = $fields[0]['fields'];

			// $custom_meta = $fields;

			foreach($fields as $field) {
				$key = str_replace($prefix, '', $field['id']);
				// if($field['id'] contains 'oembed') {
				if ((strpos($field['id'], 'oembed') !== false || strpos($field['id'], 'video') !== false)) {
					$value = rwmb_get_value($field['id'], '', $id) ? rwmb_get_value($field['id'], '', $id) : '';
				} else {
					$value = rwmb_meta($field['id'], '', $id) ? rwmb_meta($field['id'], '', $id) : '';
				}
				$custom_meta[$key] = $value;
			}
		}
	}



	// GRADIENT SETTINGS
	$overlay__args = [];
	$overlay__styles = '';
	if(isset($custom_meta['overlay__enable'])) {
		$overlay__gradient_1__color = isset($custom_meta['overlay__gradient_1__color']) && $custom_meta['overlay__gradient_1__color'] ? $custom_meta['overlay__gradient_1__color'] : '';
		if($overlay__gradient_1__color) {
			$overlay__opacity = $custom_meta['overlay__opacity'] ? $custom_meta['overlay__opacity'] : 1;

			$overlay__gradient_1__color = $overlay__gradient_1__color ? poxy___color2hex($overlay__gradient_1__color) : '#000000';
			$overlay__gradient_1__color = $overlay__gradient_1__color ? poxy___hex2rgb($overlay__gradient_1__color) : poxy___hex2rgb('#90829E');
			$overlay__gradient_1__color = implode( ", ", $overlay__gradient_1__color );
			$overlay__gradient_1__size = $custom_meta['overlay__gradient_1__size'] ? $custom_meta['overlay__gradient_1__size'] . '%' : '0%';
			// $overlay__gradient_1__size = '50%';
			$overlay__gradient_1__deg = $custom_meta['overlay__gradient_1__deg'] ? $custom_meta['overlay__gradient_1__deg'] . 'deg' : '0deg';
			$overlay__gradient_1__opacity = $custom_meta['overlay__gradient_1__opacity'] ? ($custom_meta['overlay__gradient_1__opacity'] / 100) : 1;

			$overlay__bgc__opacity = $custom_meta['overlay__bgc__opacity'] ? $custom_meta['overlay__bgc__opacity'] : 0.5;
			$overlay__bgc = $custom_meta['overlay__bgc'] ? $custom_meta['overlay__bgc'] : 'black';
			$overlay__bgc = $overlay__bgc ? poxy___color2hex($overlay__bgc) : '#000000';
			$overlay__bgc = poxy___hex2rgb($overlay__bgc);
			$overlay__bgc = implode( ", ", $overlay__bgc );


			$overlay__styles = '';
			$overlay__styles .= 'opacity:'. $overlay__opacity .';';
			if($custom_meta['overlay__bgc__enable']) {
				$overlay__styles .= 'background-color: rgba(' . $overlay__bgc . ', '.$overlay__bgc__opacity.');';
			}
			if($custom_meta['overlay__gradient_1__enable']) {
			  // $overlay__styles .= 'background-image: -webkit-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', 0), rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.' ) '.$overlay__gradient_1__size.');';
			  // $overlay__styles .= 'background-image: -moz-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', 0), rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.');';
			  // $overlay__styles .= 'background-image: -o-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', 0), rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.');';
			  // $overlay__styles .= 'background-image: -ms-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', 0), rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.');';
			  // $overlay__styles .= 'background-image: linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', 0), rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.');';

				$overlay__styles .= 'background-image: -webkit-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.' ) '.$overlay__gradient_1__size.', rgba(' . $overlay__gradient_1__color . ', 0));';
			  $overlay__styles .= 'background-image: -moz-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.', rgba(' . $overlay__gradient_1__color . ', 0));';
			  $overlay__styles .= 'background-image: -o-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.', rgba(' . $overlay__gradient_1__color . ', 0));';
			  $overlay__styles .= 'background-image: -ms-linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.'), '.$overlay__gradient_1__size.', rgba(' . $overlay__gradient_1__color . ', 0));';
			  $overlay__styles .= 'background-image: linear-gradient('.$overlay__gradient_1__deg.', rgba(' . $overlay__gradient_1__color . ', '.$overlay__gradient_1__opacity.') '.$overlay__gradient_1__size.', rgba(' . $overlay__gradient_1__color . ', 0));';

			}
		}
		$overlay__args = [
			'overlay__enable' => $custom_meta['overlay__enable'],
			// 'overlay__bgc__enable'
			// 'overlay__bgc'
			// 'overlay__opacity'
			// 'overlay__gradient_1__enable'
			// 'overlay__gradient_1__opacity'
			// 'overlay__gradient_1__size'
			// 'overlay__gradient_1__deg'
			// 'overlay__deg' =>
			'overlay__styles' => $overlay__styles
		];
	}



	$button__args = [];
	$button__template = isset($button__template) && $button__template ? $button__template : '';
	$button__action = isset($button__action) && $button__action  ? $button__action : '';
	$button__oembed = isset($button__oembed) && $button__oembed  ? $button__oembed : '';
	$button__target = isset($button__target) && $button__target  ? $button__target : '';
	$button__title = isset($button__title) && $button__title  ? $button__title : '';
	$button__url = isset($button__url) && $button__url  ? $button__url : '';
	$button__txc = isset($button__txc) && $button__txc  ? $button__txc : '';
	$button__txc__hover = isset($button__txc__hover) && $button__txc__hover  ? $button__txc__hover : '';
	$button__boc = isset($button__boc) && $button__boc  ? $button__boc : '';
	$button__boc__hover = isset($button__boc__hover) && $button__boc__hover ? $button__boc__hover : '';
	$button__bgc = isset($button__bgc) && $button__bgc ? $button__bgc : '';
	$button__bgc__hover = isset($button__bgc__hover) && $button__bgc__hover ? $button__bgc__hover : '';
	$video_url = $button__oembed;



	$bgc = rwmb_meta("{$prefix}bgc", '', $id) ? 'bgc__'.rwmb_meta("{$prefix}bgc", '', $id) : '';
	$bgi = rwmb_meta("{$prefix}bgi", '', $id) ? rwmb_meta("{$prefix}bgi", '', $id) : '';
	$bgi = (isset($bgi) && is_array($bgi)) ? key($bgi) : '';
	$bgi_url = $bgi ? wp_get_attachment_image_src($bgi, 'full')[0] : '';

	$image = (isset($image) && is_array($image)) ? key($image) : '';
	$image_url = $image ? wp_get_attachment_image_src($image, 'full')[0] : '';

	// $title__txc = ($bgc == 'bgc__blue' || $bgc == 'bgc__orange') ? 'txc__white' : 'txc__blue';
	// $content__txc = ($bgc == 'bgc__blue' || $bgc == 'bgc__orange') ? 'txc__white' : 'txc__gray_dark';

	$sw_classes = [];
	$sw_classes[] = $bgc;
	$sw_classes = implode(' ', $sw_classes);

	$sw_styles = [];
	if($bgi_url) {
		$sw_styles[] = 'background-image: url('. $bgi_url .');';
		$sw_styles[] = 'background-size: cover;';
		$sw_styles[] = 'background-position: center center;';
	}
	$sw_styles = implode(' ', $sw_styles);

	$title_classes = [];
	$title_classes[] = rwmb_meta("{$prefix}title__txc", '', $id) ? 'txc__'.rwmb_meta("{$prefix}title__txc", '', $id) : '';
	$title_classes = implode(' ', $title_classes);

	$content_classes = [];
	$content_classes[] = rwmb_meta("{$prefix}content__txc", '', $id) ? 'txc__'.rwmb_meta("{$prefix}content__txc", '', $id) : '';
	$content_classes = implode(' ', $content_classes);


	///////////////////////////////////////////////////////
	// BUILD OUT MASTER DATA ARRAY
	///////////////////////////////////////////////////////
	$button__args = [
		'action' => $button__action,
		'oembed' => $button__oembed,
		'template' => $button__template,
		'txc' => $button__txc,
		'boc' => $button__boc,
		'bgc' => $button__bgc,
		'title' => $button__title,
		'permalink' => $button__url,
		'target' => $button__target
	];

  $global_args = array(
    'id' => $id,
    'prefix' => $prefix,
		'featured_image' => $featured_image,
		'section__id' => $section__id,
		'section__hash' => $section__hash,
    'section__bgi' => $section__bgi,
		'section__bgc' => $section__bgc,
    'section__classes' => $section__classes,
    'section__heading__classes' => $section__heading__classes,
    'section__heading__txc' => $section__heading__txc,
		'sw_styles' => $sw_styles,
		'sw_classes' => $sw_classes,
		'button__args' => $button__args,
		'overlay__args' => $overlay__args,
		'title_classes' => $title_classes,
		'content_classes' => $content_classes,
  );

	$args = array_merge($global_args, $custom_meta);

  return $args;
}













// function poxy_add__metabox__advanced_settings( $prefix, $meta_boxes ) {
//
//   $color_array = poxy_get__theme__colors();
//   $tab_array = array( 'content' => array( 'label' => 'Content' ), 'section'  => array( 'label' => 'Section' ));
//
//   $advanced_settings = [];
//   $advanced_settings[] = array('id' => "{$prefix}section__divider", 'type' => 'divider');
//
//   $advanced_settings[] = array('id' => "{$prefix}settings", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Advanced Settings', 'off_label' => 'Advanced Settings', 'columns' => 3 );
//   $advanced_settings[] = array('id' => "{$prefix}advanced_settings__enabled", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4 );
//
//   $advanced_settings[] = array('id' => "{$prefix}section__divider_2", 'type' => 'divider', 'visible' => ["{$prefix}settings", "!=", 0]);
//   $advanced_settings[] = array('id' => "{$prefix}section__bgc", 'name' => __( 'Section BGC:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
//   $advanced_settings[] = array('id' => "{$prefix}section__bgi", 'name' => __( 'Section BGI:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'image_advanced', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4);
//   $advanced_settings[] = array('id' => "{$prefix}section__heading__divider", 'type' => 'divider', 'visible' => ["{$prefix}settings", "!=", 0]);
//   $advanced_settings[] = array('id' => "{$prefix}section__heading__txc", 'name' => __( 'Heading TXC:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
//
//   foreach($advanced_settings as $advanced_setting) {
//     $meta_box_fields[] = $advanced_setting;
//   }
//
//   $meta_boxes['fields'] = $meta_box_fields;
//   //- $meta_boxes['tabs'] = $tab_array;
//
//   return $meta_boxes;
// }



//////////////////////////////////
// SECTION - META GLOBAL ARGS
//////////////////////////////////
// function poxy_meta_section_args($funtion_name, $args = '') {
//   $id = ( poxy_get_page_type() == 'home' ) ? get_option( 'page_for_posts' ) : poxy_id();
//   $prefix = poxy_meta_prefix($funtion_name);
//
//   $args = array(
//     'id' => $id,
//     'prefix' => $prefix,
//   );
//   return $args;
//
// }
// function poxy_get__metabox__advanced_settings($function_name, $args = '') {
//   $id = $args;
//
//   $id = ( poxy_get_page_type() == 'home' ) ? get_option( 'page_for_posts' ) : $id;
//   $id = $id ? $id : poxy_id();
//   $prefix = poxy_meta_prefix($function_name);
//   $section__id = $function_name;
//   $section__bgi = '';
//   $section__heading__txc = '';
//   $section__classes = [];
//   $section__heading__classes = [];
//
//   $advanced_settings__enabled = rwmb_meta("{$prefix}advanced_settings__enabled", '', $id) ? 'bgc__'.rwmb_meta("{$prefix}advanced_settings__enabled", '', $id) : false;
//
//   if($advanced_settings__enabled) {
//     $section__bgc = rwmb_meta("{$prefix}section__bgc", '', $id) ? 'bgc__'.rwmb_meta("{$prefix}section__bgc", '', $id) : '';
//     $section__bgi = rwmb_meta("{$prefix}section__bgi", '', $id) ? rwmb_meta("{$prefix}section__bgi", '', $id) : '';
//     $section__heading__txc = rwmb_meta("{$prefix}section__heading__txc", '', $id) ? 'txc__'.rwmb_meta("{$prefix}section__heading__txc", '', $id) : '';
//
//     $section__classes[] = $section__bgc;
//     $section__heading__classes[] = $section__heading__txc;
//
//
//     $section__classes = implode(' ', $section__classes);
//     $section__heading__classes = implode(' ', $section__heading__classes);
//   }
//
// 	// // CUSTOM META VARS
// 	// $custom_meta = [];
// 	// $fields = call_user_func('poxy_meta___' . $function_name );
// 	// $fields = $fields['fields'];
// 	//
// 	// foreach($fields as $field) {
// 	// 	$key = str_replace($prefix, '', $field['id']);
// 	// 	$value = isset($v[$field['id']]) ? $v[$field['id']] : '';
// 	// 	$custom_meta[$key] = $value;
// 	// }
//
//   $global_args = array(
//     'id' => $id,
//     'section__id' => $section__id,
// 		'section__hash' => $section__hash,
//     'prefix' => $prefix,
//     'section__bgi' => $section__bgi,
//     'section__classes' => $section__classes,
//     'section__heading__classes' => $section__heading__classes,
//     'section__heading__txc' => $section__heading__txc
//   );
//
// 	// $args = array_merge($global_args, $custom_meta);
// 	$args = $global_args;
//
//   return $args;
//
// }





/////////////////////////////////////////////////////////////////////////////////
// META FIELDS - ADVANCED SETTINGS
/////////////////////////////////////////////////////////////////////////////////

// function poxy_meta__merge_fields( $meta_boxes ) {
//   $field_array = [];
//   $meta_box_fields = $meta_boxes['fields'];
//
//   // $id = poxy_id();
//   // $id = 3063;
//   $id = $_GET['post'];
//   $prefix = '_poxy__builder__sections__';
//   $group = rwmb_meta("{$prefix}group", '', $id) ? rwmb_meta("{$prefix}group", '', $id) : false;
//   if(!empty($group)) {
//     foreach ( $group as $v ) {
//       $section = isset($v["{$prefix}group__section"]) ? $v["{$prefix}group__section"] : false;
//       $section_meta_fields = call_user_func('poxy_meta___' . $section, array())[0]['fields'];
//
//       $meta_box_fields[] = array('id' => $section . "__section__divider", 'type' => 'heading', 'name' => $section );
//       foreach ( $section_meta_fields as $section_meta_field ) {
//         $meta_box_fields[] = $section_meta_field;
//       }
//     }
//   }
//
//   // foreach($advanced_settings as $advanced_setting) {
//   //   $meta_box_fields[] = $advanced_setting;
//   // }
//   //
//
//   $meta_boxes['fields'] = $meta_box_fields;
//
//   return $meta_boxes;
// }









/////////////////////////////////////////////////////////////////////////////////
// META FIELDS - ITEM
/////////////////////////////////////////////////////////////////////////////////
function poxy_args___meta_item__post_types($item__name) {
	$prefix = 'poxy_meta___';
	$section__name = $item__name;
	if (substr($section__name, 0, strlen($prefix)) == $prefix) {
	  $section__name = substr($section__name, strlen($prefix));
	}
	$section_full_array = [];
	$args = array(
		'post_type' => array('page'),
		'posts_per_page' => -1
	);
	$sections = new WP_Query( $args );
	while ($sections->have_posts()) {
		$sections->the_post();
		$id = poxy_id();
		$section_array = [];

		if ( metadata_exists( 'post', $id, '_poxy__builder__sections__group' ) ) {

			$meta_value = get_post_meta( $id, '_poxy__builder__sections__group', true );


			foreach($meta_value as $value) {
				$key = key($value);
				$loop_section = 'section__condit__ajax_filter_pager';
				if( $loop_section == $value[$key]) {
					// $section_full_array[$id] = $value[$key];
					// $section_full_array[$id] = get_post_meta($id, '', false);

					$pcount = 0; $page_meta = get_post_meta($id, '', false);
					foreach($page_meta as $m) {
						//$pcount
						$section_full_array = $m;
					}
				}
			}

			//
			// if(!empty($section_array)) {
			// 	$section_full_array[$id] = $section_array;
			// }


		}
	}

	// FULL ARRAY OF IDS THAT ARE USING THE SECTION
	// return $section_full_array;
	$id_include_array = [];
	foreach($section_full_array as $key => $val) {
		$id_include_array[] = $key;
	}
	// $id_include_array = [];
	return $section_full_array;
}


// function poxy_args___meta_item__post_types($function_name) {
// 	$prefix = 'poxy_meta___';
// 	if (substr($function_name, 0, strlen($prefix)) == $prefix) {
// 	    $function_name = substr($function_name, strlen($prefix));
// 	}
//   return poxy_get_builder_sections($function_name);
//
// 	return array('work');
// }

function poxy_args___meta_item($function_name) {
	$meta = array(
		'id' => $function_name,
		'title' => poxy_meta_title($function_name),
		// 'post_types' => get_post_types(),
		'post_types' => array('work'),
		// 'post_types' => poxy_args___meta_item__post_types($function_name),
    // 'include' => array(),
		'fields' => array()
	);
	$args = array(
		// 'settings' => [],
		'color_array' => poxy_get__theme__colors(),
		'prefix' => $function_name . '__',
		'form_array' => poxy_meta_form_array(),
		'item_array' => poxy_meta_item_array(),
		'meta' => $meta,
	);
  return $args;
}



// function poxy_push___meta_item( $prefix, $meta_boxes, $args=[] ) {
//
//   // $meta_box_fields = $meta_boxes['fields'];
//   $color_array = poxy_get__theme__colors();
//
//   $tab_array = array( 'content' => array( 'label' => 'Content' ), 'section'  => array( 'label' => 'Section' ));
//
//
// 	if(in_array('button', $args)) {
// 		$advanced_settings[] = array('id' => "{$prefix}button__divider", 'name' => __( 'Button Settings:', 'poxy' ), 'type' => 'heading');
// 		$advanced_settings[] = array('id' => "{$prefix}button__enable", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', );
// 		$advanced_settings[] = array('id' => "{$prefix}button__title", 'name' => __( 'Button Title:', 'poxy' ), 'type' => 'text', 'columns' => 4  );
// 		$advanced_settings[] = array('id' => "{$prefix}button__url", 'name' => __( 'Button URL:', 'poxy' ), 'type' => 'text', 'columns' => 4  );
// 		$advanced_settings[] = array('id' => "{$prefix}button__target", 'name' => __( 'Open in new tab:', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4  );
//
// 		$advanced_settings[] = array('id' => "{$prefix}button__advanced_settings", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Advanced Settings', 'off_label' => 'Advanced Settings' );
// 		$advanced_settings[] = array('id' => "{$prefix}button__bgc", 'name' => __( 'Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
// 		$advanced_settings[] = array('id' => "{$prefix}button__bgc__hover", 'name' => __( 'Background Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
// 		$advanced_settings[] = array('id' => "{$prefix}button__boc", 'name' => __( 'Border Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
// 		$advanced_settings[] = array('id' => "{$prefix}button__boc__hover", 'name' => __( 'Border Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
// 		$advanced_settings[] = array('id' => "{$prefix}button__txc", 'name' => __( 'Text Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
// 		$advanced_settings[] = array('id' => "{$prefix}button__txc__hover", 'name' => __( 'Text Color Hover:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'columns' => 4, 'visible' => ["{$prefix}button__advanced_settings", "!=", 0], );
//   }
//
//   // $advanced_settings[] = array('id' => "{$prefix}section__divider", 'type' => 'divider');
//
// 	$advanced_settings[] = array('id' => "{$prefix}section__divider", 'name' => __( 'Advanced Section Settings:', 'poxy' ), 'type' => 'heading');
//
//   $advanced_settings[] = array('id' => "{$prefix}settings", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Hide', 'off_label' => 'Show', 'columns' => 3 );
//   $advanced_settings[] = array('id' => "{$prefix}advanced_settings__enabled", 'name' => __( '', 'poxy' ), 'type' => 'switch', 'style' => 'square', 'on_label'  => 'Enable', 'off_label' => 'Disable', 'columns' => 4 );
//
//   $advanced_settings[] = array('id' => "{$prefix}section__divider_2", 'type' => 'divider', 'visible' => ["{$prefix}settings", "!=", 0]);
//   $advanced_settings[] = array('id' => "{$prefix}section__bgc", 'name' => __( 'Section Background Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
//   $advanced_settings[] = array('id' => "{$prefix}section__bgi", 'name' => __( 'Section Background Image:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'image_advanced', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4);
//   $advanced_settings[] = array('id' => "{$prefix}section__heading__divider", 'type' => 'divider', 'visible' => ["{$prefix}settings", "!=", 0]);
//   $advanced_settings[] = array('id' => "{$prefix}section__heading__txc", 'name' => __( 'Heading Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
// 	$advanced_settings[] = array('id' => "{$prefix}section__content__txc", 'name' => __( 'Heading Color:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
// 	// $advanced_settings[] = array('id' => "{$prefix}section__heading__txc", 'name' => __( 'Heading Size:', 'poxy' ), 'type' => 'select', 'options' => $color_array, 'multiple' => false, 'std' => '', 'placeholder' => 'Select a Color', 'visible' => ["{$prefix}settings", "!=", 0], 'columns' => 4 );
//
// 	foreach($advanced_settings as $advanced_setting) {
// 		array_push($meta_boxes['fields'], $advanced_setting );
//   }
//
//   // $meta_boxes['fields'] = $advanced_settings;
//   //- $meta_boxes['tabs'] = $tab_array;
//
//   return $meta_boxes;
// }


function poxy_args___item($function_name, $args='') {

	if(is_array($args)) {
		extract($args);
	} else {
		$id = $args;
	}

	$c = isset($c) ? $c : '';
	$count = isset($count) ? $count : '';
	$permalink = isset($permalink) ? $permalink : '';
	$custom_meta = [];

  $id = isset($id) ? $id : poxy_id();
	$post_type = isset($post_type) ? $post_type : get_post_type($id);

	// $featured_image = get_the_post_thumbnail($id, 'medium');
	// $featured_image__medium = get_the_post_thumbnail($id, 'medium');
	// $featured_image__large = get_the_post_thumbnail($id, 'large');

	$featured_image = get_post_thumbnail_id($id);

  $prefix = poxy_meta_prefix($function_name);

  $item__id = $function_name;
  $item__classes = isset($item__classes) ? $item__classes : '';
	// $item__classes = $function_name . ' ' . $item__classes;

	if (function_exists('poxy_meta___' . $function_name)) {
		// CUSTOM META VARS
		$fields = call_user_func('poxy_meta___' . $function_name, [] );
		$fields = $fields[0]['fields'];

		// $custom_meta = $fields;
		foreach($fields as $field) {
			$key = str_replace($prefix, '', $field['id']);
			$value = rwmb_meta($field['id'], '', $id) ? rwmb_meta($field['id'], '', $id) : '';
			$custom_meta[$key] = $value;
		}
	}

  $global_args = array(
    'id' => $id,
		'c' => $c,
		'img' => $featured_image,
		'count' => $count,
    'prefix' => $prefix,
		'item__id' => $item__id,
    'item__classes' => $item__classes,
		'permalink' => $permalink,
		'featured_image' => $featured_image,
		'post_type' => $post_type,

		// 'featured_image__large' => $featured_image__large,
		// 'featured_image__medium' => $featured_image__medium,

  );

	$args = array_merge($global_args, $custom_meta);

  return $args;

}
