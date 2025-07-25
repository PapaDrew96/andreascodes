<?php

$project_summary = get_field('project_summary');

$projects = new WP_Query([
	'post_type'      => 'project',
	'posts_per_page' => 6,
	'post_status'    => 'publish',
]);
?>

<?php if ( $projects->have_posts() ) : ?>
<section class="frontpage-projects-section py-5 fade-in">
	<div class="container">
		<h2 class="section-heading text-center mb-5">Featured Projects</h2>

		<div class="row g-4 justify-content-center">
			<?php while ( $projects->have_posts() ) : $projects->the_post(); ?>
				<div class="col-md-4">
					<div class="project-card h-100 shadow-sm border rounded-4 overflow-hidden">
						

						<div class="project-content p-4">
							<h5 class="mb-2"><?php the_title(); ?></h5>
							<p class="small text-muted"><?php the_excerpt(); ?></p>
						</div>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<div class="text-center mt-5 custom-btn">
			<a target="_blank" href="<?php echo esc_url( home_url('/projects') ); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 magnetic">See All Projects →</a>
		</div>
	</div>
</section>
<?php endif; ?>
