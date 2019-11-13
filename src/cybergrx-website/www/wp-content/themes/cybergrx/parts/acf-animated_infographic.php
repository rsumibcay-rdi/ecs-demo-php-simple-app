<div class="infographic-row content-section">
	<div class="row">
		<h2><?php the_sub_field('section_title'); ?></h2>
		<div class="infographic unanimated">
			<div class="circles">
				<div class="circle">
					<?php $circle1icon = get_sub_field('circle_1_image'); ?>
					<?php echo file_get_contents($circle1icon); ?>
					<h4><?php the_sub_field('circle_1_label'); ?></h4>
					<div class="description">
						<?php the_sub_field('circle_1_description'); ?>
					</div>
				</div>
				<div class="circle">
					<?php $circle2icon = get_sub_field('circle_2_image'); ?>
					<?php echo file_get_contents($circle2icon); ?>
					<h4><?php the_sub_field('circle_2_label'); ?></h4>
					<div class="description">
						<?php the_sub_field('circle_2_description'); ?>
					</div>
				</div>
				<div class="circle">
					  <?php $circle3icon = get_sub_field('circle_3_image'); ?>
					<?php echo file_get_contents($circle3icon); ?>
					<h4><?php the_sub_field('circle_3_label'); ?></h4>
					<div class="description">
						<?php the_sub_field('circle_3_description'); ?>
					</div>
				</div>
			</div><!--.circles-->
		</div><!--.infographic-->
	</div><!--.row-->
</div><!--.infographic-row-->
