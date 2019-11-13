<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

get_header(); ?>

    <div class="content">


            <main class="main" role="main">

                <div class="content-section has-bgimg" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_option( 'page_for_posts' ), 'large' ); ?>);">
                    <div class="inner-content row">
                        <div class="row two-col-row">
                            <div class="columns large-6 medium-6 small-12">
                                <h1><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row blog-row">

                    <div class="nav-row">
                        <?php
                            $nav = $prenav = array();
                            $prenav['View All'] = get_permalink( get_option( 'page_for_posts' ) );
                            $categories = get_categories();
                            foreach ($categories as $category){
                                $nav[ $category->name ] = get_category_link( $category );
                            }
                            $nav = array_merge($prenav, $nav);
                            $nav_lis = '';
                            foreach ($nav as $name => $link){
                                $class = '';
                                $this_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . '://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
                                if ($link === $this_url) {$class = ' class="current-menu-item"';}
                                $nav_lis .= '<li'.$class.'><a href="'. $link .'">'. $name .'</a></li>';
                            }
                        ?>
                        <?php echo get_search_form(); ?>
                        <nav class="page-torso__inner blog-nav"><ul class="uppercase"><?php echo $nav_lis; ?></ul></nav>
                    </div>
                    <div class="posts-row"> <!--Begin Grid-->

                        <div class="blog-grid-row">
                            <div class="big-blog">
                    <?php
                        if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <?php if ($wp_query->current_post > 0 && $wp_query->current_post % 3 === 0) : ?>
                            </div>
                        </div>
                        <div class="blog-grid-row">
                            <div class="big-blog">
                            <?php elseif ($wp_query->current_post % 3 === 1 ) : ?>
                            </div>
                            <div class="baby-blogs">
                        <?php endif; ?>
                        <?php get_template_part( 'parts/loop', 'archive-grid' ); ?>

                    <?php endwhile; ?>
                            </div>
                        </div>

                        <?php joints_page_navi(); ?>

                    <?php else : ?>

                        <?php get_template_part( 'parts/content', 'missing' ); ?>

                    <?php endif; ?>

                    </div><!--.posts-row-->

                </div><!--.row-->

            </main> <!-- end #main -->

            <?php //get_sidebar(); ?>

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>
