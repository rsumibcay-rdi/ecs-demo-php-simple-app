<div class="content-section box-reveal">
   <div class="row">
	   <div class="constrain-width">
		   <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>
		   <?php the_sub_field('section_description'); ?>
	   </div>
	   <?php if(get_sub_field('box_rows')): ?>
	   <div class="box-rows">
		   <?php while(has_sub_field('box_rows')): ?>
			   <div class="box-row">
				   <div class="box">
					   <?php the_sub_field('box_one'); ?>
					   <div class="note"><?php the_sub_field('note_one'); ?></div>
				   </div>
				   <div class="box">
						<?php the_sub_field('box_two'); ?>
					   <div class="note"><?php the_sub_field('note_two'); ?></div>
				   </div>
			   </div>
	   <?php endwhile; endif; ?>
	   </div><!--.box-rows-->
   </div>
</div>
