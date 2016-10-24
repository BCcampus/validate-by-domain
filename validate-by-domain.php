<?php
/** 
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * Forked from bc-validate plugin
 *
 * @since             1.0.0
 * @package           Validate_By_Domain
 *
 * @wordpress-plugin
 * Plugin Name:       BC Instititutions Domain Validator
 * Description:       Created for the Early years project. Provides a mechanism to validate whether a user's email address is part of the BC Post-Secondary System
 * Version:           1.0.0
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       validate-by-domain
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_bc_validate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-validate-by-domain-activator.php';
	Validate_By_Domain_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_bc_validate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-validate-by-domain-deactivator.php';
	Validate_By_Domain_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bc_validate' );
register_deactivation_hook( __FILE__, 'deactivate_bc_validate' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-validate-by-domain.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_validate_by_domain() {

	$plugin = new Validate_By_Domain();
	$plugin->run();

}
run_validate_by_domain();
