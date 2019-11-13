<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// METABOX API KEY
// fe77ed51cd7ec6f97d3b8df576e62e72

// Plugin Checker
// include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

//////////////////////////////////////////////////////////////////////
// INCLUDE Sections
//////////////////////////////////////////////////////////////////////
$dir = get_template_directory() . '/views/sections/';
$POXY_GLOBAL__SECTION__PRESET__ARRAY = array_slice(scandir($dir), 2);
foreach ($POXY_GLOBAL__SECTION__PRESET__ARRAY as $file) {
	$file_location = $dir . $file;
  require_once $file_location;
}
unset($file, $file_location);

//////////////////////////////////////////////////////////////////////
// INCLUDE Parts
//////////////////////////////////////////////////////////////////////
$dir = get_template_directory() . '/views/parts/';
$POXY_GLOBAL__PAGE__PRESET__ARRAY = array_slice(scandir($dir), 2);
foreach ($POXY_GLOBAL__PAGE__PRESET__ARRAY as $file) {
	$file_location = $dir . $file;
  require_once $file_location;
}
unset($file, $file_location);


//////////////////////////////////////////////////////////////////////
// Helpers
//////////////////////////////////////////////////////////////////////
// Admin Edit menu Button
if ( ! function_exists( 'poxy_edit' ) ) {
	function poxy_edit($id = '') {
	  global $user_ID;
	  if( $user_ID ) {
	    if( current_user_can('level_10') ) {
	      if (is_object($id)) {
	        $term_id = $id->term_id;
	        $tax = $id->taxonomy;
	        $a = '<div class="poxy__edit_term_link paxy z10">';
	        $b = '</div>';
	    		echo $a;
	        echo '<a class="term-edit-link" href="' . get_edit_term_link($term_id, $tax )  . '">Edit This</a>';
	    		echo $b;
	      } else {
	        $a = '<div class="paxy z10">';
	        $b = '</div>';
	        echo $a;
	        edit_post_link('', '', '', $id);
	        echo $b;
	      }
	    }
	  }
	}
}

if ( ! function_exists( 'poxy_id' ) ) {
	function poxy_id() {
	  global $post;
	  if(is_archive()) {
	    if(is_tax()) {
	      $id = get_queried_object();
	    } else {
	      $id = '';
	    }
	  } else {
	    if( !is_object($post) ) {
	      $id = '';
	    } else {
	      $id = get_post( $post )->ID;
	    }
	  }
	  return $id;
	}
}


if ( ! function_exists( 'poxy___button' ) ) {
	function poxy___button($part, $args=[]) {
	  $prefix = 'part__button__';
	  if (substr($part, 0, strlen($prefix)) == $prefix) {
	    $part = substr($part, strlen($prefix));
	  }
		$file =  get_template_directory() . '/views/parts/part__button__' . $part . '.php';
		if(file_exists( $file )) {

		  if(is_array($args)) {
		    extract($args);
		    call_user_func('part__button__' . $part, $args);
		  } else {
		    call_user_func('part__button__' . $part, $args);
		  }
		}
	}
}


if ( ! function_exists( 'poxy__title' ) ) {
	function poxy__title($args) {
		extract($args);
		if($title) {
			$a = '';
			$a .= '<'. $title__tag . ' class="'. $title__classes .'">';
			$a .= '<span class="' . $title_span__classes . '">';
			$a .= $title;
			$a .= '</span>';
			$a .= '</' . $title__tag . '>';
			echo $a;
		}
	}
}




require_once('_image__functions.php');
require_once('_cybergrx__landing_page__functions.php');


//////////////////////////////////////////////////////////////////////
// Scripts
//////////////////////////////////////////////////////////////////////
if ( ! function_exists( 'add_admin_scripts' ) ) {
	function add_admin_scripts( $hook ) {
	    // load script on new post page
	    // if ( $hook == 'post-new.php' ) {
	    //     wp_enqueue_script( 'group_meta_boxes', get_bloginfo('template_directory').'/assets/js/admin.js' );
	    // }
			wp_enqueue_script( 'group_meta_boxes', get_template_directory_uri() . '/views/assets/admin.js' );
			// wp_enqueue_script( 'group_meta_boxes', get_bloginfo('template_directory').'/assets/css/poxy_dashboard.css' );
	}
	add_action('admin_enqueue_scripts','add_admin_scripts',10,1);
}



// global $template;
// $t = $template;
// $t = strrchr($t,"/");
// $t = substr($t,1,strlen($t));
// $t = basename($t, ".php");
//
// if($t == 'template__cybergrx') {
// }

if ( ! function_exists( 'poxy_get___builder_scripts' ) ) {
	add_action('wp_enqueue_scripts', 'poxy_get___builder_scripts');
	function poxy_get___builder_scripts() {
		if(is_page()){
	 		global $wp_query;
		 	$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
	 		if( $template_name == 'views/template__cybergrx.php' || $template_name == 'views/template__landing_page.php' ) {
				wp_deregister_script('jquery');
				wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-2.2.4.min.js', array(), null, false);
				// wp_enqueue_script('waypoints', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js', array(), null, false);
				// wp_enqueue_script('waypoints-sticky', 'https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/shortcuts/sticky.js', array(), null, false);
				wp_enqueue_script('tweenmax','https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js', '', '', false);
				wp_enqueue_script('vimeo','https://player.vimeo.com/api/player.js', '', '', false);
				wp_enqueue_script('scripts', get_template_directory_uri() .'/views/assets/scripts.min.js', array('jquery'), '1.0', true);
				wp_enqueue_script('components', get_template_directory_uri() .'/views/assets/components.min.js', array('jquery'), '1.0', true);
				wp_enqueue_style( 'poxy_styles_custom', get_template_directory_uri() . '/style.css', false, '', '');
				wp_enqueue_style( 'poxy_styles', get_template_directory_uri() . '/views/assets/style.css', false, '', '');
				wp_enqueue_style( 'poxy_components', get_template_directory_uri() . '/views/assets/components.css', false, '', '');
	 		}
		}
	}
}


// add_action('admin_init', 'remove_admin_bar');
// function remove_admin_bar() {
// 	if(is_page()){
//  		global $wp_query;
// 	 	$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
//  		if($template_name == 'views/template__cybergrx.php') {
// 			add_filter('show_admin_bar', '__return_false');
// 			// if (!current_user_can('administrator') && !is_admin()) {
// 			//   show_admin_bar(false);
// 			// }
// 		}
// 	}
// }


// if(is_page()) {
// 	global $wp_query;
// 	$template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
// 	if($template_name == 'views/template__cybergrx.php') {
// 		add_filter('show_admin_bar', '__return_false');
// 	}
// }
