<section class="content-section">
	<div class="row">
		<h2><?php the_sub_field('header'); ?></h2>
		<?php if ($_jobs_iframe = get_sub_field('iframe')) {
			echo '<div class="flex-embed iframe"><iframe src="'.$_jobs_iframe.'" target="_top"></iframe></div>';

		}; ?>
	</div>
</section>
