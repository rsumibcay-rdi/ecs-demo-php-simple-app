<div class="content-section featured-posts">

	<div class="row">

	<h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>

   <?php
	$posts = get_sub_field('selected_posts');
	if( $posts ): ?>
		<div class="featured-row">
		<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
			<?php setup_postdata($post); ?>
			<div class="post" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>');">
				<div class="content-wrapper">
					<a href="<?php the_permalink(); ?>">
					<h3><?php the_title(); ?></h3>
					<div class="post-excerpt">
						<?php the_excerpt(); ?>
						 <?php get_template_part('parts/share', 'icons'); ?>
					</div>
					</a>

				</div><!--.content-wrapper-->

			</div><!--.post-->
		<?php endforeach; ?>
		</div><!--.featured-row-->
		<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
	<?php endif; ?>

	 </div><!--.row-->

</div><!--.content-section-->
