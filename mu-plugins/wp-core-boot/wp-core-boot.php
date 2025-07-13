<?php
/**
 * Plugin Name: WP Core Boot (MU)
 * Description: Modular MU plugin loader for CPTs, taxonomies, and helpers.
 */

require_once __DIR__ . '/autoload.php';

use WPCoreBoot\Init\Init;
Init::run();