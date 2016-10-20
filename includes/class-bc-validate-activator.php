<?php

/**
 * All the code that fires during activation
 *
 * @since      1.0.0
 *
 * @package    Validate_By_Domain
 * @subpackage Validate_By_Domain/includes
 */

class BC_Validate_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		add_site_option( 'validate-by-domain-activated', true );
	}

}
