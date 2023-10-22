<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Queer-Lexikon/kummerkasten
 * @since             2.0.0
 * @package           QU_Askbox
 *
 * Plugin Name: qu-askbox
 * Plugin URI: https://github.com/Queer-Lexikon/kummerkasten
 * Description: anonym und ohne externe Abhängigkeiten Fragen in einem WordPress per Plugin einsammeln, die dann automatisch als Zitat in Beitragsentwürfen hinterlegt werden.
 * Version: 2.0.0
 * Text Domain: qu-askbox
 * License: MIT License
 * License URI: https://opensource.org/license/mit/
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
define( 'QU_ASKBOX_VERSION', '2.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-qu-askbox-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qu-askbox-activator.php';
	Qu_Askbox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-qu-askbox-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-qu-askbox-deactivator.php';
	Qu_Askbox_Deactivator::deactivate();
}

/**
 * currently we dont have any activation oder deactivation stuff, no need to register it
 */
//register_activation_hook( __FILE__, 'activate_plugin_name' );
//register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-qu-askbox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_qu_askbox() {

	$plugin = new QU_Askbox();
	$plugin->run();

}
run_qu_askbox();
