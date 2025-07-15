<?php
namespace WPCoreBoot\Blocks;

class RegisterBlocks {
	public static function register() {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			return;
		}

		$blocks_dir = __DIR__ . '/blocks';
		$block_folders = array_filter(glob($blocks_dir . '/*'), 'is_dir');

		foreach ( $block_folders as $folder_path ) {
			$setup_file = $folder_path . '/setup.php';
			$render_file = $folder_path . '/render.php';

			if ( file_exists( $setup_file ) && file_exists( $render_file ) ) {
				$block_config = include $setup_file;

				// Set the render callback to the file function
				$render_function = $block_config['render_callback'];
				if ( ! function_exists( $render_function ) ) {
					require_once $render_file;
				}

				acf_register_block_type( $block_config );
			}
		}
	}
}
