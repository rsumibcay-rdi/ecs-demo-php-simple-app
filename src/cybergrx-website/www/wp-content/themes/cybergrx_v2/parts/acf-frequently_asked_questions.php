<div class="content-section faq-row">

   <div class="row">

   <h2 class="section-title"><?php the_sub_field('section_title'); ?></h2>

  <?php
   $posts = get_sub_field('selected_faqs');
   if( $posts ): ?>
	   <ul class="accordion" data-accordion>
	   <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
		   <?php setup_postdata($post); ?>
		   <li class="accordion-item" data-accordion-item>
			   <!-- Accordion tab title -->
			   <a href="#" class="accordion-title"><?php the_title(); ?></a>

			   <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
			   <div class="accordion-content" data-tab-content>
				 <?php the_content(); ?>
			   </div>
			 </li>
	   <?php endforeach; ?>
	   </ul><!--.accordion-->
	   <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
   <?php endif; ?>

	</div><!--.row-->

</div><!--.content-section-->
