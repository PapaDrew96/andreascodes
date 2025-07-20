<?php
/**
 * Template Name: About Me
 * Description: Custom About Page with ACF fields
 */

get_header();
?>
<canvas id="lightning-canvas" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none;"></canvas>





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