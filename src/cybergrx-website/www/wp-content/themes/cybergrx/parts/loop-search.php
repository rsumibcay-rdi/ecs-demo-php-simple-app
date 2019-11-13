<?php
/**
 * Template part for displaying posts
 *
 * Used for single, index, archive, search.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">					
	
	<header class="article-header">
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
	</header> <!-- end article header -->
					
	<section class="entry-content" itemprop="articleBody">
		<?php the_excerpt(); ?>
	</section> <!-- end article section -->	
				    						
</article> <!-- end article -->