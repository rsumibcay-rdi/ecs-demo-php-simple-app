<div class="content-section tab-section">
	<div class="row">

		<div class="constrain-width">
			<?php the_sub_field('intro_content'); ?>
		</div>

		<?php if( have_rows('content_tabs') ): ?>
		<div class="tabs-content" data-tabs-content="content-tabs">
		  <?php $counter = 0; while ( have_rows('content_tabs') ) : the_row(); ?>
		  <div class="tabs-panel <?php if ($counter == 0) { echo 'is-active'; } ?>" id="panel<?php echo $counter; ?>">
			<h3><?php the_sub_field('tab_title'); ?></h3>
			<?php $tabimg = get_sub_field('tab_content'); ?>
			<?php echo wp_get_attachment_image($tabimg, 'medium'); ?>
		  </div>
		  <?php $counter++; endwhile; ?>
		</div>
		<?php endif; ?>

	</div>

	<div class="tabnav-row">
		<div class="row">

		<?php if( have_rows('content_tabs') ): ?>
		<ul class="tabs" id="content-tabs" data-tabs>
		  <?php $counter2 = 0; while ( have_rows('content_tabs') ) : the_row(); ?>
		  <li class="tabs-title <?php if ($counter2 == 0) { echo 'is-active'; } ?>">
			<a href="#panel<?php echo $counter2; ?>">
				<?php //embed SVG so we can change color on hover
				$icon = get_sub_field( 'tab_icon' );
				if ( !empty( $icon ) ):
				echo file_get_contents( $icon ) ;
				endif; ?>
				<span><?php the_sub_field('tab_title'); ?></span>
			</a>
		 </li>
		   <?php $counter2++; endwhile; ?>
		</ul>
		<?php endif; ?>
		</div><!--.row-->

	</div><!--.tabnav-row-->

	</div><!--.row-->

</div><!--.content-section-->]
