<?php
$headline    = get_field('hero_headline');
$subtitle    = get_field('hero_subtitle');
$cta_text    = get_field('hero_cta_text');
$cta_link    = get_field('hero_cta_link');
$background  = get_field('hero_background');
$bg_url      = $background ? $background['url'] : '';
?>

<section class="hero-section d-flex align-items-center text-center" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
	<div class="container">
		<div class="hero-content mx-auto">
			<?php if ($headline): ?>
				<h1 class="hero-title mb-3"><?php echo esc_html($headline); ?></h1>
			<?php endif; ?>

			<?php if ($subtitle): ?>
				<p class="hero-subtitle mb-4"><?php echo esc_html($subtitle); ?></p>
			<?php endif; ?>

			<?php if ($cta_text && $cta_link): ?>
				<a href="<?php echo esc_url($cta_link); ?>" class="btn btn-primary btn-lg assign-btn">
					<?php echo esc_html($cta_text); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
