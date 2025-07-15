<?php
namespace WPCoreBoot\Init;

use WPCoreBoot\PostTypes\RegisterPostTypes;
use WPCoreBoot\Taxonomies\RegisterTaxonomies;
use WPCoreBoot\Settings\ThemeOptions;
use WPCoreBoot\Blocks\RegisterBlocks;
class Init {
    public static function run() {
        add_action('init', [RegisterPostTypes::class, 'register']);
        add_action('init', [RegisterTaxonomies::class, 'register']);
        add_action( 'acf/init', [ ThemeOptions::class, 'register' ] );
        add_action( 'acf/init', [ RegisterBlocks::class, 'register' ] );

        
    }
}