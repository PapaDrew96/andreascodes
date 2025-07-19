
<?php
$core_values = get_field('core_values');
?>
<!-- 🔹 Core Values -->
		<?php if ( $core_values ) : ?>
		<div class="values-section mb-5 fade-in">
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