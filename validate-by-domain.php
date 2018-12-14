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
 * Description:       During self-registration, provides a mechanism to validate whether an email address is part of a whitelist of domains
 * Version:           1.3.0
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       validate-by-domain
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/** @var TYPE_NAME $composer */
$composer = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer ) ) {
	require $composer;
}

/**
 * include files
 */
require plugin_dir_path( __FILE__ ) . 'inc/class-activator.php';
require plugin_dir_path( __FILE__ ) . 'inc/class-deactivator.php';
require plugin_dir_path( __FILE__ ) . 'inc/class-vbd.php';


register_activation_hook(
	__FILE__, function () {
		ValidateByDomain\Activator::activate();
	}
);

register_deactivation_hook(
	__FILE__, function () {
		ValidateByDomain\Deactivator::deactivate();
	}
);


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

$plugin = new ValidateByDomain\Vbd();
$plugin->run();
