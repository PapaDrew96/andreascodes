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

?>

	<footer id="colophon" class="site-footer py-5 mt-5 border-top">
	<div class="container">
		<div class="row justify-content-between align-items-start g-5">
			<div class="col-md-4">
				<h5 class="mb-3">Quick Links</h5>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu',
					'menu_class'     => 'list-unstyled footer-menu',
					'container'      => false,
				]);
				?>
			</div>

			<div class="col-md-4">
				<h5 class="mb-3">Connect</h5>
				<?php if($footer_socials): ?>
                                    <div class="social-source d-flex flex-lg-column flex-row flex-wrap align-items-center align-items-md-start justify-content-center justify-content-sm-start column-gap-sm-4">
                                        <ul class="nav social-icon flex-row align-items-center column-gap-sm-4">
                                            <?php foreach($footer_socials as $social): 
                                                $icon = $social['social_icon'];
                                                $url  = $social['social_url'];
                                            ?>
                                                <li class="nav-items">
                                                    <a href="<?php echo esc_url($url); ?>" class="nav-link" target="_blank">
                                                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" />
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                        
									<?php endif; ?>
			</div>

			<!-- <div class="col-md-4">
				<h5 class="mb-3">From Me</h5>
				<blockquote class="footer-testimonial small fst-italic text-muted">
					<?php //echo esc_html( get_field('footer_testimonial', 'option') ); ?>
				</blockquote>
			</div>
		</div> -->

		<div class="text-center mt-4 small text-muted copyright">
			&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
