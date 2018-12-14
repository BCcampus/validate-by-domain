<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Validate_By_Domain
 * @subpackage Validate_By_Domain/public
 */
namespace ValidateByDomain;

class Validate {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $bc_validate The ID of this plugin.
	 */
	private $bc_validate;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;


	/**
	 * @var value of the learner/organizer field
	 */
	private $field_val;

	/**
	 * @var array list of problem domains
	 */
	private $spam_domains = [
		'marvsz.com',
		'kellergy.com',
		'pixymix.com',
		'marrived.com',
		'poczxneolinka.info',
		'namemerfo.com',
		'360ezzz.com',
		'ultramoonbear.com',
		'islaby.com',
		'360ezzz.com',
	];

	/**
	 * @var array list of top level domains associated with spam
	 */
	private $spam_tld = [
		'ru',
		'pl',
		'eu',
	];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string $bc_validate The name of the plugin.
	 * @var      string $version The version of this plugin.
	 */
	public function __construct( $bc_validate, $version ) {

		$this->bc_validate = $bc_validate;
		$this->version     = $version;
		$this->setFieldNum();

	}

	/**
	 * set the value according to user prefs
	 */
	public function setFieldNum() {

		$options         = get_option( 'validate_by_domain_settings' );
		$this->field_val = $options['field_num'];

	}

	/**
	 * Validates the user input and returns appropriate error.
	 *
	 */
	public function signUpUser() {
		global $bp;
		if ( isset( $_POST['_wpnonce'] ) && ( 'request-details' !== $bp->signup->step ) ) {
			return;
		}

		$field_val = 'field_' . $this->field_val;
		$options   = get_option( 'validate_by_domain_settings' );

		// condition is that the user has enabled this feature
		// and that they have specified a field number other than default
		// will check against whitelist
		if ( 1 === $options['validate_enable'] && ( 0 !== $options['field_num'] ) ) {

			// Filter email addresses for Organizers, check for spam domains on Learners
			if ( 0 === strcmp( $_POST[ $field_val ], 'Organizer' ) ) {
				$domain = $this->parseEmail( $_POST['signup_email'] );
				$valid  = $this->isWhiteListedDomain( $domain );

				if ( false === $valid ) {
					$bp->signup->errors['signup_email'] = 'Your email must match the Internet domain name of your organization.';
				}
			}
		}

		// will only check that the email is not spam
		if ( 0 === strcmp( $_POST[ $field_val ], 'Learner' ) && ( 0 !== $options['field_num'] ) ) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$spam   = $this->isSpamDomain( $domain );

			if ( true === $spam ) {
				$bp->signup->errors['signup_email'] = 'error';
			}
		}

		if ( 1 === $options['validate_enable'] && ( 0 === $options['field_num'] ) ) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$valid  = $this->isWhiteListedDomain( $domain );

			if ( false === $valid ) {
				$bp->signup->errors['signup_email'] = 'Your email must match the Internet domain name of your organization.';
			}
		}
	}

	/**
	 * Parses an email address and returns the domain name
	 *
	 * @param string $email_address
	 *
	 * @return string
	 */
	private function parseEmail( $email_address ) {

		if ( empty( $email_address ) ) {
			return '';
		}
		//get rid of username
		$part = strstr( $email_address, '@' );

		// return everything but the @
		$domain = substr( $part, 1 );

		return $domain;
	}

	/**
	 * Get the whitelisted domains
	 */
	public function parseWhiteList() {
		$options = get_option( 'validate_by_domain_settings' );

		// Make array of domains using end of line as delimiter, strip whitespace and carriage returns etc
		$whitelist = array_map( 'trim', explode( PHP_EOL, $options['validate_whitelist'] ) );

		return $whitelist;
	}


	/**
	 * Compares the domain of the users email to a list of BC institution
	 * domains
	 *
	 * @param string $domain
	 *
	 * @return boolean
	 */
	private function isWhiteListedDomain( $domain ) {

		if ( empty( $domain ) ) {
			return false;
		}

		// target subdomain, ex: geog.ubc.ca
		$base_domain = $this->getBaseDomain( $domain );

		// return true if the domain is in the list
		if ( in_array( $base_domain, $this->parseWhiteList(), true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Compares the domain of the user's email to a couple of blacklists
	 *
	 * @param $domain
	 *
	 * @return bool
	 */
	private function isSpamDomain( $domain ) {

		if ( empty( $domain ) ) {
			return false;
		}

		// target both top level domains and specific domains
		$base_domain = $this->getBaseDomain( $domain );
		$tld_domain  = $this->getTopLevelDomain( $domain );

		// return true if it's from a spam domain
		if ( in_array( $base_domain, $this->spam_domains, true ) || in_array( $tld_domain, $this->spam_tld, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Given a domain, will return the top level domain
	 *
	 * @param $domain
	 *
	 * @return mixed
	 */
	private function getTopLevelDomain( $domain ) {
		$parts = explode( '.', $domain );
		$tld   = array_pop( $parts );

		return $tld;
	}

	/**
	 * Given a domain, or subdomain, will return the host and top level domain
	 *
	 * @param $domain
	 *
	 * @return string
	 */
	private function getBaseDomain( $domain ) {
		$parts       = explode( '.', $domain );
		$tld         = array_pop( $parts );
		$host_name   = array_pop( $parts );
		$base_domain = $host_name . '.' . $tld;

		return $base_domain;
	}

	/**
	 * At the moment of signup, store a post value in wp_signups table
	 *
	 * @param array $usermeta
	 *
	 * @return array $usermeta
	 */
	public function signUpMeta( $usermeta ) {
		$field_val = 'field_' . $this->field_val;

		if ( isset( $_POST[ $field_val ] ) && ( false !== wp_verify_nonce( $_POST['_wpnonce'] ) ) ) {
			$usermeta['vbd_role'] = $_POST[ $field_val ];
		}

		return $usermeta;
	}

	/**
	 * At the moment after signup, during activation, update capabilities to
	 * contributor
	 *
	 * @param $user_id
	 *
	 * @return int $user_id
	 */

	function mapRoleToCapability( $user_id ) {
		global $wpdb;

		if ( ! is_int( $user_id ) ) {
			return $user_id;
		} else {
			$current = get_user_by( 'id', $user_id );

			$meta = $wpdb->get_row( $wpdb->prepare( 'SELECT `meta` FROM `wp_signups` WHERE `user_login` = %s ', $current->user_login ) );

			$meta = maybe_unserialize( $meta->meta );

			// Get the plugin options for the user role
			$options = get_option( 'validate_by_domain_settings' );

			//check if the signup usermeta value is present
			if ( isset( $meta['vbd_role'] ) && 0 === strcmp( 'Organizer', $meta['vbd_role'] ) ) {
				$current->set_role( $options['validate_role'] );
			}
		}

		return $user_id;
	}
}
