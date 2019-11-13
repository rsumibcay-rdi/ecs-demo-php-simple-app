<?php

$background = '#ff6c2c';
$color = '#fff';

$colors = array(
	'orange' => '#ff6c2c',
	'blue' => '#0f324d',
	'black' => '#000',
	'white' => '#fff',
	'grey' => '#c4c4c4',
);

$_bg = get_sub_field('background_color');
$_color = get_sub_field('text_color');

if (isset($colors[strtolower($_bg)])){
	$background = $colors[strtolower($_bg)];
}
if (isset($colors[strtolower($_color)])){
	$color = $colors[strtolower($_color)];
}

$text = '<p style="color: '.$color.'">'.get_sub_field('text').'</p>';

if (get_sub_field('url')){
	$text = '<a href="'.get_sub_field('url').'">'.$text.'</a>';
}

?>
<div class="section announcement-bar" style="background-color: <?php echo $background; ?>"><?php echo $text; ?></div>
