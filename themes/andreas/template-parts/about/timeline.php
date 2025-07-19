<?php
$timeline = get_field('experience_timeline');
?>


<!-- 🔹 Experience Timeline -->
		<?php if ( $timeline ) : ?>
		<div class="timeline-section mb-5 fade-in">
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
