<?php function part__button__cybergrx($args) {
  
extract($args);
$action = isset($action) && $action ? $action : '';
$title = isset($title) ? $title : get_the_title();
$permalink = isset($permalink) ? $permalink : '';
$target = isset($target) ? '_blank' : '';

//Ajax Stuff
$post_type = isset($post_type) ? $post_type : 'post';
$posts_per_page = isset($posts_per_page) ? $posts_per_page : '';
$item = isset($item) ? $item : '';

//Custom Script
$custom_script = isset($custom_script) && $custom_script  ? $custom_script : '';

//- Lightbox
$oembed = isset($oembed) && $oembed  ? $oembed : '';
$permalink = $oembed ? $oembed : $permalink;

$txc = isset($txc) ? ' txc__' . $txc : ' txc__orange';
$boc = isset($boc) ? ' boc__' . $boc : '';
$bgc = isset($bgc) ? ' bgc__' . $bgc : '';


$button_classes = '';
$button_classes .= ($action == 'lightbox') ? ' lightbox__open ' : '';
$button_classes .= $txc;
$button_classes .= $boc;
$button_classes .= $bgc;
?><?php if($action != 'custom-script'): ?><a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" class="<?php echo $button_classes; ?> part__button__cybergrx t41 f1 pw1 pe1 pn2 ps2 txav txac"><span class="pw2 pe2 nowrap f1"><?php echo $title; ?></span></a><?php else: ?><?php echo($custom_script); ?><?php endif; ?><?php }?>