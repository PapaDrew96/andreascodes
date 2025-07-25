<?php get_header(); ?>

<section class="archive-projects py-5">
	<div class="container">
		<h1 class="section-heading text-center mb-5">Projects I've Contributed To</h1>
		<p class="text-center text-muted mb-5">A curated selection of work I've contributed to as a developer. Project details are anonymized to respect confidentiality agreements.</p>

		<div class="row g-4">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="col-md-12">
					<div class="p-4 border rounded-4 bg-light h-100 shadow-sm project-card-wrapper">
						<h5 class="mb-2"><?php the_title(); ?></h5>
						<p class="small text-muted mb-3"><?php echo wp_trim_words( get_field('summary') ); ?></p>

						
						
					</div>
				</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
