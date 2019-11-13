<?php
$stats = '';

if (have_rows('stats')){
    while (have_rows('stats')){
        the_row();
        $name = get_sub_field('name');
        if ($name){
            $value = get_if_newer($name, get_sub_field('data_path'));
            if ($value){
                $stats .= '<div class="stat"><p class="value stat-num" data-to="'. $value. '">'. number_format($value). '</p><p class="text">'. get_sub_field('stat_text'). '</p></div>';
            }
        }
    }
}
?>
<section class="stats-ticker-bar animate" data-on-inview="count_up">
    <div class="stats row">
        <?php echo $stats; ?>
    </div>
</section>
