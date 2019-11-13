<?php
/**
 * The template for displaying 404 (page not found) pages.
 *
 * For more info: https://codex.wordpress.org/Creating_an_Error_404_Page
 */

get_header(); ?>

	<div class="content">

		<div class="inner-content">

			<main class="main" role="main">

				<div class="content-section has-bgimg" style="background-image: url(<?php echo home_url(); ?>/wp-content/themes/cybergrx/assets/images/CyberResourceHero.jpg);">    
                	<div class="inner-content row">
						<div class="row two-col-row">
						    <div class="columns large-6 medium-6 small-12">
						        <h2><?php _e( 'Error 404 - Not Found', 'cybergrx' ); ?></h2>

						    </div>
						    <div class="columns large-6 medium-6 small-12"></div>
						</div>
					</div>
            	</div>

				<article class="content-not-found">


					<section class="entry-content row">
						<p><?php _e( 'The page you were looking for was not found, maybe try searching.', 'cybergrx' ); ?></p>
					</section> <!-- end article section -->

					<section class="search">
					    <p><?php get_search_form(); ?></p>
					</section> <!-- end search section -->

				</article> <!-- end article -->

			</main> <!-- end #main -->

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
