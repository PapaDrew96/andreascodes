<?php get_header(); ?>

<section class="archive-projects py-5">
	<div class="container">
		<h1 class="section-heading text-center mb-5">All Projects</h1>

		 <div class="container">
            <?php get_template_part( 'template-parts/global/tech-stack-filter' ); ?>

        </div>

		<div class="row g-4 project-grid">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="col-md-6 project-card-wrapper">
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
							if ( $tech_terms && ! is_wp_error( $tech_terms ) ) :
                                // var_dump($tech_terms);
                                // die();
							?>
								<div class="project-stack d-flex flex-wrap gap-2 mt-3">
									<?php foreach ( $tech_terms as $term ) :
										$icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
										if ( $icon ) :
									?>
										<span class="stack-item">
											<img 
												src="<?php echo esc_url( $icon['url'] ); ?>" 
												alt="<?php echo esc_attr( $term->name ); ?>" 
												title="<?php echo esc_attr( $term->name ); ?>" 
												width="24" height="24"
												style="display: inline-block; border-radius: 4px;"
											/>
										</span>
									<?php endif; endforeach; ?>
								</div>
							<?php endif; ?>

							<a target="_blank" href="<?php the_permalink(); ?>" class="btn btn-sm mt-4 assign-btn">View Project</a>
						</div>
					</div>
				</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
