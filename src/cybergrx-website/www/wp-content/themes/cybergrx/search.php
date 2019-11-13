<?php
/**
 * The template for displaying search results pages
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */

get_header(); ?>

	<div class="content">

		<div class="inner-content">

			<main class="main" role="main">

				<div class="content-section has-bgimg" style="background-image: url(<?php echo home_url(); ?>/wp-content/themes/cybergrx/assets/images/CyberResourceHero.jpg);">    
                	<div class="inner-content row">
						<div class="row two-col-row">
						    <div class="columns large-6 medium-6 small-12">
						        <h2><?php _e( 'Search Results for:', 'cybergrx' ); ?></h2>
								<?php echo esc_attr(get_search_query()); ?>
						    </div>
						    <div class="columns large-6 medium-6 small-12"></div>
						</div>
					</div>
            	</div>

				<div class="search-results-row row">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<!-- To see additional archive styles, visit the /parts directory -->
					<?php get_template_part( 'parts/loop', 'search' ); ?>

				<?php endwhile; ?>

					<?php joints_page_navi(); ?>

				<?php else : ?>

					<p>No results for found for this search. Please try again.</p>

			    <?php endif; ?>
				</div>

		    </main> <!-- end #main -->


		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
