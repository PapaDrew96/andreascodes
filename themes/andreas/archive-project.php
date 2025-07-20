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

						<?php
						$tech_terms = get_the_terms( get_the_ID(), 'tech_stack' );
						if ( $tech_terms && ! is_wp_error( $tech_terms ) ) : ?>
							<div class="d-flex flex-wrap gap-2">
								<?php foreach ( $tech_terms as $term ) :
									$icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
									if ( $icon ) : ?>
									<span class="stack-item d-flex align-items-center gap-1">
										<img 
											class="magnetic"
											src="<?php echo esc_url( $icon['url'] ); ?>" 
											alt="<?php echo esc_attr( $term->name ); ?>" 
											title="<?php echo esc_attr( $term->name ); ?>" 
											width="20" height="20"
											style="border-radius: 4px;"
										/>
										<small class="text-muted"><?php echo esc_html( $term->name ); ?></small>
									</span>
								<?php endif; endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
