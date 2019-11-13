<?php $bg_img = ''; $bg_color;
	if (get_sub_field('background_image') == 'background_1'): $bg_img = get_template_directory_uri() . '/assets/images/Option1_BG.jpg';
	elseif (get_sub_field('background_image') == 'background_2'): $bg_img = get_template_directory_uri() . '/assets/images/Option2_BG.jpg'; $bg_color = 'white';
	endif; ?>
<?php $iframe = get_sub_field('video_url');
	$attr = 'id="youtube"';
	$iframe = str_replace('></iframe>', ' ' . $attr . '></iframe>', $iframe);
	$vid_bg = get_template_directory_uri() . '/assets/images/default_video_bg.png';
	if (get_sub_field('video_landing_image')): $vid_bg = wp_get_attachment_image_src( get_sub_field('video_landing_image'), 'large')[0]; endif; ?>

<div class="content-section video-module" style="background-image: url('<?php echo $bg_img; ?>'); background-color: <?php echo $bg_color; ?>">
	<div class="row">
		<h2><?php the_sub_field('heading'); ?></h2>
		<p><?php the_sub_field('subheading'); ?></p>
		<div class="playme-container">
			<img class="playme" id="playme" onclick="revealVideo('video','youtube')" src="<?php echo $vid_bg; ?>">
			<img class="playbutton" onclick="revealVideo('video','youtube')" src="<?php echo get_template_directory_uri(); ?>/assets/images/playbutton.svg">
		</div>

		<div id="video" class="lightbox" onclick="hideVideo('video','youtube')">
		  <div class="lightbox-container">
			<div class="lightbox-content">

			  <button onclick="hideVideo('video','youtube')" class="lightbox-close">
				Close | ✕
			  </button>
			  <div class="video-container">
				  <?php echo $iframe; ?>
			  </div>

			</div>
		  </div>
		</div>
	</div>
</div>
