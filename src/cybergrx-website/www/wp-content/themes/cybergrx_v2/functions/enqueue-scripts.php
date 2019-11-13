<?php
function site_scripts() {
	$ver = '20190830';

	// Adding scripts file in the footer
	wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/scripts/scripts.min.js', array( 'jquery' ), $ver, true );
	wp_enqueue_script( 'flickity-js', get_template_directory_uri() . '/assets/scripts/js/flickity.pkgd.min.js', array(), $ver, true );
	wp_enqueue_script( 'lax-js', get_template_directory_uri() . '/assets/scripts/js/lax.min.js', array(), $ver, true );

	// Register main stylesheet
	wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/styles/style.css', array(), $ver, 'all' );
	wp_enqueue_style( 'flickity-css', get_template_directory_uri() . '/assets/styles/flickity.min.css', array(), $ver, 'all' );
	// Register external stylesheets
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:200,300,400,400i,600,700,800,900');
	wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	// Comment reply script for threaded comments
	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
	  wp_enqueue_script( 'comment-reply' );
	}
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);
