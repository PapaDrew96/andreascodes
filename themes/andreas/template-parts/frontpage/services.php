<?php
$section_title = get_field('services_title');
?>

<?php if ( have_rows('services_list') ): ?>
<section class="services-section py-5 fade-in">
	<div class="container">
		<?php if ( $section_title ): ?>
			<h2 class="section-heading text-center mb-5"><?php echo esc_html( $section_title ); ?></h2>
		<?php endif; ?>
	</div>

	<div class="swiper my-services-slider px-0">
		<div class="swiper-wrapper">
			<?php while ( have_rows('services_list') ): the_row(); ?>
				<?php
					$title       = get_sub_field('task_title');
					$description = get_sub_field('task_desc');
					$bg_image    = get_sub_field('task_background');
					$bg_url      = $bg_image['url'] ?? '';
					// var_dump($bg_url);
					// var_dump($bg_image);
					// var_dump($title);
					// var_dump($description);
					// die();
				?>
				<!-- slide -->
				<div class="swiper-slide service-slide" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
					<div class="overlay d-flex flex-column justify-content-center text-center text-white">
						<?php if ( $title ): ?>
							<h2 class="mb-2"><?php echo esc_html($title); ?></h2>
						<?php endif; ?>
						<?php if ( $description ): ?>
							<p class="lead"><?php echo esc_html($description); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>

		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
		<div class="swiper-pagination mt-4"></div>
	</div>
</section>
<?php endif; ?>
