<?php /////////////////////////////////////////////////////////////////////////////////
// META FIELDS
/////////////////////////////////////////////////////////////////////////////////
add_filter( 'rwmb_meta_boxes', 'poxy_meta___section__cybergrx__resources' );
function poxy_meta___section__cybergrx__resources($meta_boxes) {
  $mb_arr = isset($meta_boxes['hash']) ? [$meta_boxes['hash']] : poxy_get___meta_section_hash(__FUNCTION__);
  if($mb_arr) {
    foreach ($mb_arr as $mb) {
      extract(poxy_args___meta_section(__FUNCTION__, $mb));
      $mbox = [];
      //- $mbox[] = array( 'id' => "{$prefix}template", 'name' => 'Template', 'type' => 'select', 'columns' => 3, 'options'  => array( 'left' => 'Image Left', 'top' => 'Image Top', 'right'  => 'Image Right', 'bottom'  => 'Image Bottom', ), 'tab' => 'Design');
      $mbox[] = array('id' => "{$prefix}title", 'name' => __( 'Title:', 'poxy' ), 'type' => 'text', 'columns' => 3, 'tooltip' => array( 'icon' => 'help', 'content'  => 'If empty title will not display.', 'position' => 'right', ), 'columns' => 6,);
      $mbox[] = array('id' => "{$prefix}title__tag", 'name' => __( 'Title Tag:', 'poxy' ), 'tooltip' => array( 'icon' => 'help', 'content' => 'If empty H2 will be used.', 'position' => 'right',), 'type' => 'select', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'], 'multiple' => false, 'placeholder' => 'Select a Tag', 'columns' => 6,  );
      $mbox[] = array( 'id' => "{$prefix}thumb__title__bgc", 'name' => 'Thumb Title Background Color', 'type' => 'select', 'columns' => 4, 'options'  => $color_array, 'placeholder' => 'Select a Color', );
      $mbox[] = array( 'id' => "{$prefix}thumb__title__txc", 'name' => 'Thumb Title Text Color', 'type' => 'select', 'columns' => 4, 'options'  => $color_array, 'placeholder' => 'Select a Color', );
      $mbox[] = array('id' => "{$prefix}content", 'name' => __( 'Content:', 'poxy' ), 'type' => 'textarea', 'columns' => 12);
      $mbox[] = array('id' => "{$prefix}divider", 'name' => 'Resource Links', 'type' => 'heading',  );
      $mbox[] = array(
        'id' => "{$prefix}group",
        'type'   => 'group',
        'clone'  => true,
        'sort_clone' => true,
        'fields' => array(
          array(
            'name' => __( 'Resource', 'poxy' ),
            'id' => "{$prefix}group__id",
            'type' => 'post',
            'post_type' => array('post'),
            'field_type'	=> 'select_advanced',
            'placeholder' => __( 'Select a Resource', 'poxy' ),
            'query_args'	=> array(
              'post_status' => 'publish',
              'posts_per_page' => - 1,
            ),
            'columns' => 6,
          ),
          array('id' => "{$prefix}group__title", 'name' => __( 'Title (Override):', 'poxy' ), 'type' => 'text', 'std'	=> '', 'columns' => 6 ),
          //- array('id' => "{$prefix}group__button__url", 'name' => __( 'Permalink:', 'poxy' ), 'type' => 'url', 'std'	=> '', 'columns' => 3 ),
          //- array('id' => "{$prefix}group__image", 'name' => __( 'Image:', 'poxy' ), 'type' => 'image_advanced', 'columns' => 3),
        )
      );
      $meta['fields'] = $mbox;
      $meta_boxes[] = poxy_push___meta_section($prefix, $meta, ['button']);
    }
  }
  return $meta_boxes;
}


?><?php function section__cybergrx__resources($args) {?><?php extract(poxy_args___section(__FUNCTION__, $args)); ?><?php ////////////////////////////////
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
?><?php $section__bgc = $section__bgc ? 'bgc__' . $section__bgc : 'bgc__white'; ?><?php $section_classes[] = $section__bgc; ?><?php $section_classes = implode(' ', $section_classes); ?><?php $thumb__title__txc = (isset($thumb__title__txc) && $thumb__title__txc) ? 'txc__' . $thumb__title__txc : 'txc__white'; ?><?php $thumb__title__bgc = (isset($thumb__title__bgc) && $thumb__title__bgc) ? 'bgc__' . $thumb__title__bgc : 'bgc__navy'; ?><section id="<?php echo $section__id . "__" .  $section__hash; ?>" style="<?php echo $sw_styles; ?>" class="<?php echo $section__id; ?> <?php echo $section_classes; ?> rel z3 ofv"><div class="sw"><div class="cw"></div><article class="cw"><div class="x11 ms0"><div class="_0__poxyxp100"></div><?php if($title): ?><div class="oxy"><?php poxy__title($title__args); ?></div><?php endif; ?><?php if($content): ?><div class="txac"><p class="<?php echo $content_classes; ?> js__item"><?php echo $content; ?></p></div><?php endif; ?></div></article><div class="cw oxy"><?php if(!empty($group)): ?><?php $count = count($group); ?><?php $c=0; foreach ( $group as $v ): $c++; ?><?php $page__id = isset($v["{$prefix}group__id"]) ? $v["{$prefix}group__id"] : ''; ?><?php $thumb_title = isset($v["{$prefix}group__title"]) ? $v["{$prefix}group__title"] : get_the_title($page__id); ?><?php $image_url = $page__id ? get_the_post_thumbnail_url($page__id, 'large') : ''; ?><?php $button__url = isset($v["{$prefix}group__id"]) ? get_the_permalink( $v["{$prefix}group__id"]) : ''; ?><?php $a_styles = []; ?><?php $a_styles[] = $image_url ? 'background-image: url('. $image_url .');' : ''; ?><?php $a_styles[] = $image_url ? 'background-size: cover;' : ''; ?><?php $a_styles[] = $image_url ? 'background-position: center center;' : ''; ?><?php $a_styles = implode(' ', $a_styles); ?><?php $a_classes = []; ?><?php $a_classes[] = ($count == 1) ? 'x11 x_13' : ''; ?><?php $a_classes[] = ($count == 2) ? 'x12 x_13' : ''; ?><?php $a_classes[] = ($count == 3) ? 'x13 x_13' : ''; ?><?php $a_classes[] = ($count == 4) ? 'x14 x_13' : ''; ?><?php $a_classes = implode(' ', $a_classes); ?><?php if($button__url): ?><a href="<?php echo $button__url; ?>" style="<?php echo $a_styles; ?>" class="<?php echo $thumb__title__bgc; ?> item__resource a14a_13b13b_12c12c_23d11d_11 txc__white js__item"><?php if($image_url): ?><div class="fill ofh"><?php poxy_image($image_url); ?></div><?php endif; ?><?php if($thumb_title): ?><div style="position:absolute; bottom:-3px;" class="<?php echo $thumb__title__bgc; ?> item__resource__text xp100 txc__white txac z10"><div class="<?php echo $thumb__title__txc; ?> m1 t3"><?php echo $thumb_title; ?></div></div><?php endif; ?></a><?php endif; ?><?php endforeach; ?><?php endif; ?><?php if($button__enable): ?><div class="x11"><div class="pn1 oxy"><?php poxy___button('cybergrx', $button_args); ?></div></div><?php endif; ?></div><div class="cw"><div class="x11"></div></div></div></section><?php }?>