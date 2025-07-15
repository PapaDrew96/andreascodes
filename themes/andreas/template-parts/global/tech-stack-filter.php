<?php
$tech_terms = get_terms([
	'taxonomy'   => 'tech_stack',
	'hide_empty' => false,
]);

if ( ! empty( $tech_terms ) && ! is_wp_error( $tech_terms ) ) :
	$current = isset( $_GET['tech_stack'] ) ? sanitize_text_field( $_GET['tech_stack'] ) : '';
?>

<div class="tech-stack-filter mb-4 d-flex flex-wrap gap-2">
	<a href="<?php echo esc_url( remove_query_arg( 'tech_stack' ) ); ?>"
	   class="btn btn-sm <?php echo $current === '' ? 'btn-dark' : 'btn-outline-dark'; ?>">
		All
	</a>

	<?php foreach ( $tech_terms as $term ) : ?>
		<a href="<?php echo esc_url( add_query_arg( 'tech_stack', $term->slug ) ); ?>"
		   class="btn btn-sm <?php echo $current === $term->slug ? 'btn-dark' : 'btn-outline-dark'; ?>">
			<?php
			$icon = get_field( 'icon', 'tech_stack_' . $term->term_id );
			if ( $icon ) {
				echo '<img src="' . esc_url( $icon['url'] ) . '" alt="" width="16" height="16" class="me-1">';
			}
			echo esc_html( $term->name );
			?>
		</a>
	<?php endforeach; ?>
</div>

<?php endif; ?>
