<?php
/**
 * Single Project Template
 * @package andreas
 */

get_header();

$summary     = get_field('summary');
$live_url    = get_field('live_url');
// $github_url  = get_field('github_url');
$gallery     = get_field('gallery');
$highlights  = get_field('highlights');
$tech_terms  = get_the_terms(get_the_ID(), 'tech_stack');
$project_role = get_field('project_role');
?>

<section class="single-project py-5">
  <div class="container">
    <div class="project-header text-center mb-5">
      <h1 class="display-4"><?php the_title(); ?></h1>
      <?php if ($project_role): ?>
        <p class="lead mt-3">My Role: <?php echo esc_html($project_role); ?></p>
      <?php endif; ?>
      <?php if ($summary): ?>
        <p class="lead mt-3"><?php echo esc_html($summary); ?></p>
      <?php endif; ?>

      <?php if ($tech_terms && !is_wp_error($tech_terms)) : ?>
        <div class="project-stack d-flex flex-wrap justify-content-center gap-2 mt-3">
          <?php foreach ($tech_terms as $term) :
            $icon = get_field('icon', 'tech_stack_' . $term->term_id);
          ?>
            <span class="stack-item d-flex align-items-center gap-2">
              <?php if ($icon): ?>
                <img src="<?php echo esc_url($icon['url']); ?>" alt="" width="20" height="20">
              <?php endif; ?>
              <span class="text-muted small"><?php echo esc_html($term->name); ?></span>
            </span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="project-content row g-5">
      <div class="col-lg-8">
        <?php if ($highlights): ?>
          <div class="project-highlights mb-5">
            <h3 class="mb-4">Key Highlights</h3>
            <div class="row g-4">
              <?php foreach ($highlights as $item): ?>
                <div class="col-md-6">
                  <div class="highlight-card p-4 border rounded-3 bg-light h-100">
                    <h5><?php echo esc_html($item['title']); ?></h5>
                    <p class="small text-muted"><?php echo esc_html($item['text']); ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if ( $gallery ) : ?>
        <div class="project-gallery row g-3">
            <?php foreach ( $gallery as $image ) : ?>
                <div class="col-md-4">
                    <a href="<?php echo esc_url( $image['url'] ); ?>"   data-fancybox="project-gallery">
                        <img src="<?php echo esc_url( $image['sizes']['medium_large'] ); ?>" alt="" class="img-fluid rounded-3" />
                    </a>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
      </div>

      <div class="col-lg-4">
        <div class="project-links sticky-top pt-3">
          <h5 class="mb-3">Links</h5>
          <?php if ($live_url): ?>
            <a href="<?php echo esc_url($live_url); ?>" class="btn btn-primary w-100 mb-3" target="_blank">View Live</a>
          <?php endif; ?>
         
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
