<?php
/**
 * Template Name: About Me
 * Description: Custom About Page with ACF fields
 */

get_header();
?>

<section class="about-section py-5 ">
	<div class="container">
	
	<?php
	get_template_part('template-parts/about/intro');
	get_template_part('template-parts/about/tech');
	get_template_part('template-parts/about/services');
	get_template_part('template-parts/about/timeline');
	get_template_part('template-parts/about/values');
	get_template_part('template-parts/about/cta');
		?>

	</div>
</section>

<?php get_footer(); ?>