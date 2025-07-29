<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://andreas.test:8082
 * @since             1.0.0
 * @package           Developer_Hub
 *
 * @wordpress-plugin
 * Plugin Name:       Developer HUB
 * Plugin URI:        https://https://www.stix-digital.com/
 * Description:       The must use plugin for every dev in wordpress
 * Version:           1.0.0
 * Author:            Stix Digital
 * Author URI:        https://andreas.test:8082/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       developer-hub
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DEVELOPER_HUB_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-developer-hub-activator.php
 */
function activate_developer_hub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-developer-hub-activator.php';
	Developer_Hub_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-developer-hub-deactivator.php
 */
function deactivate_developer_hub() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-developer-hub-deactivator.php';
	Developer_Hub_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_developer_hub' );
register_deactivation_hook( __FILE__, 'deactivate_developer_hub' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-developer-hub.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_developer_hub() {

	$plugin = new Developer_Hub();
	$plugin->run();

}
run_developer_hub();
