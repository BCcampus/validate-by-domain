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
class Validate_By_Domain_Public {

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
	private $spam_domains = array(
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
	);

	/**
	 * @var array list of top level domains associated with spam
	 */
	private $spam_tld = array(
		'ru',
		'pl',
		'eu',
	);

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
	 * set different field values depending on prod or dev env
	 * todo: bring this into plugin options page, or make it more user friendly somehow
	 */
	public function setFieldNum() {
		$host = parse_url( network_site_url(), PHP_URL_HOST );

		if ( 0 === strcmp( 'earlyyearsbc.ca', $host ) ) {
			$field_val = '155';
		} else {
			$field_val = '3';
		}

		$this->field_val = $field_val;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BC_Validate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BC_Validate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
//		wp_enqueue_style( $this->bc_validate, plugin_dir_url( __FILE__ ) . 'css/bc-validate-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BC_Validate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BC_Validate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
//		wp_enqueue_script( $this->bc_validate, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Validates the user input and returns appropriate error.
	 *
	 */
	public function signupUserBC() {
		global $bp;
		$field_val = 'field_' . $this->field_val;
		if ( isset( $_POST ) && ( 'request-details' != $bp->signup->step ) ) {
			return;
		}

		// Filter email addresses for Organizers, check for spam domains on Learners
		if ( 0 === strcmp( $_POST[ $field_val ], 'Organizer' ) ) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$valid  = $this->isBCDomain( $domain );

			if ( false == $valid ) {
				$bp->signup->errors['signup_email'] = 'Please use an email address from an allowed agency or institution within British Columbia';
			}
		}

		if ( 0 === strcmp( $_POST[ $field_val ], 'Learner' ) ) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$spam   = $this->isSpamDomain( $domain );

			if ( true == $spam ) {
				$bp->signup->errors['signup_email'] = 'error';
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
	 * Compares the domain of the users email to a list of BC institution domains
	 *
	 * @param string $domain
	 *
	 * @return boolean
	 */
	private function isBCDomain( $domain ) {

		if ( empty( $domain ) ) {
			return false;
		}

		// target subdomain, ex: geog.ubc.ca
		$base_domain = $this->getBaseDomain( $domain );

		// return true if the domain is in the list
		if ( in_array( $base_domain, $this->parseWhiteList() ) ) {
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
		if ( in_array( $base_domain, $this->spam_domains ) || in_array( $tld_domain, $this->spam_tld ) ) {
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
	 * Adds a dropdown list of BC Institutions to the signup form
	 *
	 * @param type $errors
	 */
	public function signupExtraBC( $errors ) {
		// Select list for BC Institutions
		$html = '<div class="radio">
					<span class="label">Position/Role (required)</span>';
		if ( is_object( $errors ) ) {

			$html .= '<p class="error">' . $errors->get_error_message( 'eypd_role' ) . '</p>';
		}

		$html .= '<div id="eypd_role" class="input-options radio-button-options">
					<label for="organizer" class="option-label">
					<input  type="radio" name="eypd_role" id="organizer" value="Organizer">Organizer</label>
					<label for="learner" class="option-label">
					<input  type="radio" name="eypd_role" id="learner" value="Learner">Learner</label>
					</div>';
		$html .= '<p class="description">Learner — you are primarily looking for training events. Organizer — you are primarily posting training events on this site.</p>';
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	/**
	 * At the moment of signup, store a post value in wp_signups table
	 *
	 * @param array $usermeta
	 *
	 * @return array $usermeta
	 */
	public function signupMetaBC( $usermeta ) {
		$field_val = 'field_' . $this->field_val;

		if ( isset( $_POST[ $field_val ] ) ) {
			$usermeta['eypd_role'] = $_POST[ $field_val ];
		}

		return $usermeta;
	}

	/**
	 * At the moment after signup, during activation, update capabilities to contributor
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

			$query = $wpdb->prepare( 'SELECT `meta` FROM `wp_signups` WHERE `user_login` = %s ', $current->user_login );
			$meta  = $wpdb->get_row( $query );

			$meta = maybe_unserialize( $meta->meta );

			// Get the plugin options for the user role
			$options = get_option( 'validate_by_domain_settings' );

			//check if the signup usermeta value is present
			if ( isset( $meta['eypd_role'] ) && 0 === strcmp( 'Organizer', $meta['eypd_role'] ) ) {
				$current->set_role( $options['validate_role'] );
			}

		}

		return $user_id;
	}
}
