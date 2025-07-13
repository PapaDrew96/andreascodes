<?php
$projects = new WP_Query([
	'post_type'      => 'project',
	'posts_per_page' => 3,
	'post_status'    => 'publish',
]);
?>

<?php if ( $projects->have_posts() ) : ?>
<section class="frontpage-projects-section py-5">
	<div class="container">
		<h2 class="section-heading text-center mb-5">Featured Projects</h2>

		<div class="row g-4 justify-content-center">
			<?php while ( $projects->have_posts() ) : $projects->the_post(); ?>
				<div class="col-md-4">
					<div class="project-card h-100 shadow-sm border rounded-4 overflow-hidden">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="project-thumb">
								<?php the_post_thumbnail( 'medium_large', ['class' => 'img-fluid w-100'] ); ?>
							</div>
						<?php endif; ?>

						<div class="project-content p-4">
							<h5 class="mb-2"><?php the_title(); ?></h5>
							<p class="small text-muted"><?php the_excerpt(); ?></p>

							<?php
							$tech_terms = get_the_terms( get_the_ID(), 'tech_stack' );
							if ( $tech_terms && !is_wp_error( $tech_terms ) ) :
							?>
								<div class="project-stack d-flex flex-wrap gap-2 mt-3">
									<?php foreach ( $tech_terms as $term ) :
										$icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
									?>
										<span class="stack-item d-flex align-items-center gap-2 small text-muted bg-light px-2 py-1 rounded-pill">
											<?php if ( $icon ) : ?>
												<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" width="18" height="18" />
											<?php endif; ?>
											<?php echo esc_html( $term->name ); ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="btn btn-sm mt-4 assign-btn">View Project</a>
						</div>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<div class="text-center mt-5 custom-btn">
			<a href="<?php echo esc_url( home_url('/projects') ); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">See All Projects →</a>
		</div>
	</div>
</section>
<?php endif; ?>
