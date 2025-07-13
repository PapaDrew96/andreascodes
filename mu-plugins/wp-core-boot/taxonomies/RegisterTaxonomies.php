<?php
namespace WPCoreBoot\Taxonomies;

class RegisterTaxonomies {
	public static function register() {
		// 🔹 Tech Stack (Shared)
		register_taxonomy( 'tech_stack', [ 'project', 'code-snippet' ], [
			'labels' => [
				'name'              => __( 'Tech Stack', 'andreas' ),
				'singular_name'     => __( 'Tech', 'andreas' ),
				'search_items'      => __( 'Search Tech', 'andreas' ),
				'all_items'         => __( 'All Tech', 'andreas' ),
				'edit_item'         => __( 'Edit Tech', 'andreas' ),
				'update_item'       => __( 'Update Tech', 'andreas' ),
				'add_new_item'      => __( 'Add New Tech', 'andreas' ),
				'new_item_name'     => __( 'New Tech Name', 'andreas' ),
				'menu_name'         => __( 'Tech Stack', 'andreas' ),
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'tech' ],
		] );

		// 🔹 Project Type (Hierarchical, for Projects)
		register_taxonomy( 'project_type', [ 'project' ], [
			'labels' => [
				'name'              => __( 'Project Types', 'andreas' ),
				'singular_name'     => __( 'Project Type', 'andreas' ),
				'search_items'      => __( 'Search Types', 'andreas' ),
				'all_items'         => __( 'All Types', 'andreas' ),
				'edit_item'         => __( 'Edit Type', 'andreas' ),
				'update_item'       => __( 'Update Type', 'andreas' ),
				'add_new_item'      => __( 'Add New Type', 'andreas' ),
				'new_item_name'     => __( 'New Type Name', 'andreas' ),
				'menu_name'         => __( 'Project Types', 'andreas' ),
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'project-type' ],
		] );

		// Inside RegisterTaxonomies::register()
		register_taxonomy( 'snippet_type', [ 'code-snippet' ], [
			'labels' => [
				'name'              => __( 'Snippet Types', 'andreas' ),
				'singular_name'     => __( 'Snippet Type', 'andreas' ),
				'search_items'      => __( 'Search Snippet Types', 'andreas' ),
				'all_items'         => __( 'All Types', 'andreas' ),
				'edit_item'         => __( 'Edit Type', 'andreas' ),
				'update_item'       => __( 'Update Type', 'andreas' ),
				'add_new_item'      => __( 'Add New Type', 'andreas' ),
				'new_item_name'     => __( 'New Type Name', 'andreas' ),
				'menu_name'         => __( 'Snippet Types', 'andreas' ),
			],
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => [ 'slug' => 'snippet-type' ],
		] );

	}
}
