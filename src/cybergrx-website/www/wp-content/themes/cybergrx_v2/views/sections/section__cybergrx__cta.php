<?php /////////////////////////////////////////////////////////////////////////////////
// META FIELDS
/////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_meta___section__cybergrx__cta' );
function poxy_meta___section__cybergrx__cta($meta_boxes) {
  $mb_arr = isset($meta_boxes['hash']) ? [$meta_boxes['hash']] : poxy_get___meta_section_hash(__FUNCTION__);
  if($mb_arr) {
    foreach ($mb_arr as $mb) {
      extract(poxy_args___meta_section(__FUNCTION__, $mb));
      $mbox = [];
      $mbox[] = array('id' => "{$prefix}title", 'name' => __( 'Title:', 'poxy' ), 'type' => 'text', 'columns' => 3, 'tooltip' => array( 'icon' => 'help', 'content'  => 'If empty title will not display.', 'position' => 'right', ), 'columns' => 6,);
      $mbox[] = array('id' => "{$prefix}title__tag", 'name' => __( 'Title Tag:', 'poxy' ), 'tooltip' => array( 'icon' => 'help', 'content' => 'If empty H2 will be used.', 'position' => 'right',), 'type' => 'select', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'], 'multiple' => false, 'placeholder' => 'Select a Tag', 'columns' => 6,  );
      $mbox[] = array('id' => "{$prefix}content", 'name' => __( 'Content:', 'poxy' ), 'type' => 'textarea');
      $meta['fields'] = $mbox;
      $meta_boxes[] = poxy_push___meta_section($prefix, $meta, ['button']);
    }
  }
  return $meta_boxes;
}

?><?php function section__cybergrx__cta($args) {
?><?php extract(poxy_args___section(__FUNCTION__, $args)); ?><?php $content = isset($content) ? $content : ''; ?><?php $title = isset($title) ? $title : ''; ?><?php ////////////////////////////////
// TITLE SETTINGS
//////////////////////////////
$title = $title ? $title : '';
$title__tag = $title__tag ? $title__tag : 'h2';
$title__txc = $title__txc ? 'txc__' . $title__txc : '';
$title__args = [
  'title' => $title,
  'title__tag' => $title__tag,
  'title__classes' => $title_classes . ' t8 ms0 ',
  'title_span__classes' => $title__txc,
];
?><?php ////////////////////////////////
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

?><?php $section__bgc = $section__bgc ? 'bgc__' . $section__bgc : 'bgc__white'; ?><?php $section_classes[] = $section__bgc; ?><?php $section_classes = implode(' ', $section_classes); ?><section id="<?php echo $section__id . "__" .  $section__hash; ?>" style="<?php echo $sw_styles; ?>" class="<?php echo $section__id; ?> <?php echo $section_classes; ?> rel z3"><?php if($section__bgi): ?><div class="fill z1"><?php poxy_image($section__bgi); ?></div><div class="fill bgc__black op50 z2"></div><?php endif; ?><div class="sw rel z10"><div class="cw"><div class="x11"></div></div></div><div class="sw rel z10"><article class="single__post cw txac"><?php if($title): ?><div class="x11 js__item oxy"><?php poxy__title($title__args); ?></div><?php endif; ?><?php if($content): ?><div class="x11 js__item"><p class="<?php echo $content_classes; ?>"><span class="t6"><?php echo $content; ?></span></p></div><?php endif; ?><?php if($button__enable): ?><div class="x11 oxy js__item ps1"><?php poxy___button('cybergrx', $button_args); ?></div><?php endif; ?></article><div class="cw"><div class="x11">
</div></div></div></section><?php }?>