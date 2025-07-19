
<?php 
$tech_list = get_field('tech_expertise'); 
?>

<!-- 🔹 Tech Expertise -->
		<?php if ( $tech_list ) : ?>
		<div class="tech-section mb-5 fade-in">
			<h2 class="text-center mb-4">Technical Expertise</h2>
			<ul class="list-inline text-center">
				<?php foreach ( $tech_list as $tech ) : ?>
					<li class="list-inline-item px-3 py-2 m-2 bg-light border rounded-pill magnetic">
						<?php if ( !empty($tech['icon']) ) : ?>
							<img src="<?php echo esc_url($tech['icon']['url']); ?>" width="20" height="20" class="me-1" />
						<?php endif; ?>
						<?php echo esc_html($tech['label']); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>