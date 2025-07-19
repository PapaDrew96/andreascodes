
		<?php
		$intro         = get_field('about_intro');
$intro_title   = $intro['title'] ?? '';
$intro_text    = $intro['text'] ?? '';
$intro_image   = $intro['image'] ?? '';
		?>
		
		<!-- 🔹 Intro Section -->
		<?php if ( $intro_title || $intro_text ) : ?>
		<div class="intro-section text-center mb-5 fade-in">
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