<?php get_header(); ?>

<section class="archive-snippets-section">
	<div class="container">
		<h1 class="section-heading">Code Snippets</h1>
        <div class="container">
            <?php get_template_part( 'template-parts/global/tech-stack-filter' ); ?>

        </div>
		<?php if ( have_posts() ) : ?>
			<div class="snippet-grid code-snippet-card-wrapper">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="snippet-card">

                        <div class="snippet-header">
                            <h5><?php the_title(); ?></h5>
                            <div class="snippet-meta">
                                <?php the_time( get_option( 'date_format' ) ); ?>
                            </div>
                        </div>

                        <div class="snippet-body">
                            <code><?php echo esc_html( get_the_excerpt() ); ?></code>
                        </div>

                        <?php
                        $terms = get_the_terms( get_the_ID(), 'tech_stack' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                        ?>
                            <div class="snippet-tags">
                                <?php foreach ( $terms as $term ) :
                                    $icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
                                ?>
                                    <span class="tag d-flex align-items-center gap-1">
                                        <?php if ( $icon ) : ?>
                                            <img class="magnetic" src="<?php echo esc_url( $icon['url'] ); ?>" alt="" width="16" height="16">
                                        <?php endif; ?>
                                        <?php echo esc_html( $term->name ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- ✅ View Snippet Button -->
                        <div class="mt-3 px-3">
                            <a target="_blank" href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 view-snippet-btn">
                                View Snippet
                            </a>
                        </div>

                    </div>

				<?php endwhile; ?>
			</div>

			<div class="mt-5 text-center">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p class="text-muted text-center">No snippets found.</p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
