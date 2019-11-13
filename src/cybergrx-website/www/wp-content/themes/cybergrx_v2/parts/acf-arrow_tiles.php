<section class="arrow-tiles content-section">
	<div class="row">
		<h2><?php the_sub_field('arrow_header')?></h2>
		<p class="constrain-width"><?php the_sub_field('arrow_sub_header'); ?></p>
	</div>
	<?php if(have_rows('arrow_tile')):
		$step = 0; ?>
	<ul class="tile-wrapper">
		<?php while(have_rows('arrow_tile')): the_row();
			$step++; ?>
				<li class="arrow-tile">
					<div class="tile-image"><?php echo file_get_contents( wp_get_attachment_url( get_sub_field( 'tile_image' ) ) );?></div>

					<p class="tile-text"><?php the_sub_field('tile_text'); ?></p>
					<p class="step-counter">Step <span ><?php echo $step; ?></span></p>
				</li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>

</section>
