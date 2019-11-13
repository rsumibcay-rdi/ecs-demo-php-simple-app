<?php /**
 * Get an attachment ID given a URL.
 * 
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function get_attachment_id( $url ) {

    $attachment_id = 0;

    $dir = wp_upload_dir();

    if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?

        $file = basename( $url );

        $query_args = array(
            'post_type'   => 'attachment',
            'post_status' => 'inherit',
            'fields'      => 'ids',
            'meta_query'  => array(
                array(
                    'value'   => $file,
                    'compare' => 'LIKE',
                    'key'     => '_wp_attachment_metadata',
                ),
            )
        );

        $query = new WP_Query( $query_args );

        if ( $query->have_posts() ) {

            foreach ( $query->posts as $post_id ) {

                $meta = wp_get_attachment_metadata( $post_id );

                $original_file       = basename( $meta['file'] );
                $cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

                if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
                    $attachment_id = $post_id;
                    break;
                }

            }

        }

    }

    return $attachment_id;
}




?><?php function poxy_tax_img($image_ids, $size = 'full') {?><?php if ( !empty( $image_ids ) ): ?><?php foreach ( $image_ids as $image_id ) : ?><?php $image = RWMB_Image_Field::file_info( $image_id, array( 'size' => $size ) ); ?><?php $img = $image['url'] ? $image['url'] : ''; ?><?php endforeach; ?><?php return $img; ?><?php endif; ?><?php }
?><?php function poxy_get_metabox_image( $images = false ) {?><?php if(is_array($images)): ?><?php foreach ( $images as $image ) : ?><?php return $image["full_url"]; ?><?php endforeach; ?><?php endif; ?><?php }

?><?php function poxy_image($url = '', $class = '', $size = '') {

$class = $class ? $class : 'bgsf bgpc';

if(is_array($url)) {
  if ( isset($url['ID']) ) { 
    
    $url = wp_get_attachment_image_url($url['ID'], 'large') ? wp_get_attachment_image_url($url['ID'], 'large') : get_poxy_featured(poxy_id());
    
  } else if ( isset($url['0']) ) { 
    $url = wp_get_attachment_image_url($url[0], 'large') ? wp_get_attachment_image_url($url[0], 'large') : get_poxy_featured(poxy_id());

  } else {
  
    $images = $url;
    foreach ( $images as $image ) {
      $url = $image["full_url"] ? $image["full_url"] : get_poxy_featured(poxy_id());
    }
    
  }
  
  
} else if( is_numeric($url) ) {
  $url = wp_get_attachment_image_url($url, 'large') ? wp_get_attachment_image_url($url, 'large') : get_poxy_featured(poxy_id());
} else {
  $url = $url ? $url : get_poxy_featured( poxy_id(), $size );
}?><div class="fill"><div data-src="<?php  echo $url; ?>" class="image__container caxy fill bgr0 z3 b-lazy <?php echo $class; ?>"></div></div><?php }

?><?php function poxy_rellax($url = '', $class = '', $size = '') {

$class = $class ? $class : 'bgsf bgpc';

if(is_array($url)) {

  if ( isset($url['0']) ) { 
    $url = wp_get_attachment_image_url($url[0], 'large') ? wp_get_attachment_image_url($url[0], 'large') : get_poxy_featured(poxy_id());
  } else {
    $images = $url;
    foreach ( $images as $image ) {
      $url = $image["full_url"] ? $image["full_url"] : get_poxy_featured(poxy_id());
    }
  }
} elseif( is_numeric($url) ) {
  $url = wp_get_attachment_image_url($url, 'large') ? wp_get_attachment_image_url($url, 'large') : get_poxy_featured($url);
} else {
  $url = $url ? $url : get_poxy_featured( poxy_id(), $size );
}

//- $lazy_load_class = global__interactive__lazyload() ? ' lazyload ' : ' lazyloaded ';

?><div style="background-image: url(<?php echo $url; ?>); margin-top:-8%; margin-left:0%; width: 100%; height:120%;" data-rellax-speed="-5" class="image__container rellax fill bgr0 z3 <?php echo $class; ?> "></div><?php }

?><?php function poxy_get_image($url = '', $size = 'large') {
  
  if(is_array($url)) {
    if ( isset($url['0']) ) { 
      $url = wp_get_attachment_image_url($url[0], 'large') ? wp_get_attachment_image_url($url[0], 'large') : get_poxy_featured(poxy_id());
    } else {
      $images = $url;
      foreach ( $images as $image ) {
        $url = $image["full_url"] ? $image["full_url"] : get_poxy_featured(poxy_id());
      }
    }
    
  } else if( is_numeric($url) ) {
    $url = wp_get_attachment_image_url($url, 'large') ? wp_get_attachment_image_url($url, 'large') : get_poxy_featured(poxy_id());
  } else {
    $url = $url ? $url : get_poxy_featured( poxy_id(), $size );
  }
  
  return $url;?><?php }
?><?php function poxy_img($url = '', $class = '', $size = '') {
  //- $id = $id ? $id : poxy_id();
  $class = $class ? $class : '';
  $alt = '';
  
  if(is_array($url)) {
    if ( isset($url['0']) ) {
      $url = wp_get_attachment_image_url($url[0], $size) ? wp_get_attachment_image_url($url[0], $size) : get_poxy_featured(poxy_id());
      $alt = 'test';
    } else {
      $images = $url;
      foreach ( $images as $image ) {
        $url = $image["full_url"] ? $image["full_url"] : get_poxy_featured(poxy_id());
        $alt = $image["alt"] ? $image["alt"] : '';
      }
    }
    
  } else if( is_numeric($url) ) {
    $alt = get_post_meta($url, '_wp_attachment_image_alt', TRUE);
    $url = wp_get_attachment_image_url($url, $size) ? wp_get_attachment_image_url($url, $size) : get_poxy_featured(poxy_id());
    
  } else {
    $alt = get_post_meta(get_attachment_id($url), '_wp_attachment_image_alt', TRUE);
    $url = $url ? $url : get_poxy_featured( poxy_id(), $size );
  }
  //- $url = wp_get_attachment_image_url($id, $size) ? wp_get_attachment_image_url($id, $size) : get_poxy_featured($id);
  echo '<img style="width:100%; height:auto;" src="'. $url .'" alt="'. $alt .'" class="'. $class .'" />';
  ?><?php }
?><?php function poxy_section_image($url = false, $class = '') {
  $class = $class ? $class : 'bgsf bgpc';
  $url = $url ? $url : get_poxy_featured(poxy_id());?><div class="figure fill z1"><?php poxy_image($url, $class); ?></div><?php }
?><?php function poxy_svg($url = '', $color = '' ) {

  $file = poxy_get_image($url);
  $style = '-webkit-mask-image: url(' . $file . '); mask-image: url(' . $file . '); -webkit-mask-repeat: no-repeat;  mask-repeat: no-repeat;';
  $class = $color ? 'bgc__' . $color : '';
  ?><div style="<?php echo $style;?>" class="svg__container paxy fill bgsc bgr0 <?php echo $class; ?>"></div><?php }?>