<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package andreas
 */

$footer_socials        = get_field('social_links','option');
$primar_menu_label    = get_field('primary_menu_label','option');
$secondary_menu_label = get_field('secondary_menu_label','option');

?>

	<footer id="colophon" class="site-footer py-5 border-top">
	<div class="container">
		<div class="row justify-content-between align-items-start g-5">
			<div class="col-md-4 align-items-start">
				<h5 class="mb-3"><?php echo esc_html($primar_menu_label); ?></h5>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-primary', // must match the register_nav_menus key
					'menu_class'     => 'list-unstyled footer-menu',
					'container'      => false,
				]);
				?>
			</div>

			<div class="col-md-4 align-items-start">
				<h5 class="mb-3"><?php echo esc_html($secondary_menu_label); ?></h5>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-secondary',
					'menu_class'     => 'list-unstyled footer-menu',
					'container'      => false,
				]);
				?>
			</div>

			<div class="col-md-4 align-items-start">
	<h5 class="mb-3">Connect</h5>

	<?php if ($footer_socials): ?>
		<div class="social-source d-flex flex-lg-column flex-row flex-wrap align-items-start justify-content-sm-start column-gap-sm-4">
			<ul class="nav social-icon flex-row align-items-center gap-3">
				<?php foreach ($footer_socials as $social): 
					$icon = $social['social_icon'];
					$url  = $social['social_url']; // now coming from a text field

					if ($icon && $url):
						$href = filter_var($url, FILTER_SANITIZE_URL); // still sanitize it
						$icon_url = esc_url($icon['url']);
						$icon_alt = esc_attr($icon['alt']);
				?>
					<li class="nav-item">
						<a href="<?php echo esc_attr($href); ?>" class="nav-link p-0"
						   <?php echo (strpos($href, 'http') === 0) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<img src="<?php echo $icon_url; ?>" alt="<?php echo $icon_alt; ?>" style="width: 24px; height: 24px;" />
						</a>
					</li>
				<?php 
					endif;
				endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>


			<!-- <div class="col-md-4">
				<h5 class="mb-3">From Me</h5>
				<blockquote class="footer-testimonial small fst-italic text-muted">
					<?php //echo esc_html( get_field('footer_testimonial', 'option') ); ?>
				</blockquote>
			</div>
		</div> -->

		<div class="text-left mt-4 small text-muted copyright">
			&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
