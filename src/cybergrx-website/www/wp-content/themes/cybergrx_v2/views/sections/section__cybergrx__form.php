<?php /////////////////////////////////////////////////////////////////////////////////
// META FIELDS
/////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_meta___section__cybergrx__form' );
function poxy_meta___section__cybergrx__form($meta_boxes) {
  $mb_arr = isset($meta_boxes['hash']) ? [$meta_boxes['hash']] : poxy_get___meta_section_hash(__FUNCTION__);
  if($mb_arr) {
    foreach ($mb_arr as $mb) {
      extract(poxy_args___meta_section(__FUNCTION__, $mb));
      $mbox = [];
      $mbox[] = array('id' => "{$prefix}title", 'name' => __( 'Title:', 'poxy' ), 'type' => 'text', 'columns' => 3, 'tooltip' => array( 'icon' => 'help', 'content'  => 'If empty title will not display.', 'position' => 'right', ), 'columns' => 6,);
      $mbox[] = array('id' => "{$prefix}title__tag", 'name' => __( 'Title Tag:', 'poxy' ), 'tooltip' => array( 'icon' => 'help', 'content' => 'If empty H2 will be used.', 'position' => 'right',), 'type' => 'select', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'], 'multiple' => false, 'placeholder' => 'Select a Tag', 'columns' => 6,  );
      $mbox[] = array('id' => "{$prefix}content", 'name' => __( 'Content:', 'poxy' ), 'type' => 'textarea');
      $mbox[] = array('id' => "{$prefix}form_script", 'name' => __( 'Form Script:', 'poxy' ), 'type' => 'textarea');
      
      $meta['fields'] = $mbox;
      $meta_boxes[] = poxy_push___meta_section($prefix, $meta, []);
    }
  }
  return $meta_boxes;
}


?><?php function section__cybergrx__form($args) {
?><?php extract(poxy_args___section(__FUNCTION__, $args)); ?><?php $section__bgc = $section__bgc ? 'bgc__' . $section__bgc : 'bgc__white'; ?><?php $section_classes[] = $section__bgc; ?><?php $section_classes = implode(' ', $section_classes); ?><?php ////////////////////////////////
// TITLE SETTINGS
//////////////////////////////
$title = $title ? $title : '';
$title__tag = $title__tag ? $title__tag : 'h2';
$title__txc = $title__txc ? 'txc__' . $title__txc : '';
$title__args = [
  'title' => $title,
  'title__tag' => $title__tag,
  'title__classes' => $title_classes . ' t7 js__item ',
  'title_span__classes' => $title__txc,
];

?><section id="<?php echo $section__id . "__" .  $section__hash; ?>" style="<?php echo $sw_styles; ?>" class="<?php echo $section__id; ?> <?php echo $section_classes; ?> rel z3 ofv"><div class="sw"><div class="cw"></div><article class="cw"><div class="x11 ms0"><div class="_0__poxyxp100"></div><?php if($title): ?><div class="oxy"><?php poxy__title($title__args); ?></div><?php endif; ?><?php if($content): ?><div class="txac"><p class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></p></div><?php endif; ?></div></article><div class="cw oxy"><article class="a23b34c11d11 js__item"><?php echo $form_script; ?>
</article></div></div></section><?php }?>