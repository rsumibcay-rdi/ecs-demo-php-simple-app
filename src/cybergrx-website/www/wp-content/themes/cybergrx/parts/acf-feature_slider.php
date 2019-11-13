<section class="feature-slider <?php if (get_sub_field('background_color')) { echo 'bg-'.get_sub_field('background_color').''; } ?>">
	<div class="row">
		<h1 class="carousel-header"><?php the_sub_field('heading'); ?></h1>
		<p class="carousel-sub-header h3"><?php the_sub_field('subheading')?></p>
	</div>
	<?php if(have_rows('slides')): ?>
	<ul class="main-carousel content-section" data-flickity='{"prevNextButtons": true, "wrapAround": true, "autoPlay": true, "pageDots": true, "bgLazyLoad": true }'>
		<?php while(have_rows('slides')): the_row(); ?>
			<li class="carousel-cell">
				<figure>
				    <img src="<?php echo get_sub_field('image')?>" alt="">
				</figure>
			</li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
</section>
