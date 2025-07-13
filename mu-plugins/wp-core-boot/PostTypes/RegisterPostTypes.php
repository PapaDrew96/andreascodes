<?php
namespace WPCoreBoot\PostTypes;

class RegisterPostTypes {
	public static function register() {
		// 🔹 PROJECTS CPT
		register_post_type( 'project', [
			'labels' => [
				'name'               => __( 'Projects', 'andreas' ),
				'singular_name'      => __( 'Project', 'andreas' ),
				'add_new'            => __( 'Add New Project', 'andreas' ),
				'add_new_item'       => __( 'Add New Project', 'andreas' ),
				'edit_item'          => __( 'Edit Project', 'andreas' ),
				'new_item'           => __( 'New Project', 'andreas' ),
				'view_item'          => __( 'View Project', 'andreas' ),
				'all_items'          => __( 'All Projects', 'andreas' ),
				'search_items'       => __( 'Search Projects', 'andreas' ),
				'not_found'          => __( 'No projects found.', 'andreas' ),
				'not_found_in_trash' => __( 'No projects found in Trash.', 'andreas' ),
			],
			'public'            => true,
			'has_archive'       => true,
			'rewrite'           => [ 'slug' => 'projects' ],
			'supports'          => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'show_in_rest'      => true,
			'show_in_menu'      => true,
			'menu_position'     => 5,
			'menu_icon'         => 'dashicons-portfolio',
		] );

		// 🔹 CODE SNIPPETS CPT
		register_post_type( 'code-snippet', [
			'labels' => [
				'name'               => __( 'Code Snippets', 'andreas' ),
				'singular_name'      => __( 'Code Snippet', 'andreas' ),
				'add_new'            => __( 'Add New Snippet', 'andreas' ),
				'add_new_item'       => __( 'Add New Snippet', 'andreas' ),
				'edit_item'          => __( 'Edit Snippet', 'andreas' ),
				'new_item'           => __( 'New Snippet', 'andreas' ),
				'view_item'          => __( 'View Snippet', 'andreas' ),
				'all_items'          => __( 'All Snippets', 'andreas' ),
				'search_items'       => __( 'Search Snippets', 'andreas' ),
				'not_found'          => __( 'No snippets found.', 'andreas' ),
				'not_found_in_trash' => __( 'No snippets found in Trash.', 'andreas' ),
			],
			'public'            => true,
			'has_archive'       => true,
			'rewrite'           => [ 'slug' => 'code-snippets' ],
			'supports'          => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'show_in_rest'      => true,
			'show_in_menu'      => true,
			'menu_position'     => 6,
			'menu_icon'         => 'dashicons-editor-code',
		] );
	}
}
