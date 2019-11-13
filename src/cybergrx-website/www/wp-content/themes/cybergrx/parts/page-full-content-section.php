<div class="content-section <?php if(get_sub_field('background_video')) { echo 'has-video'; } elseif(get_sub_field('background_image')) { echo 'has-bgimg'; } elseif (get_sub_field('background_color')) { echo 'bg-'.get_sub_field('background_color').''; } ?>" <?php if(get_sub_field('background_image')) { echo 'style="background-image: url('.get_sub_field('background_image').');"'; } ?>>
     <?php if(get_sub_field('background_video')): ?>
    <div class="video-bg">
        <video autoplay loop muted poster="<?php the_sub_field('video_poster_image'); ?>">
            <source src="<?php the_sub_field('background_video'); ?>" type="video/mp4">
        </video>
    </div>
    <?php endif; ?>

    <div class="inner-content row">
        <?php if( have_rows('content_types') ): while ( have_rows('content_types') ) : the_row(); ?>

            <?php /*Intro Title*/ if(get_row_layout() == 'intro_title') { echo '<div class="intro-title">'.get_sub_field('title_text_intro').'</div>'; } ?>

             <?php /*Title*/ if(get_row_layout() == 'standard_title') { echo '<h1 class="emphasized-title" style="font-weight: 700;">'.get_sub_field('title_text').'</h1>'; } ?>

             <?php /*Buttons*/ if(get_row_layout() == 'button_group') { echo '<a class="button" href="'.get_sub_field('button_link').'">'.get_sub_field('button_text').'</a>'; if(get_sub_field('button_text_2')): echo '<a class="button" href="'.get_sub_field('button_link').'">'.get_sub_field('button_text').'</a>'; endif; } ?>

             <?php /*Content Editor*/ if(get_row_layout() == 'standard_content') { echo '<div class="constrain-width">'.get_sub_field('text_content').'</div>'; } ?>

             <?php /*Two column content*/ if(get_row_layout() == 'two_col_content'): ?>

                <div class="row two-col-row">
                    <div class="columns large-6 medium-10 small-12">
                        <?php the_sub_field('col_one_content'); ?>
                    </div>
                    <div class="columns large-6 medium-10 small-12">
                        <?php the_sub_field('col_two_content'); ?>
                    </div>
                </div>

            <?php endif; ?>

             <?php /*Case Study*/ if(get_row_layout() == 'case_study'): ?>
                <?php
                    $post_object = get_sub_field('featured_case_study');
                    if( $post_object ):
                        // override $post
                        $post = $post_object;
                        setup_postdata( $post );
                        ?>
                        <div class="study-quote">
                            <?php the_content(); ?>
                        </div>
                        <div class="tagline">
                            <div class="photo-wrapper">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                            <div class="quote-attribution">
                                &ndash; <strong><?php the_title(); ?></strong>, <?php the_field('quote_title'); ?>
                            </div>
                        </div>
                        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                    <?php endif; ?>
            <?php /* end Case Study*/ endif; ?>

             <?php /*Bios*/ if(get_row_layout() == 'bios'): ?>
                    <?php
                    $posts = get_sub_field('selected_bios');
                    if( $posts ): ?>
                    <div class="bios-row">
                    <ul class="people-list">
                       <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
                        <?php setup_postdata($post); ?>
                          <li class="person load-inline columns large-4 medium-4 small-12">
                            <a href="<?php the_permalink(); ?>" class="bio-link load-bio">
                                <?php the_post_thumbnail('large-thumb'); ?>
                                <h3><?php the_title(); ?></h3>
                                <h4><?php the_field('bio_title'); ?></h4>
                            </a>
                        </li>
                       <?php endforeach; ?>
                    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
                    <!--Extra markup for Ajax logic-->
                    <li style="display:none;"></li>
                    <li style="display:none;"></li>
                    <li style="display:none;"></li>
                    </ul>
                    <div id="load-inline-container">
                        <div id="load-inline-content"></div>
                        <span id="close-inline" class="close-window"></span>
                    </div>
                    <!-- Ajax loading messages. -->
                    <!--<div id="load-msg"></div>-->
                    </div><!--.bios-row-->
                    <?php endif; ?>
            <?php /* end Bios*/ endif; ?>


             <?php /*Pie Charts*/ if(get_row_layout() == 'pie_charts'): ?>
                <?php if(get_sub_field('pie_chart')): ?>
                    <div class="chart-row">
                    <?php while(has_sub_field('pie_chart')): ?>
                         <div class="chart" data-percent="<?php the_sub_field('percent_number'); ?>"><div class="chart-percent"><span><?php the_sub_field('percent_number'); ?></span>%</div>
                            <div class="chart-label"><?php the_sub_field('percent_label'); ?></div></div>
                    <?php endwhile; ?>
                    </div><!--.chart-row-->
                <?php endif; ?>
             <?php endif; /*End Pie Charts*/ ?>

              <?php /*3 Column Grid*/ if(get_row_layout() == '3_column_grid'): ?>
              <div class="grid-row">
                <div class="row">
                    <div class="columns small-12 medium-4 large-4">
                        <?php $colimg1 = get_sub_field('content_image_1'); ?>
                        <?php echo wp_get_attachment_image($colimg1, 'large-thumb'); ?>
                        <h3><?php the_sub_field('content_title'); ?></h3>
                        <div class="content-block">
                            <?php the_sub_field('content_column_1'); ?>
                        </div>
                    </div>
                    <div class="columns small-12 medium-4 large-4">
                        <?php $colimg2 = get_sub_field('content_image_2'); ?>
                        <?php echo wp_get_attachment_image($colimg2, 'large-thumb'); ?>
                        <h3><?php the_sub_field('content_title_2'); ?></h3>
                        <div class="content-block">
                            <?php the_sub_field('content_column_2'); ?>
                        </div>
                    </div>
                    <div class="columns small-12 medium-4 large-4">
                        <?php $colimg3 = get_sub_field('content_image_3'); ?>
                        <?php echo wp_get_attachment_image($colimg3, 'large-thumb'); ?>
                        <h3><?php the_sub_field('content_title_3'); ?></h3>
                        <div class="content-block">
                            <?php the_sub_field('content_column_3'); ?>
                        </div>
                    </div>
                </div><!--.row-->
            </div><!--.grid-row-->
             <?php endif; /*3 Column Grid*/ ?>

             <?php /*Partners Gallery*/ if(get_row_layout() == 'partners'): ?>

               <div class="logos-row">
                    <div class="row">
                    <?php

                    $images = get_sub_field('partner_logos');
                    $size = 'medium'; // (thumbnail, medium, large, full or custom size)

                    /*DESKTOP*/if( $images ): ?>
                        <ul class="show-for-medium">
                            <?php foreach( $images as $image ): ?>
                                <li>
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php

                    /*MOBILE*/$imagesmobile = get_sub_field('partner_logos');
                    $size = 'medium'; // (thumbnail, medium, large, full or custom size)

                    if( $images ): ?>
                    <div class="hide-for-medium orbit" data-orbit="">
                        <ul class="orbit-container">
                            <?php $count = 0; foreach( $imagesmobile as $image ): ?>
                                <li class="orbit-slide  <?php if ( $count == 0 ) { echo 'is-active'; } ?>">
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                </li>
                            <?php $count++; endforeach; ?>
                        </ul>

                    <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span> <i class="fa fa-angle-left"></i></button>
                    <button class="orbit-next"><span class="show-for-sr">Next Slide</span> <i class="fa fa-angle-right"></i></button>
                    </div>
                    <?php endif; ?>
                </div><!--.row-->
                </div><!--.logos-row-->

            <?php endif; ?>


             <?php /*Icon List*/ if(get_row_layout() == 'icon_list'): ?>
                <?php if(get_sub_field('icons')): ?>
                    <div class="row icon-list">
                    <?php while(has_sub_field('icons')): ?>
                        <div class="columns large-4 medium-6 small-12">
                             <?php //embed SVG so we can change color on hover
                            $icon = get_sub_field( 'icon_img' );
                            if ( !empty( $icon ) ):
                            echo file_get_contents( $icon ) ;
                            endif; ?>
                            <span class="icon-label"><?php the_sub_field('icon_title'); ?></span>
                        </div>
                    <?php endwhile; ?>
                    </div><!--.row-->
                <?php endif; ?>
             <?php endif; /*Icon List*/ ?>


             <?php /*image scrubber*/ if(get_row_layout() == 'image_scrubber'): ?>
             <div class="scrubber-row show-for-large">
               <div class="start-block">
                 <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/Screen-Shot-2017-11-17-at-12.34.50-PM.png" />
                </div>
                <div class="ba-slider">
                   <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2b.png">
                   <div class="resize">
                       <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2.png">
                   </div>
                   <span class="handle"></span>
                </div>
                <div class="finish-block">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/Screen-Shot-2017-11-17-at-12.35.06-PM.png" />
                </div>
            </div><!--.scrubber-row-->
            <?php endif; /*End image scrubber*/ ?>
        <?php endwhile; endif; ?>
    </div>
</div>
