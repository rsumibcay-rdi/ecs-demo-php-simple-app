<?php

$classes = array('three-column-infographic');
$columns = '';

if (have_rows('column')){
	while (have_rows('column')): the_row();
		$column = '';

		switch (get_sub_field('column_type')) {
			case 'paragraph':
				$column .= '<div class="column-content">'.wp_kses(get_sub_field('paragraph'), 'post').'</div>';
				break;

			case 'percent':
				$label = get_sub_field('percent_label');
				if (strlen($label) > 55){ $classes[] = 'bigger-circles'; }
				$column .= '<div class="chart" data-percent="'.esc_attr(get_sub_field('percent')).'">'.
								'<div class="chart-percent"><span>'. get_sub_field('percent'). '</span>%</div>'.
								'<div class="chart-label">'.esc_html($label).'</div>'.
							'</div>';
				break;
		}

		if (get_sub_field('sources')){
			$column .= '<p class="sources">'.get_sub_field('sources').'</p>';
		}

		if ($column){
			$columns .= '<div class="columns medium-4 small-12"  data-equalizer-watch>'.$column.'</div>';
		}
	endwhile;
}

if ($columns){
	echo '<section class="'.implode(' ', $classes).'">';
		if ($header = get_sub_field('header')){
			echo '<h2>'.$header.'</h2>';
		}
		if ($subheader = get_sub_field('sub_header')){
			echo '<p class="constrain-width">'.$subheader.'</p>';
		}
		echo '<div class="row chart-row" data-equalizer data-equalize-on="medium">'.$columns.'</div>';
	echo '</section>';
}

?>
