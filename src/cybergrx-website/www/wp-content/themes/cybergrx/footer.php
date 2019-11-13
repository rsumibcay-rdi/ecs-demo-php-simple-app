<?php
/**
 * The template for displaying the footer.
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */
 ?>

				<footer id="footer" class="footer" role="contentinfo">

			<div class="row">

				<div class="small-12 medium-12 large-3 columns has-map">
					<nav role="navigation">
						<a href="https://www.google.com/maps/place/CyberGRX/@39.7516813,-105.0015534,16.91z/data=!4m5!3m4!1s0x0:0x6fba0a976e91bfe4!8m2!3d39.751989!4d-104.999578"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/CyberGRX_Map1.png" alt="CyberGRX Location" /></a>
					</nav>
				</div>
				<div class="small-12 medium-12 large-9 columns">
					<nav role="navigation">
						<?php joints_footer_links(); ?>
					</nav>
				</div>

			</div>

			<div class="row copyright-row">

				<div class="small-12 medium-6 large-6 columns">
					&copy; <?php echo date('Y'); ?> CyberGRX - The Third Party Cyber Risk Exchange
				</div>
				<div class="small-12 medium-6 large-6 columns">
					<a href="https://www.cybergrx.com/privacy-policy/"> Privacy Policy</a>
				</div>

			</div>


		</footer> <!-- end .footer -->

		<?php wp_footer(); ?>

		<?php the_field('before_closing_body', 'option'); ?>

	</body>
</html> <!-- end page -->
