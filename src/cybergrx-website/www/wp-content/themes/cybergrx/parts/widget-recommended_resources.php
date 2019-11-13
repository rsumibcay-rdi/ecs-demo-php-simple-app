<section class="recommended-resources">
    <p class="heading"><?php echo get_sub_field('heading'); ?></p>
    <?php while (have_rows('resources')): the_row(); {
        // code...
    } ?>
    <div class="resource">
        <div class="doc-icon"></div>
        <div class="titles">
            <p class="type"><?php echo get_sub_field('file_type'); ?></p>
            <a class="title" href="<?php echo get_sub_field('file')['url']; ?>"><?php echo get_sub_field('name'); ?></a>
        </div>
    </div>
    <?php endwhile; ?>
</section>
