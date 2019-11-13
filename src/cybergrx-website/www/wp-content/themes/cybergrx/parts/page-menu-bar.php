<div class="content-section menu-bar">
    <div class="row" data-equalizer data-equalize-on="medium">
    <?php if(get_sub_field('menu_items')): ?>
        <?php while(has_sub_field('menu_items')): ?>
        <div class="medium-4 large-4 small-12 columns" data-equalizer-watch>
            <a href="<?php the_sub_field('item_link'); ?>">
                <h3><?php the_sub_field('text_title'); ?></h3>
                <p><?php echo get_sub_field('text_desc'); ?></p>
            </a>
        </div>
        <?php endwhile; endif; ?>
    </div>
</div>