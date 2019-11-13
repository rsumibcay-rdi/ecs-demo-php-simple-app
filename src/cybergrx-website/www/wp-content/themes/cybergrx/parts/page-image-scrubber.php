<div class="content-section image-scrubber">
    <div class="row">
        <div class="constrain-width">
            <?php the_sub_field('intro_content'); ?>
        </div>
        <div class="scrubber-row show-for-medium">
               <div class="start-block">
                 <?php $leftimgurl = get_sub_field('left_image'); ?>
                 <?php echo file_get_contents($leftimgurl); ?>
                 <h4><?php the_sub_field('left_image_label'); ?></h4>
                </div>
               <div class="ba-slider">
                   <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2b.jpg">
                   <div class="resize">
                       <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2.jpg">
                   </div>
                   <span class="handle"></span>
                </div>
                <div class="finish-block">
                    <?php $rightimgurl = get_sub_field('right_image'); ?>
                 <?php echo file_get_contents($rightimgurl); ?>
                    <h4><?php the_sub_field('right_image_label'); ?></h4>
                </div>
            </div><!--.scrubber-row-->

            <div class="scrubber-tabs hide-for-medium">
                <ul class="tabs" data-tabs id="example-tabs">
                  <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"> <?php echo file_get_contents('wp-content/uploads/2017/11/icon-human-error.svg'); ?></a></li>
                  <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php echo file_get_contents('wp-content/uploads/2017/11/icon-your-enterprise.svg'); ?></a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="example-tabs">
                  <div class="tabs-panel is-active" id="panel1">
                     <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2.jpg">
                  </div>
                  <div class="tabs-panel" id="panel2">
                    <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/11/scrubber2b.jpg">
                  </div>
                </div>
            </div>

    </div><!--.row-->
</div><!--.image-scrubber-->