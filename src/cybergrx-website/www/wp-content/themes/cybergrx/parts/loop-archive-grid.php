<?php
/**
 * The template part for displaying a grid of posts
 *
 * For more info: http://cybergrx.com/docs/grid-archive/
 */

// Adjust the amount of rows in the grid
//$grid_columns = 4; ?>


		<!--Item: -->

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article">

				<section class="featured-image" itemprop="articleBody">
					<div class="post-image" style="background-image: url('<?php the_post_thumbnail_url('large'); ?>'); ">
					</>
					<div class="article-header">
						<p class="date"><?php echo get_the_date('F j, Y'); ?></p>
						<h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
						<a class="more" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<p class="moving-caret">Read More</p>
						</a>
					</div>
				</section> <!-- end article section -->

				<?php /*<header class="article-header">
					<h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<?php get_template_part( 'parts/content', 'byline' ); ?>
				</header> <!-- end article header -->

				<section class="entry-content" itemprop="articleBody">
					<?php the_content('<button class="tiny">' . __( 'Read more...', 'cybergrx' ) . '</button>'); ?>
				</section> <!-- end article section --> */ ?>

			</article> <!-- end article -->


<?php //endif; ?>
