<section class="click-carousel content-section">
	<div class="row">
		<h1 class="carousel-header"><?php the_sub_field('heading'); ?></h1>
		<p class="carousel-sub-header"><?php the_sub_field('sub-heading')?></p>
	</div>
	<div class="click-carousel orbit" role="region" aria-label="" data-orbit>
		<div class="orbit-wrapper">
			<div class="orbit-controls">
				<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span></button>
				<button class="orbit-next"><span class="show-for-sr">Next Slide</span></button>
			</div>
			<?php if(have_rows('slide')): ?>
			<ul class="orbit-container">
				<?php while(have_rows('slide')): the_row(); ?>
					<li class="orbit-slide clearfix">
						<figure class="orbit-figure carousel-panel">
						<img class="orbit-image" src="<?php echo get_sub_field('slide_image')?>" alt="">
						</figure>
						<div class="slide-content carousel-panel">
							<h3 class="slide-content-title"><?php the_sub_field('slide_title')?></h3>
							<p class="slide-content-text"><?php the_sub_field('slide_content')?></p>
							<?php if (get_sub_field('button_1')): ?>
								<?php $link1 = get_sub_field('button_1')?>
								<a class="button" href="<?php echo $link1['url']; ?>"><?php echo $link1['title']; ?></a>
							<?php endif; ?>
							<?php if (get_sub_field('button_2')): ?>
								<?php $link2 = get_sub_field('button_2')?>
								<a class="button" href="<?php echo $link2['url']; ?>"><?php echo $link2['title']; ?></a>
							<?php endif; ?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
