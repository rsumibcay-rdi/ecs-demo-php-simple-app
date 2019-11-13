<section class="testimonial-carousel-2 content-section">
	<div class="row">
		<?php if (get_sub_field('heading')): ?><h2 class="h1 carousel-header"><?php the_sub_field('heading'); ?></h1><?php endif; ?>
		<?php if (get_sub_field('subheading')): ?><p class="carousel-sub-header"><?php the_sub_field('sub-heading')?></p><?php endif; ?>
	</div>
	<div class="click-carousel orbit" role="region" aria-label="" data-orbit>
		<div class="orbit-wrapper">
			<div class="orbit-controls">
				<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span></button>
				<button class="orbit-next"><span class="show-for-sr">Next Slide</span></button>
			</div>
			<?php if(have_rows('slide')): ?>
			<ul class="orbit-container inner-content">
				<?php while(have_rows('slide')): the_row(); ?>
					<li class="orbit-slide">
						<p class="slide-content-text study-quote" style="color: #67686b"><?php the_sub_field('slide_content')?></p>
						<div class="attribution">
							<figure class="orbit-figure">
							<img class="orbit-image" src="<?php echo get_sub_field('slide_image')?>" alt="">
							</figure>
							<p class="slide-content-title" style="color: #67686b">&mdash; <strong><?php the_sub_field('slide_author'); ?>,&nbsp;</strong><?php the_sub_field('slide_title')?></p>
						</div>
						<?php if (get_sub_field('cta')): ?><a class="button" href="<?php echo get_sub_field('cta')['url']; ?>"><?php echo get_sub_field('cta')['title'];?></a><?php endif; ?>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
