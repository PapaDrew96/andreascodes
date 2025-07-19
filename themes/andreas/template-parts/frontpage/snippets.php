<?php
$snippets = new WP_Query([
	'post_type'      => 'code-snippet',
	'posts_per_page' => 6,
	'post_status'    => 'publish',
]);
?>

<?php if ( $snippets->have_posts() ) : ?>
<section class="frontpage-snippets-section py-5 fade-in">
	<div class="container">
		<h2 class="section-heading text-center mb-4">Developer Snippets</h2>

		<div class="snippet-scroller-wrapper">
			<div class="snippet-scroller">
				<?php while ( $snippets->have_posts() ) : $snippets->the_post(); ?>
					<article class="snippet-item">
						<h5><?php the_title(); ?></h5>
						<p class="snippet-desc"><?php echo get_the_excerpt(); ?></p>

						<?php
						$types = get_the_terms( get_the_ID(), 'snippet_type' );
						$techs = get_the_terms( get_the_ID(), 'tech_stack' );
						?>
						<div class="snippet-meta">
							<?php if ( $types && !is_wp_error( $types ) ) : ?>
								<?php foreach ( $types as $type ) : ?>
									<span class="badge bg-secondary"><?php echo esc_html( $type->name ); ?></span>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if ( $techs && !is_wp_error( $techs ) ) : ?>
								<?php foreach ( $techs as $tech ) : ?>
									<span class="badge bg-light text-dark border">
										<?php
										$icon = get_field('snippet_icon', 'term_' . $tech->term_id);
										if ( $icon ) :
											echo '<img src="' . esc_url($icon['url']) . '" alt="' . esc_attr($tech->name) . '" width="16" height="16" class="me-1">';
										endif;
										?>
										<?php echo esc_html( $tech->name ); ?>
									</span>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>

						<a href="<?php the_permalink(); ?>" class="view-code small d-block mt-3">View Code →</a>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>

		<div class="text-center mt-4 custom-btn">
			<a href="<?php echo esc_url( home_url('/code-snippets') ); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">See All Snippets →</a>
		</div>
	</div>
</section>
<?php endif; ?>