<?php /////////////////////////////////////////////////////////////////////////////////
// META FIELDS
/////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_meta___section__cybergrx__hero' );
function poxy_meta___section__cybergrx__hero($meta_boxes) {
  $mb_arr = isset($meta_boxes['hash']) ? [$meta_boxes['hash']] : poxy_get___meta_section_hash(__FUNCTION__);
  if($mb_arr) {
    foreach ($mb_arr as $mb) {
      extract(poxy_args___meta_section(__FUNCTION__, $mb));
      $mbox = [];
      $mbox[] = array( 'id' => "{$prefix}template", 'name' => 'Template', 'type'   => 'select', 'columns' => 3, 'options'  => array( 'full' => 'Full Viewport', 'half' => 'Half Viewport' ), 'tooltip' => array( 'icon' => 'help', 'content'  => 'Default is Half Viewport'), );
      //- $mbox[] = array( 'id' => "{$prefix}txa", 'name' => 'Text Alignment', 'type' => 'select', 'columns' => 3, 'options'  => array( 'txal'  => 'Left', 'txac' => 'Center', 'txar'  => 'Right', ) );

      $mbox[] = array('id' => "{$prefix}divider",  'type' => 'divider');

      //- $mbox[] = array('id' => "{$prefix}title__txc", 'name' => __( 'Title Color:', 'poxy' ), 'type' => 'select', 'options'  => $color_array, 'columns' => 3, 'tab' => 'design' );
      //- $mbox[] = array('id' => "{$prefix}sub_title__txc", 'name' => __( 'Sub Title Color:', 'poxy' ),'type' => 'select', 'options'  => $color_array, 'columns' => 3, 'tab' => 'design' );

      //- $mbox[] = array('id' => "{$prefix}divider_content",  'type' => 'divider');

      $mbox[] = array('id' => "{$prefix}title", 'name' => __( 'Title:', 'poxy' ), 'type' => 'text', 'tooltip' => array( 'icon' => 'help', 'content'  => 'If empty title will not display.', 'position' => 'right', ), 'columns' => 6,);
      $mbox[] = array('id' => "{$prefix}title__tag", 'name' => __( 'Title Tag:', 'poxy' ), 'tooltip' => array( 'icon' => 'help', 'content' => 'If empty H1 will be used.', 'position' => 'right',), 'type' => 'select', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'], 'multiple' => false, 'placeholder' => 'Select a Tag', 'columns' => 6,  );
      $mbox[] = array('id' => "{$prefix}content", 'name' => __( 'Content:', 'poxy' ), 'type' => 'textarea', 'columns' => 12);

      //- $mbox[] = array('id' => "{$prefix}image", 'name' => __( 'Image:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'image_advanced', 'columns' => 2);

      $meta['fields'] = $mbox;
      $meta_boxes[] = poxy_push___meta_section($prefix, $meta, ['button', 'video']);

    }
  }
  return $meta_boxes;
}




?><?php function section__cybergrx__hero($args) {
?><?php extract(poxy_args___section(__FUNCTION__, $args)); ?><?php $title = $title ? $title : ''; ?><?php $img = isset($img) ? $img : $featured_image; ?><?php $template = $template ? $template : 'half'; ?><?php ////////////////////////////////
// BUTTON SETTINGS
//////////////////////////////
$button__action = $button__action ? $button__action : '';
$button__oembed = $button__oembed ? $button__oembed : '';
$button__custom_script = $button__custom_script ? $button__custom_script : '';
$button__title = isset($button__title) ? $button__title : 'Click Here';
$button__txc = isset($button__txc) ? $button__txc : 'white';
$button__txc__hover = isset($button__txc__hover) ? $button__txc__hover : 'white';
$button__boc = isset($button__boc) ? $button__boc : 'white';
$button__boc__hover = isset($button__boc__hover) ? $button__boc__hover : 'white';
$button__bgc = isset($button__bgc) ? $button__bgc : '';
$button__bgc__hover = isset($button__bgc__hover) ? $button__bgc__hover : 'white';
$video_url = $button__oembed;
$vimeo_id = basename(parse_url($video_url, PHP_URL_PATH));
$imgid = $vimeo_id;
$button_args = [
  'action' => $button__action,
  'oembed' => $button__oembed,
  'custom_script' => $button__custom_script,
  'button_id' => 1,
  'txc' => $button__txc,
  'boc' => $button__boc,
  'bgc' => $button__bgc,
  'title' => $button__title,
  'permalink' => $button__url,
  'target' => $button__target
];

?><?php if(!empty($video__group)): ?><?php $video_num = rand (1, count($video__group)); ?><?php $video_array = []; ?><?php foreach($video__group as $video): ?><?php $video_array[] = $video[$prefix . 'video__group__id']; ?><?php endforeach; ?><?php $video_url = $video_array[array_rand($video_array)]; ?><?php $vimeo_id = basename(parse_url($video_url, PHP_URL_PATH)); ?><?php $imgid = $vimeo_id; ?><?php $hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/$imgid.php")); ?><?php $vimeo_thumb = $hash[0]['thumbnail_large']; ?><?php endif; ?><?php switch ($template) : ?><?php case ("full" || "half"): ?><?php $txa = 'txac'; ?><?php $section__height = ($template == 'half') ? 'xv_50' : 'xv_100'; ?><?php $float_align = ($txa == "txal") ? "poxy" : ""; ?><?php $float_align = ($txa == "txar") ? "qoxy" : ""; ?><?php $content__txc = $content__txc ? $content__txc : 'white'; ?><?php $section__bgc = $section__bgc ? 'bgc__' . $section__bgc : 'bgc__black'; ?><?php $section_classes[] = $section__bgc; ?><?php $section_classes = implode(' ', $section_classes); ?><section id="<?php echo $section__id . "__" .  $section__hash; ?>" style="<?php echo $sw_styles; ?>" class="<?php echo $section__id; ?> <?php echo $section_classes; ?> rel z3 ofv"><?php if(empty($video__group) || !$video__enable): ?><?php if($section__bgi): ?><div class="fill z1"><?php poxy_image($section__bgi); ?></div><div class="fill bgc__black op50 hide z2"></div><?php endif; ?><?php endif; ?><?php if(!empty($video__group) && $video__enable): ?><div class="fill z1"><div style="background-image: url(<?php echo $vimeo_thumb; ?>)" class="vimeo-thumb z1 bgsf bgpn fill paxy"></div><iframe style="width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 190.77vh;" src="https://player.vimeo.com/video/<?php echo $vimeo_id; ?>?background=1&autoplay=1&muted=1&loop=1&byline=0&title=0" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" class="caxy z10"></iframe></div><div class="fill bgc__black op50 z2"></div><?php endif; ?><div class="sw rel z10"><div class="cw clear"><div class="<?php echo $section__height; ?> <?php echo $txa; ?> x11 txav ms0"><div><div class="<?php echo $txa == "txac" ? "oxy" : "";?> x11"><div class="<?php echo $float_align; ?> a34b34c34d11"><div class="_0__poxyxp100"></div><?php $title = $title ? $title : '';
$title__tag = $title__tag ? $title__tag : 'h1';
$title__txc = $title__txc ? 'txc__' . $title__txc : 'txc__white';
$title__args = [
  'title' => $title,
  'title__tag' => $title__tag,
  'title__classes' => 'txw__medium t9 txc__white ps2 js__item',
  'title_span__classes' => $title__txc,
];?><?php poxy__title($title__args); ?><?php if($content): ?><h2 style="line-height:1.6;" class="t5 txw__light js__item"><span class="txc__<?php echo $content__txc; ?>"><?php echo $content; ?></span></h2><?php endif; ?><?php if($button__enable): ?><?php if($button__title && $button__url && ($txa == 'txac')): ?><div class="poxy xp100 oxy"><div class="pn1 mn1 js__item"><?php poxy___button('cybergrx', $button_args); ?></div></div><?php endif; ?><?php if($button__title && $button__url && ($txa == 'txal' || $txa == 'txar')): ?><div class="mn1 pn2 js__item"><div class="<?php echo $float_align; ?>"><?php poxy___button('cybergrx', $button_args); ?></div></div><?php endif; ?><?php endif; ?></div></div></div></div></div></div></section><?php break; ?><?php default: ?><?php endswitch; ?><?php }?>
