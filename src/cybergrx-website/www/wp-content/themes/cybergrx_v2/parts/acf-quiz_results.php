<?php ?>

<section class="quiz-results">
    <?php if (have_rows('results_')): ?>
        <li class="results">
            <h4>Thanks for taking the CyberGRX quiz. To learn more, set up a discussion with our experts<br>
                <a href="https://www.cybergrx.com/contact/">Schedule a Discussion with CyberGRX</a></h4>
            <p class="h2">Your CyberGRX Score is: <span id="score"></span></p>
        <?php while(have_rows('results')): the_row();
            $min_score = get_sub_field('minimum_score'); ?>
            <div class="tier" data-score="<?php echo $min_score; ?>">
                <article class="result_copy"><?php the_sub_field('result_copy'); ?></article>
                <h3></h3>
            </div>
        <?php endwhile; ?>
        </li>
    <?php endif; ?>
</section>
