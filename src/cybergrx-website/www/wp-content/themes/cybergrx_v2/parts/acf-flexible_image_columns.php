<?php
    $bg = get_sub_field('background_color');
    $heading = get_sub_field('heading'); ?>

<section class="flexible-image-columns <?php echo $bg; ?>">
    <?php if ($heading) { echo '<h2>'. $heading. '</h2>'; } ?>
    <ul class="columns row">
        <?php while (have_rows('columns')): the_row(); ?>
            <li class="article">
                <?php
                    if (get_sub_field('text')){ echo '<p class="text">'. get_sub_field('text'). '</p>'; }
                    if (get_sub_field('image')){ echo '<img src="'. get_sub_field('image'). '">'; }
                    ?>
            </li>
        <?php endwhile; ?>
    </ul>
</section>
