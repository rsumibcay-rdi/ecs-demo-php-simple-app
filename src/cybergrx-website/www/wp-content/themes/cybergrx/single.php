<?php
/**
 * The template for displaying all single posts and attachments
 */

get_header(); ?>

<div class="content">

	<div class="content-section has-bgimg" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_option( 'page_for_posts' ), 'large' ); ?>);">
		<div class="inner-content row">
			<div class="row two-col-row">
				<div class="columns large-6 medium-6 small-12">
					<h2 style="color: white;"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h2>
				</div>
			</div>
		</div>
	</div>

	<div class="inner-content row">

		<main class="main small-12 medium-8 large-8 columns" role="main">

		    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		    	<?php get_template_part( 'parts/loop', 'single' ); ?>

		    <?php endwhile; else : ?>

		   		<?php get_template_part( 'parts/content', 'missing' ); ?>

		    <?php endif; ?>

		</main> <!-- end #main -->
		<div class="small-12 medium-4 large-4 columns sidebar widgets">
			<?php if (have_rows('sidebar_widgets', 'option')):
				while (have_rows('sidebar_widgets', 'option')) : the_row();
					get_template_part('parts/widget', get_row_layout());
				endwhile;
			endif;
			?>
		</div>

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
