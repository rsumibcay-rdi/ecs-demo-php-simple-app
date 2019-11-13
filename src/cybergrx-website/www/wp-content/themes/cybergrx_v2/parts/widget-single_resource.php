<?php  $resource = get_sub_field('resource')[0];
    if (get_queried_object_id() == $resource->ID){
        return;
    }
?>
<div class="posts-row">
<div class="blog-grid-row">
<div class="big-blog">

<article class="featured-image" itemprop="articleBody">
    <div class="post-image" style="background-image: url('<?php echo get_the_post_thumbnail_url($resource, 'large'); ?>'); ">
    <div class="article-header">
        <h3 class="title"><a href="<?php echo get_permalink($resource) ?>" rel="bookmark" title=""><?php echo $resource->post_title; ?></a></h3>
        <a class="more" href="<?php echo get_permalink($resource) ?>" rel="bookmark" title="<?php esc_attr($resource->post_title); ?>">
            <p class="moving-caret">Read More</p>
        </a>
    </div>
</article> <!-- end article section -->
</div>
</div>
</div>
