<?php
$cta_heading = get_field('cta_heading');
$cta_subtext = get_field('cta_subtext');
$cta_button_text = get_field('cta_button_text');
$cta_button_link = get_field('cta_button_link');
$cta_background = get_field('cta_background');
$bg_url = $cta_background['url'] ?? '';
?>

<?php if ( $cta_heading ): ?>
<section class="frontpage-cta-section fade-in" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
	<div class="cta-overlay d-flex flex-column justify-content-center text-center text-white">
		<h2 class="cta-heading"><?php echo esc_html($cta_heading); ?></h2>

		<?php if ( $cta_subtext ): ?>
			<p class="cta-subtext lead mt-2"><?php echo esc_html($cta_subtext); ?></p>
		<?php endif; ?>

		<?php if ( $cta_button_text && $cta_button_link ): ?>
			<a target="_blank" href="<?php echo esc_url($cta_button_link); ?>" class="btn btn-light btn-lg mt-4 px-5 py-3 rounded-pill">
				<?php echo esc_html($cta_button_text); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>
