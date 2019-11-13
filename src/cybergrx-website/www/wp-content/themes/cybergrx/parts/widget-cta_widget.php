<section class="cta-widget">
    <p class="heading"><?php the_sub_field('heading'); ?></p>
    <p><?php the_sub_field('subheading'); ?></p>
    <a class="button" href="<?php echo get_sub_field('cta_button')['url'] ?>"><?php echo get_sub_field('cta_button')['title']; ?></a>
    <p><?php the_sub_field('under-button_copy'); ?></p>
    <ul class="social">
        <?php while (have_rows('social_media_links')): the_row(); ?>
        <li class="icon"><a href="<?php echo get_sub_field('url'); ?>"><?php echo zen_inline_if_svg(get_sub_field('icon')); ?></a></li>
        <?php endwhile; ?>
    </ul>
</section>
