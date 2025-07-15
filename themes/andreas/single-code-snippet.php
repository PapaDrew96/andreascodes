<?php
get_header();

// Get fields
$tech_terms = get_the_terms( get_the_ID(), 'tech_stack' );
?>

<section class="single-snippet-section py-5">
  <div class="container">
    <div class="single-snippet-header text-center mb-4">
      <h1 class="mb-3"><?php the_title(); ?></h1>
      <?php if ( $tech_terms && ! is_wp_error( $tech_terms ) ) : ?>
        <div class="snippet-tags d-flex justify-content-center flex-wrap gap-2">
          <?php foreach ( $tech_terms as $term ) :
            $icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
          ?>
            <span class="tag d-flex align-items-center gap-1">
              <?php if ( $icon ) : ?>
                <img src="<?php echo esc_url( $icon['url'] ); ?>" width="18" height="18" alt="<?php echo esc_attr( $term->name ); ?>">
              <?php endif; ?>
              <?php echo esc_html( $term->name ); ?>
            </span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="snippet-content">
      <?php echo do_blocks( get_the_content() ); ?>
    </div>

    <div class="mt-5 text-center">
      <a href="<?php echo esc_url( get_post_type_archive_link( 'code-snippet' ) ); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">← Back to Snippets</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
