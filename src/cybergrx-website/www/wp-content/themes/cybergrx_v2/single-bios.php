<?php
/**
 * The template for displaying all single bio posts
 */

get_header(); ?>

<div class="content">

	<div class="inner-content row">

		<main class="main small-12 medium-12 large-12 columns" role="main">

		    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="load-target" class="bio-detail">
					<div class="bio-content">
						<div class="row">
							<div class="columns large-3 medium-3 small-4 mini-pic">
								<?php the_post_thumbnail('large-thumb'); ?>
							</div>
							<div class="columns large-9 medium-9 small-12">
								<h3><?php the_title(); ?></h3>
								<h4><?php the_field('bio_title'); ?></h4>
								<?php the_content(); ?>
							</div>
						</div>

					</div>
				</div>

		    <?php endwhile; else : ?>

		   		<?php get_template_part( 'parts/content', 'missing' ); ?>

		    <?php endif; ?>

		</main> <!-- end #main -->

		<?php //get_sidebar(); ?>

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
