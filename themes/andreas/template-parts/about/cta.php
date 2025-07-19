<?php
$cta         = get_field('final_cta');
$cta_text    = $cta['text'] ?? '';
$cta_btn_txt = $cta['button_text'] ?? '';
$cta_btn_url = $cta['button_link'] ?? '';
?>

<!-- 🔹 Final CTA -->
		<?php if ( $cta_text && $cta_btn_txt && $cta_btn_url ) : ?>
		<div class="final-cta-section text-center mt-5 fade-in">
			<p class="lead mb-3"><?php echo esc_html($cta_text); ?></p>
			<a href="<?php echo esc_url($cta_btn_url); ?>" class="btn cta-glow-animate btn-primary btn-lg rounded-pill px-4 magnetic">
				<?php echo esc_html($cta_btn_txt); ?>
			</a>
		</div>
		<?php endif; ?>