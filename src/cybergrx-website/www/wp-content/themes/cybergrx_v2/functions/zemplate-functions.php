<?php

//======================================================================
// ACF + JSON = ZOMG
//======================================================================
add_filter('acf/settings/save_json', function($path) {
	return dirname(__FILE__) . '/field-groups';
});
add_filter('acf/settings/load_json', function($paths) {
	unset($paths[0]);
	$paths[] = dirname(__FILE__) . '/field-groups';
	return $paths;
});

//======================================================================
// SVGs
//======================================================================
// Have an attachment ID that could be anything, but want to inline it if it's an SVG? No problem.
function zen_inline_if_svg( $att_id, $size = 'medium', $attr = '' ){
	if ( !$att_id ) { return ''; }

	$mime = get_post_mime_type( $att_id );
	if ($mime && $mime === 'image/svg+xml'){
		// NOTE: you are using something like this: https://wordpress.org/plugins/safe-svg/ right??
		return file_get_contents( get_attached_file( $att_id ) );
	}

	return wp_get_attachment_image( $att_id, $size, false, $attr );
}

//======================================================================
// Cache Ticker API Results
//======================================================================
function get_if_newer($name, $path){
	$value = get_transient($name);
	if (!$value){
		$remote = wp_remote_get($path);
		if (is_array($remote) && !is_wp_error($remote) && isset($remote['body']) && $remote['body']){
			$value = $remote['body'];
			set_transient($name, $value, 28800);
		}
	}
	return $value;
}

//======================================================================
// Revision Control
//======================================================================
// Maybe we don't keep _everything_ yeah?
function zen_store_fewer_revisions( $num, $post ) { return 3; }
add_filter( 'wp_revisions_to_keep', 'zen_store_fewer_revisions', 10, 2 );
