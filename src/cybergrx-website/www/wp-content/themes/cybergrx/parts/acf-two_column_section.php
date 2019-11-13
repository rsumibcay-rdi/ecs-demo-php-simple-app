<div class="content-section two-col <?php if(get_sub_field('background_video')) { echo 'has-video'; } elseif(get_sub_field('background_image')) { echo 'has-bgimg'; } elseif (get_sub_field('background_color')) { echo 'bg-'.get_sub_field('background_color').''; } ?>" <?php if(get_sub_field('background_image')) { echo 'style="background-image: url('.get_sub_field('background_image').');"'; } ?>>
	 <?php if(get_sub_field('background_video')): ?>
		<div class="video-bg">
			<video autoplay loop muted poster="<?php the_sub_field('video_poster_image'); ?>">
				<source src="<?php the_sub_field('background_video'); ?>" type="video/mp4">
			</video>
		</div>
		<?php endif; ?>
	<div class="row">

		<?php if(get_sub_field('intro_content')): ?>
			<div class="constrain-width">
				<?php the_sub_field('intro_content'); ?>
			</div>
		<?php endif; ?>

		<?php /*Column One*/ if( have_rows('content_types') ): ?>
		<div class="columns large-6 large-offset-0 medium-10  small-12">
		<?php while ( have_rows('content_types') ) : the_row(); ?>

			   <?php /*Content Editor*/ if(get_row_layout() == 'standard_content') { echo ''.get_sub_field('text_content').''; } ?>
				<?php /*Content Editor*/ if(get_row_layout() == 'image_content') { $contentimg = get_sub_field('image_file'); echo wp_get_attachment_image($contentimg, 'large');  } ?>
				<?php /*Buttons*/ if(get_row_layout() == 'button_group') { if(get_sub_field('center_align')) { echo '<div class="button-align">'; } echo '<a class="button" href="'.get_sub_field('button_link').'">'.get_sub_field('button_text').'</a>'; if(get_sub_field('button_text_2')): echo '<a class="button" href="'.get_sub_field('button_link_2').'">'.get_sub_field('button_text_2').'</a>'; endif; if(get_sub_field('center_align')) { echo '</div>'; }  } ?>


		<?php endwhile; ?>
		 </div>
		 <?php  endif; ?>

		<?php /*Column Two*/ if( have_rows('content_types_2') ): ?>
		 <div class="columns large-6 medium-10 large-offset-0 medium-offset-1 medium-pull-1 large-pull-0 small-12">
		<?php while ( have_rows('content_types_2') ) : the_row(); ?>
		   <?php /*Content Editor*/ if(get_row_layout() == 'standard_content') { echo ''.get_sub_field('text_content').''; } ?>
				<?php /*Content Editor*/ if(get_row_layout() == 'image_content') { $contentimg = get_sub_field('image_file'); echo wp_get_attachment_image($contentimg, 'large');  } ?>
				<?php /*Video*/ if(get_row_layout() == 'video_content'); { echo get_sub_field('video_url');} ?>
				<?php /*Buttons*/ if(get_row_layout() == 'button_group') { if(get_sub_field('center_align')) { echo '<div class="button-align">'; } echo '<a class="button" href="'.get_sub_field('button_link').'">'.get_sub_field('button_text').'</a>'; if(get_sub_field('button_text_2')): echo '<a class="button" href="'.get_sub_field('button_link_2').'">'.get_sub_field('button_text_2').'</a>'; endif; if(get_sub_field('center_align')) { echo '</div>'; }  } ?>

						<?php if(get_row_layout() == 'partners'): ?>
							<div class="logos-row">

						<?php $images = get_sub_field('partner_logos');
						$size = 'medium'; // (thumbnail, medium, large, full or custom size)

						/*DESKTOP*/if( $images ): ?>
							<ul class="show-for-medium">
								<?php foreach( $images as $image ): ?>
									<li>
										<?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php

						/*MOBILE*/$imagesmobile = get_sub_field('partner_logos');
						$size = 'medium'; // (thumbnail, medium, large, full or custom size)

						if( $images ): ?>
						<div class="hide-for-medium orbit" data-orbit="">
							<ul class="orbit-container">
								<?php $count = 0; foreach( $imagesmobile as $image ): ?>
									<li class="orbit-slide  <?php if ( $count == 0 ) { echo 'is-active'; } ?>">
										<?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
									</li>
								<?php $count++; endforeach; ?>
							</ul>


						<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span> <i class="fa fa-angle-left"></i></button>
						<button class="orbit-next"><span class="show-for-sr">Next Slide</span> <i class="fa fa-angle-right"></i></button>
						</div>
						<?php endif; endif; ?></div><!--.logos-row-->

		<?php endwhile; ?>
		 </div>
		 <?php  endif; ?>
	</div><!--.row-->
</div><!--.content-section-->
