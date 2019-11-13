<?php
    $group = 0;

    $page_id = get_the_ID();
    $module_key = false;
	$modules = get_post_meta($page_id, 'custom_sections', true);
	foreach ((array) $modules as $index => $layout){
        if ($layout === 'quiz_module'){
            $module_key = 'custom_sections_'.$index.'_';
            break;
        }
    }
    // zen_debug(get_sub_field('results', '126'));
?>

<section id="quiz" class="quiz-module content-section" data-id="<?php echo $page_id; ?>" data-key="<?php echo base64_encode($module_key); ?>" data-hsform="<?php the_sub_field('hubspot_form_id'); ?>">
    <?php if (get_sub_field('heading')): ?><h2><?php the_sub_field('heading'); ?></h2><?php endif; ?>
    <?php if (get_sub_field('subheading')): ?><p><?php the_sub_field('subheading'); ?></p><?php endif; ?>
    <div class="progress-bar row"><span id="progress-inner"></span></div>
    <?php if (have_rows('questions')): ?>
        <div class="slide-window row">
            <ul id="slider" class="questions row">
            <?php while (have_rows('questions')): the_row(); ?>
                <li class="question" data-hsfield="<?php echo get_sub_field('hubspot_field_id'); ?>">
                    <h3><?php the_sub_field('question_text'); ?></h3>
                    <ul class="answers">
                        <?php while (have_rows('answers')): the_row(); ?>
                            <li>
                                <label>
                                    <input type="radio" class="radio" name="group-<?php echo $group; ?>" data-points="<?php echo get_sub_field('value'); ?>">
                                    <?php the_sub_field('answer_text'); ?>
                                </label>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </li>
            <?php $group++; endwhile; ?>
            <li class="contact-form">
                <p>Thank you for submitting your questionnaire! Please fill the form below to see your scores:</p>
                <?php echo do_shortcode('[hf_form slug="quiz-form"]'); ?>
            </li>
        </ul>
        </div><?php endif; ?>
        <div class="row btn-group">
            <button id="previous" type="" class="button previous secondary" name="button">Previous</button>
            <button id="next" type="" class="button next" name="button" disabled>Next</button>
        </div>
</section>
