<?php /////////////////////////////////////////////////////////////////////////////////
// META FIELDS
/////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_meta___section__cybergrx__content' );
function poxy_meta___section__cybergrx__content($meta_boxes) {
  $mb_arr = isset($meta_boxes['hash']) ? [$meta_boxes['hash']] : poxy_get___meta_section_hash(__FUNCTION__);
  if($mb_arr) {
    foreach ($mb_arr as $mb) {
      extract(poxy_args___meta_section(__FUNCTION__, $mb));
      $mbox = [];
      $mbox[] = array( 'id' => "{$prefix}template", 'name' => 'Template', 'type' => 'select', 'columns' => 3, 'options'  => array( 'full-width' => 'Full Width', 'left-image' => 'Left Image', 'right-image'  => 'Right Image' ));
      $mbox[] = array('id' => "{$prefix}divider_content",  'type' => 'divider');
      
      $mbox[] = array('id' => "{$prefix}title", 'name' => __( 'Title:', 'poxy' ), 'type' => 'text', 'columns' => 3, 'tooltip' => array( 'icon' => 'help', 'content'  => 'If empty title will not display.', 'position' => 'right', ), 'columns' => 6,);
      $mbox[] = array('id' => "{$prefix}title__tag", 'name' => __( 'Title Tag:', 'poxy' ), 'tooltip' => array( 'icon' => 'help', 'content' => 'If empty H2 will be used.', 'position' => 'right',), 'type' => 'select', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'], 'multiple' => false, 'placeholder' => 'Select a Tag', 'columns' => 6,  );
      $mbox[] = array('id' => "{$prefix}content", 'name' => __( 'Content:', 'poxy' ), 'type' => 'wysiwyg', 'options' => array( 'textarea_rows' => 20 ), 'columns' => 12);
      $mbox[] = array('id' => "{$prefix}divider_media", 'name' => 'Media',  'type' => 'heading');
      $mbox[] = array('id' => "{$prefix}image", 'name' => __( 'Image:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'image_advanced', 'columns' => '6');
      $mbox[] = array('id' => "{$prefix}video", 'name' => __( 'Video:', 'poxy' ), 'desc' => __( '', 'poxy' ), 'type' => 'oembed', 'columns' => '6');
      $meta['fields'] = $mbox;
      $meta_boxes[] = poxy_push___meta_section($prefix, $meta, ['button']);
    }
  }
  return $meta_boxes;
}








?><?php function section__cybergrx__content($args) {
?><?php extract(poxy_args___section(__FUNCTION__, $args)); ?><?php $bgc = isset($bgc) ? 'bgc__' . $bgc : 'bgc__white'; ?><?php $content = isset($content) ? wpautop($content) : ''; ?><?php $button__title = isset($button__title) ? $button__title : ''; ?><?php $button__url = isset($button__url) ? $button__url : ''; ?><?php $bgi = (isset($bgi) && is_array($bgi)) ? key($bgi) : ''; ?><?php $bgi_url = $bgi ? wp_get_attachment_image_src($bgi, 'full')[0] : ''; ?><?php $image = (isset($image) && is_array($image)) ? key($image) : ''; ?><?php $image_url = $image ? wp_get_attachment_image_src($image, 'full')[0] : ''; ?><?php $sw_classes = []; ?><?php $sw_classes[] = $bgc; ?><?php $sw_classes = implode(' ', $sw_classes); ?><?php $sw_styles = []; ?><?php $sw_styles[] = 'background-image: url('. $bgi_url .');'; ?><?php $sw_styles[] = 'background-size: cover;'; ?><?php $sw_styles[] = 'background-position: center center;'; ?><?php $sw_styles = implode(' ', $sw_styles); ?><?php $title = $title ? $title : '';
$title__tag = $title__tag ? $title__tag : 'h2';
$title__txc = $title__txc ? 'txc__' . $title__txc : '';
$title__args = [
  'title' => $title,
  'title__tag' => $title__tag,
  'title__classes' => $title_classes . ' t7 mn0 js__item ',
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
?><?php $section__bgc = $section__bgc ? 'bgc__' . $section__bgc : 'bgc__white'; ?><?php $section_classes[] = $section__bgc; ?><?php $section_classes = implode(' ', $section_classes); ?><?php $video_url = $video ? $video : ''; ?><?php if($video_url): ?><?php $video_type = poxy_get___video_type($video_url); ?><?php if($video_type == 'youtube'): ?><?php $matches = array(); ?><?php preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_url, $matches); ?><?php $video_id = $matches[1]; ?><?php $video_thumb = 'https://img.youtube.com/vi/' . $video_id . '/0.jpg'; ?><?php elseif($video_type == 'vimeo'): ?><?php $vimeo_id = basename(parse_url($video, PHP_URL_PATH)); ?><?php $imgid = $vimeo_id; ?><?php $hash = unserialize(file_get_contents("https://vimeo.com/api/v2/video/" . $imgid . ".php")); ?><?php $video_thumb = $hash[0]['thumbnail_large']; ?><?php endif; ?><?php endif; ?><section id="<?php echo $section__id . "__" .  $section__hash; ?>" class="<?php echo $section__id; ?> <?php echo $section_classes; ?> rel z3 ofv"> <?php if($section__bgi): ?><div class="fill z1"><?php poxy_image($section__bgi); ?></div><div class="fill bgc__black op50 z2"></div><?php endif; ?><div class="sw rel z10"><div class="cw"><div class="x11"></div></div><article class="single__post cw"><?php if($image || $video): ?><?php switch ($template) : ?><?php case "left-image": ?><div class="a13b13c11d11 js__item"><?php if($video): ?><a href="<?php echo $video; ?>" class="poxy lightbox__open rel"><?php if($image): ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php else: ?><img src="<?php echo $video_thumb; ?>" class="mn0"/><?php endif; ?><div class="caxy p1 br100 bgc__orange z10"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" class="caxy fill"><polygon points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69" style="fill:white;" class="play-btn__svg"></polygon></svg></div></a><?php else: ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php endif; ?></div><div class="a23b23c11d11"><div class="_0__poxyxp100"></div><?php poxy__title($title__args); ?><div class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></div><?php if($button__enable): ?><div class="pn1 oxy js__item"><?php poxy___button('cybergrx', $button_args); ?></div><?php endif; ?></div><?php break; ?><?php case "right-image": ?><div class="a13b13c11d11 qoxy js__item"><?php if($video): ?><a href="<?php echo $video; ?>" class="poxy lightbox__open rel"><?php if($image): ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php else: ?><img src="<?php echo $video_thumb; ?>" class="mn0"/><?php endif; ?><div class="caxy p1 br100 bgc__orange z10"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" class="caxy fill"><polygon points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69" style="fill:white;" class="play-btn__svg"></polygon></svg></div></a><?php else: ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php endif; ?></div><div class="a23b23c11d11"><div class="_0__poxyxp100"></div><?php poxy__title($title__args); ?><div class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></div><?php if($button__enable): ?><div class="pn1 oxy js__item"><?php poxy___button('cybergrx', $button_args); ?></div><?php endif; ?></div><?php break; ?><?php default; ?><div class="_0__poxyxp100"></div><?php poxy__title($title__args); ?><div class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></div><?php if($video): ?><a href="<?php echo $video; ?>" class="poxy lightbox__open rel"><?php if($image): ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php else: ?><img src="<?php echo $video_thumb; ?>" class="mn0"/><?php endif; ?><div class="caxy p1 br100 bgc__orange z10"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" class="caxy fill"><polygon points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69" style="fill:white;" class="play-btn__svg"></polygon></svg></div></a><?php else: ?><img src="<?php echo poxy_get_image($image); ?>" class="mn0"/><?php endif; ?><?php if($button__enable): ?><div class="pn1 oxy js__item"><?php poxy___button('cybergrx', $button_args); ?></div><?php endif; ?><?php break; ?><?php endswitch; ?><?php else: ?><div class="_0__poxyxp100"></div><?php poxy__title($title__args); ?><div class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></div><?php if($button__enable): ?><div class="pn1 oxy js__item"><?php poxy___button('cybergrx', $button_args); ?></div><?php endif; ?><?php endif; ?></article><div class="cw"><div class="x11"></div></div></div></section><?php }?>