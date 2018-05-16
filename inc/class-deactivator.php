<?php

/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 *
 * @package    Validate_By_Domain
 * @subpackage Validate_By_Domain/inc
 */
namespace ValidateByDomain;

class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		delete_site_option( 'validate-by-domain-activated' );   }

}
