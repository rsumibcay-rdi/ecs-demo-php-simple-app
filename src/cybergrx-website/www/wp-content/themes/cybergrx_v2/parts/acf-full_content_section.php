<?php

$inline_style = $bg_video = '';
$classes = array('content-section');

if (get_sub_field('background_video')){
	$classes[] = 'has-video';

	$bg_video = '<div class="video-bg"><video autoplay loop muted poster="'.get_sub_field('video_poster_image').'"><source src="'.get_sub_field('background_video').'" type="video/mp4"></video>'.
				// '<img class="award" style="position: absolute; width: 125px; height: 125px; right: 0; bottom: 0; z-index: 2;" src="https://www.cybergrx.com/wp-content/uploads/2018/03/RSAC-Innovation-Sandbox-FINALIST-2018-200px-e1521564548939.png">'.
				'</div>'.PHP_EOL;
}
if (get_sub_field('background_image')){
	$classes[] = 'has-bgimg';
	$inline_style = ' style="background-image: url('.get_sub_field('background_image').');"';
}
if (get_sub_field('background_color')){
	$classes[] = 'bg-'.get_sub_field('background_color');
}

?>
<div class="<?php echo implode(' ', $classes); ?>"<?php echo $inline_style; ?>>
	<?php echo $bg_video; ?>
	<div class="inner-content row">
		<?php if( have_rows('content_types') ): while ( have_rows('content_types') ) : the_row();

			if(get_row_layout() == 'intro_title') { echo '<div class="intro-title">'.get_sub_field('title_text_intro').'</div>'; }

			if(get_row_layout() == 'standard_title') { echo '<h2 class="emphasized-title">'.get_sub_field('title_text').'</h2>'; }

			if(get_row_layout() == 'button_group') { echo '<a class="button" href="'.get_sub_field('button_link').'">'.get_sub_field('button_text').'</a>'; if(get_sub_field('button_text_2')){ echo '<a class="button" href="'.get_sub_field('button_link_2').'">'.get_sub_field('button_text_2').'</a>'; } }

			if(get_row_layout() == 'standard_content') { echo '<div>'.get_sub_field('text_content').'</div>'; }

			if(get_row_layout() == 'two_col_content'): ?>

				<div class="row two-col-row">
					<div class="columns large-6 medium-6 small-12"><?php the_sub_field('col_one_content'); ?></div>
					<div class="columns large-6 medium-6 small-12"><?php the_sub_field('col_two_content'); ?></div>
				</div>

			<?php endif;

			if(get_row_layout() == 'countdown'): ?>

				<div id="countdown-timer" class="countdown-row" data-time="<?= get_sub_field('countdown_date'); ?>">
					<ul class="countdown">
						<li><span id="days">00</span>Days</li>
						<li><span id="hours">00</span>Hours</li>
						<li><span id="minutes">00</span>Minutes</li>
						<li><span id="seconds">00</span>Seconds</li>
					</ul>
					<?php if (get_sub_field('countdown_subtext')): ?>
						<p class="h2"><?php the_sub_field('countdown_subtext'); ?></p>
					<?php endif; ?>
				</div>

			<?php endif;

			if(get_row_layout() == 'case_study'):

				$post_object = get_sub_field('featured_case_study');
				if( $post_object ):
					// override $post
					$post = $post_object;
					setup_postdata( $post );
					?>
					<div class="study-quote"><?php the_content(); ?></div>
					<div class="tagline">
						<div class="photo-wrapper"><?php the_post_thumbnail('thumbnail'); ?></div>
						<div class="quote-attribution">&ndash; <strong><?php the_title(); ?></strong>, <?php the_field('quote_title'); ?></div>
					</div>
					<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
				endif;

			endif;

			if(get_row_layout() == 'bios'):

				$posts = get_sub_field('selected_bios');
				$column_classes = 'columns large-4 medium-6 small-12'; // defaults to 'thirds'
				if( 'quarter' === get_sub_field( 'bios_column_width' ) ){
					$column_classes = 'columns large-3 medium-6 small-12';
				}
				if( $posts ): ?>
					<div class="bios-row">
						<div class="people-list" data-equalizer data-equalize-on="medium">
							<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
								<?php setup_postdata($post); ?>
								<div data-equalizer-watch class="person load-inline <?php echo $column_classes; ?>">
									<a href="<?php the_permalink(); ?>" class="bio-link load-bio">
										<?php the_post_thumbnail('large-thumb'); ?>
										<h3><?php the_title(); ?></h3>
										<h4><?php the_field('bio_title'); ?></h4>
									</a>
								</div>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
						</div><!--.people-list-->
						<div id="load-inline-container">
							<div class="position-wrapper">
								<div id="load-inline-content"></div>
								<span id="close-inline" class="close-window"></span>
							</div>
						</div>
					</div>
				<?php endif;

			endif;

			if(get_row_layout() == 'single_bio'): ?>

				<?php
				$posts = get_sub_field('selected_bio');
				if( $posts ): ?>
					<?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
						<?php setup_postdata($post); ?>
						<div class="bio-detail content-section">
							<div class="row">
								<div class="columns large-4 medium-6 small-12 mini-pic people-list">
									<?php the_post_thumbnail('large-thumb'); ?>
								</div>
								<div class="columns large-8 medium-6 small-12 text-align-left">
									<h3><?php the_title(); ?></h3>
									<h4><?php the_field( 'bio_title' ); ?></h4>
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
				<?php endif; ?>
			<?php endif;

			if(get_row_layout() == 'pie_charts'):

				if(get_sub_field('pie_chart')){
					$pie_chart = '';
					$chart_classes = 'chart-row';

					while(has_sub_field('pie_chart')){
						$label = get_sub_field('percent_label');
						if (strlen($label) > 55){ $chart_classes = 'chart-row bigger-circles'; }
						$pie_chart .= '<div class="chart" data-percent="'.esc_attr(get_sub_field('percent_number')).'">'.
										'<div class="chart-percent"><span>'.esc_html(get_sub_field('percent_number')).'</span>%</div>'.
										'<div class="chart-label">'.esc_html($label).'</div>'.
									'</div>';
					}

					if ($pie_chart){
						echo '<div class="'. $chart_classes. '">' .$pie_chart.'</div>';
					}
				}

			endif;

			if(get_row_layout() == '3_column_grid'): ?>

				<div class="grid-row">
					<div class="row text-align-<?php echo get_sub_field('text_alignment')?>">
						<div class="columns small-12 medium-4 large-4">
							<?php echo wp_get_attachment_image(get_sub_field('content_image_1'), 'large-thumb'); ?>
							<h3><?php the_sub_field('content_title'); ?></h3>
							<div class="content-block"><?php the_sub_field('content_column_1'); ?></div>
						</div>
						<div class="columns small-12 medium-4 large-4">
							<?php echo wp_get_attachment_image(get_sub_field('content_image_2'), 'large-thumb'); ?>
							<h3><?php the_sub_field('content_title_2'); ?></h3>
							<div class="content-block"><?php the_sub_field('content_column_2'); ?></div>
						</div>
						<div class="columns small-12 medium-4 large-4">
							<?php echo wp_get_attachment_image(get_sub_field('content_image_3'), 'large-thumb'); ?>
							<h3><?php the_sub_field('content_title_3'); ?></h3>
							<div class="content-block"><?php the_sub_field('content_column_3'); ?></div>
						</div>
					</div>
				</div>

			<?php endif;

			if(get_row_layout() == 'partners'): ?>

				<div class="logos-row">
					<div class="row">
						<?php

						$images = get_sub_field('partner_logos');
						$desktopsize = 'medium';
						$mobilesize = 'medium';

						if( $images ){
							$desktop = '<ul class="show-for-medium">';
							$mobile = '<div class="hide-for-medium orbit" data-orbit><ul class="orbit-container">';

							$active = ' is-active';
							foreach( $images as $image ){
								$desktop .= '<li>'.wp_get_attachment_image( $image['ID'], $desktopsize ).'</li>';
								$mobile .= '<li class="orbit-slide'.$active.'">'.wp_get_attachment_image( $image['ID'], $mobilesize ).'</li>';

								$active = '';
							}

							$desktop .= '</ul>';
							$mobile .= '</ul><button class="orbit-previous"><span class="show-for-sr">Previous Slide</span> <i class="fa fa-angle-left"></i></button><button class="orbit-next"><span class="show-for-sr">Next Slide</span> <i class="fa fa-angle-right"></i></button></div>';
						}

						echo $desktop.PHP_EOL.$mobile;
						?>
					</div>
				</div>

			<?php endif;

			if(get_row_layout() == 'icon_list'):

				if(get_sub_field('icons')): ?>
					<div class="row icon-list">
					<?php while(has_sub_field('icons')): ?>
						<div class="columns large-4 medium-6 small-12">
							<?php echo zen_inline_if_svg(get_sub_field( 'icon_img' )); ?>
							<span class="icon-label"><?php the_sub_field('icon_title'); ?></span>
						</div>
					<?php endwhile; ?>
					</div>
				<?php endif;

			endif;

			if(get_row_layout() == 'hubspot_form'){

				echo '<div class="hubspot-contact-form constrain-width">'.
					'<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>'.
					'<script>hbspt.forms.create({portalId: "2378677", formId: "8071222a-47a7-46b5-a217-9c7aa3d63cf0", css: ""});</script>'.
				'</div>';

			}

		endwhile; endif; ?>
	</div>
</div>
