<?php
/**
 * Template Name: About Me
 * Description: Custom About Page with ACF fields
 */

get_header();

// Intro Group
$intro         = get_field('about_intro');
$intro_title   = $intro['title'] ?? '';
$intro_text    = $intro['text'] ?? '';
$intro_image   = $intro['image'] ?? '';

// Tech Expertise
$tech_list = get_field('tech_expertise');

// Services
$services = get_field('about_services');

// Timeline
$timeline = get_field('experience_timeline');

// Core Values
$core_values = get_field('core_values');

// CTA Group
$cta         = get_field('final_cta');
$cta_text    = $cta['text'] ?? '';
$cta_btn_txt = $cta['button_text'] ?? '';
$cta_btn_url = $cta['button_link'] ?? '';
?>

<section class="about-section py-5">
	<div class="container">

		<!-- 🔹 Intro Section -->
		<?php if ( $intro_title || $intro_text ) : ?>
		<div class="intro-section text-center mb-5">
			<?php if ( $intro_title ) : ?>
				<h1 class="display-4"><?php echo esc_html($intro_title); ?></h1>
			<?php endif; ?>
			<?php if ( $intro_text ) : ?>
				<p class="lead mt-3"><?php echo esc_html($intro_text); ?></p>
			<?php endif; ?>
			<?php if ( $intro_image ) : ?>
				<img src="<?php echo esc_url($intro_image['url']); ?>" alt="" class="img-fluid rounded mt-4" />
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<!-- 🔹 Tech Expertise -->
		<?php if ( $tech_list ) : ?>
		<div class="tech-section mb-5">
			<h2 class="text-center mb-4">Technical Expertise</h2>
			<ul class="list-inline text-center">
				<?php foreach ( $tech_list as $tech ) : ?>
					<li class="list-inline-item px-3 py-2 m-2 bg-light border rounded-pill">
						<?php if ( !empty($tech['icon']) ) : ?>
							<img src="<?php echo esc_url($tech['icon']['url']); ?>" width="20" height="20" class="me-1" />
						<?php endif; ?>
						<?php echo esc_html($tech['label']); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

		<!-- 🔹 Services Overview -->
		<?php if ( $services ) : ?>
		<div class="services-section mb-5">
			<h2 class="text-center mb-4">What I Do</h2>
			<div class="row g-4">
				<?php foreach ( $services as $service ) : ?>
				<div class="col-md-4">
					<div class="p-4 border rounded-3 h-100 text-center bg-light">
						<h5><?php echo esc_html($service['title']); ?></h5>
						<p class="text-muted"><?php echo esc_html($service['description']); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- 🔹 Experience Timeline -->
		<?php if ( $timeline ) : ?>
		<div class="timeline-section mb-5">
			<h2 class="text-center mb-4">Timeline</h2>
			<ul class="timeline list-unstyled">
				<?php foreach ( $timeline as $item ) : ?>
				<li class="mb-4">
					<strong><?php echo esc_html($item['title']); ?></strong><br>
					<small class="text-muted"><?php echo esc_html($item['year']); ?></small>
					<p class="mt-2"><?php echo esc_html($item['description']); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

		<!-- 🔹 Core Values -->
		<?php if ( $core_values ) : ?>
		<div class="values-section mb-5">
			<h2 class="text-center mb-4">Core Values</h2>
			<div class="row g-4">
				<?php foreach ( $core_values as $value ) : ?>
				<div class="col-md-4">
					<div class="p-4 border rounded-3 h-100 text-center bg-light">
						<strong><?php echo esc_html($value['title']); ?></strong>
						<p class="small mt-2"><?php echo esc_html($value['description']); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- 🔹 Final CTA -->
		<?php if ( $cta_text && $cta_btn_txt && $cta_btn_url ) : ?>
		<div class="final-cta-section text-center mt-5">
			<p class="lead mb-3"><?php echo esc_html($cta_text); ?></p>
			<a href="<?php echo esc_url($cta_btn_url); ?>" class="btn cta-glow-animate btn-primary btn-lg rounded-pill px-4">
				<?php echo esc_html($cta_btn_txt); ?>
			</a>
		</div>
		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
