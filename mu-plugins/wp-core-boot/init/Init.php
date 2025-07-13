<?php
namespace WPCoreBoot\Init;

use WPCoreBoot\PostTypes\RegisterPostTypes;
use WPCoreBoot\Taxonomies\RegisterTaxonomies;
use WPCoreBoot\Settings\ThemeOptions;
class Init {
    public static function run() {
        add_action('init', [RegisterPostTypes::class, 'register']);
        add_action('init', [RegisterTaxonomies::class, 'register']);
        add_action( 'acf/init', [ ThemeOptions::class, 'register' ] );
        
    }
}