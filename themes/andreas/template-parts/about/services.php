
<?php
$services = get_field('about_services');
?>

<!-- 🔹 Services Overview -->
		<?php if ( $services ) : ?>
		<div class="services-section mb-5 fade-in">
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