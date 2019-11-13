<?php

// Adding WP Functions & Theme Support
function joints_theme_support() {

	// Add WP Thumbnail Support
	add_theme_support( 'post-thumbnails' );

	// Default thumbnail size
	set_post_thumbnail_size(125, 125, true);
	add_image_size( 'large-thumb', 300, 270, 'true' );

	// Add RSS Support
	add_theme_support( 'automatic-feed-links' );

	// Add Support for WP Controlled Title Tag
	add_theme_support( 'title-tag' );

	// Add HTML5 Support
	add_theme_support( 'html5',
	         array(
	         	'comment-list',
	         	'comment-form',
	         	'search-form',
	         )
	);

	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
	$GLOBALS['content_width'] = apply_filters( 'joints_theme_support', 1200 );



} /* end theme support */

add_action( 'after_setup_theme', 'joints_theme_support' );

function zen_debug($whatever){
	echo '<pre>'; var_dump($whatever); echo '</pre>';
}

//======================================================================
// Add an options page
//======================================================================
add_action('init', function () {
  if (function_exists('acf_add_options_page')) {
    $option_page = acf_add_options_page([
      'page_title'  => 'Resource Sidebar Settings',
      'menu_title'  => 'Resource Sidebar Settings',
      'menu_slug'   => 'theme-general-settings',
      'capability'  => 'edit_posts',
      'redirect'    => false
   ]);
  }
});
