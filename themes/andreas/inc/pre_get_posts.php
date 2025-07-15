<?php
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ( is_post_type_archive( 'project' ) || is_post_type_archive( 'code-snippet' ) ) && isset( $_GET['tech_stack'] ) ) {
		$query->set( 'tax_query', [
			[
				'taxonomy' => 'tech_stack',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['tech_stack'] ),
			]
		] );
	}
});
?>