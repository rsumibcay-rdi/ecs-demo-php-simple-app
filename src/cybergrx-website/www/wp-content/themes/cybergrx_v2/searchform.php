<?php
/**
 * The template for displaying search form
 */
 ?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'cybergrx' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'What are you looking for?', 'cybergrx' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'cybergrx' ) ?>" />
		<button type="submit" class="search-submit"><?php echo file_get_contents( get_stylesheet_directory_uri() . '/assets/images/icon_search.svg' ); ?></button>
</form>