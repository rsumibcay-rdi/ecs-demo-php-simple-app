<div class="content-section image-scrubber">
	<div class="row">
		<div class="constrain-width">
			<?php the_sub_field('intro_content'); ?>
		</div>
		<div class="scrubber-row show-for-medium">
			   <div class="start-block">
				 <?php $leftimgurl = get_sub_field('left_image'); ?>
				 <?php echo file_get_contents($leftimgurl); ?>
				 <h4><?php the_sub_field('left_image_label'); ?></h4>
				</div>
			   <div class="ba-slider">
				   <img src="<?php echo get_sub_field('middle_image_1'); ?>">
				   <div class="resize">
					   <img src="<?php echo get_sub_field('middle_image_2'); ?>">
				   </div>
				   <span class="handle"><span class="bar"></span></span>
				</div>
				<div class="finish-block">
					<?php //$rightimgurl = get_sub_field('right_image'); ?>
				 <?php echo file_get_contents(get_template_directory().'/assets/images/ThirdParties-01.svg'); ?>
					<h4><?php the_sub_field('right_image_label'); ?></h4>
				</div>
			</div><!--.scrubber-row-->

			<div class="scrubber-tabs hide-for-medium">
				<ul class="tabs" data-tabs id="example-tabs">
				  <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"> <?php echo file_get_contents($leftimgurl); ?></a></li>
				  <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php echo file_get_contents(get_template_directory().'/assets/images/Warehouse-01.svg'); ?></a></li>
				</ul>
				<div class="tabs-content" data-tabs-content="example-tabs">
				  <div class="tabs-panel is-active" id="panel1">
					 <img src="<?php echo get_sub_field('middle_image_1'); ?>">
				  </div>
				  <div class="tabs-panel" id="panel2">
					<img src="<?php echo get_sub_field('middle_image_2'); ?>">
				  </div>
				</div>
			</div>

	</div><!--.row-->
</div><!--.image-scrubber-->
