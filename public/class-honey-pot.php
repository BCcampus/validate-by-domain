<?php

/**
 * Project: pd
 * Project Sponsor: BCcampus <https://bccampus.ca>
 * Date: 2017-03-22
 * Licensed under GPLv3, or any later version
 *
 * @author Brad Payne
 * @package OPENTEXTBOOKS
 * @license https://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 * Modified from original 'BudddyPress-HoneyPot' version 1.1
 * @copyright Pixel Jar
 * https://github.com/pixeljar/BuddyPress-Honeypot/
 */
class HoneyPot {
	/**
	 * default values for the honeypot
	 * change these via filters if you
	 * start getting spam registrations
	 */
	CONST VBD_HONEYPOT_NAME = 'RoodElbowBallsTamerFistHem';
	CONST VBD_HONEYPOT_ID = 'PilotFamousVenialNewSpiceNoisy';

	function __construct() {

	}

	/**
	 * Add a hidden text input that users won't see
	 * so it should always be empty. If it's filled out
	 * we know it's a spambot or some other hooligan
	 *
	 * @filter vpd_honeypot_name
	 * @filter vpd_honeypot_id
	 */
	function addHoneyPot() {

		echo '<div style="display: none;">';
		echo '<input type="text" name="' . apply_filters( 'vbd_honeypot_name', self::VBD_HONEYPOT_NAME ) . '" id="' . apply_filters( 'vbd_honeypot_id', self::VBD_HONEYPOT_ID ) . '" />';
		echo '</div>';
	}

	/**
	 * Check to see if the honeypot field has a value.
	 * If it does, return an error
	 *
	 * @filter vpd_honeypot_name
	 * @filter vpd_honeypot_fail_message
	 */
	function checkHoneyPot( $result = array() ) {
		global $bp;
		$vpd_honeypot_name = apply_filters( 'vbd_honeypot_name', self::VBD_HONEYPOT_NAME );
		if ( isset( $_POST[ $vpd_honeypot_name ] ) && ! empty( $_POST[ $vpd_honeypot_name ] ) ) {
			$result['errors']->add( 'vbd_honeypot', apply_filters( 'vpd_honeypot_fail_message', __( "unhelpful error message." ) ) );
		}

		return $result;
	}
}

