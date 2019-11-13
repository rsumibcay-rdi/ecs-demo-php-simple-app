<?php
/**
 * The off-canvas menu uses the Off-Canvas Component
 *
 * For more info: http://cybergrx.com/docs/responsive-navigation/
 */
?>

<div class="top-bar" id="main-menu">
	<div class="row">
		<div class="top-bar-left">
			<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/cybergrx-logo.svg" alt="CyberGRX" class="logo" /></a>
		</div>
		<div class="title-bar" data-responsive-toggle="site-menu" data-hide-for="large">
		  <button class="menu-icon" type="button" data-toggle="site-menu"></button>

		</div>
		<div class="top-bar-right" id="site-menu">

			<div class="search-trigger show-for-large">
				<label for="trigger"><?php echo file_get_contents( get_stylesheet_directory_uri() . '/assets/images/icon_search.svg' ); ?></label><input type="checkbox" name="trigger" id="trigger" value="" /></label>
				<div class="header-search-wrapper">
					<div class="row">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>

			<div class="menu-search-form hide-for-large">
				<?php get_template_part('searchform', 'menu'); ?>
			</div>

				<?php wp_nav_menu( array('menu'  => 'Button Menu', 'theme_location' => '__no_such_location',
				'fallback_cb'    => false ) ); ?>
				<?php joints_top_nav(); ?> 
		</div>
	</div>

</div>
