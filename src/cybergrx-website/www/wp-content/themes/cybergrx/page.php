<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 */

get_header(); ?>

	<div class="content">

		<div class="inner-content">

			<main class="main" role="main">

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php

					if (have_rows('custom_sections')) :
						while (have_rows('custom_sections')) : the_row();
							get_template_part('parts/acf', get_row_layout());
						endwhile;
					endif;
					?>

				<?php endwhile; endif; ?>

			</main> <!-- end #main -->


		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
