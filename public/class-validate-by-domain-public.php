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
	 * @since 1.0.0
	 *
	 * @var array - list of email domians for bc instiutions
	 */
	private $bc_domains = array(
		'acc-society.bc.ca',
		'ahsabc.com',
		'all-nations.ca',
		'bcaafc.com',
		'bcasw.org',
		'bccampus.ca',
		'bccf.ca',
		'bchealthyliving.ca',
		'bcit.ca',
		'bcrpa.bc.ca',
		'caddra.ca',
		'camosun.bc.ca',
		'camosun.ca',
		'cancer.ca',
		'caphc.org ',
		'capilanou.ca',
		'childhoodobesityfoundation.ca',
		'childrenshearing.ca',
		'cnc.bc.ca',
		'cotr.bc.ca',
		'cw.bc.ca',
		'douglascollege.ca',
		'ecebc.ca',
		'ecuad.ca',
		'educacentre.com',
		'fcssbc.ca',
		'fnha.ca​',
		'fpcc.ca',
		'frpbc.ca',
		'fsibc.com',
		'hippycanada.ca',
		'jibc.ca',
		'kpu.ca',
		'langara.bc.ca',
		'ldabc.ca',
		'mcsbc.org  ',
		'metiscommission.com',
		'metisfamilyservices.ca',
		'nic.bc.ca',
		'northernhealth.ca',
		'nvit.bc.ca',
		'nwcc.bc.ca',
		'okanagan.bc.ca',
		'phsa.ca ',
		'psychologyfoundation.org',
		'rootsofempathy.org',
		'royalroads.ca',
		'saccabc.org',
		'selkirk.ca',
		'sfu.ca',
		'successby6bc.ca',
		'svifcca.com',
		'therapybc.ca',
		'tru.ca',
		'ubc.ca',
		'ufv.ca',
		'unbc.ca',
		'uvic.ca',
		'vcc.ca',
		'viha.ca ',
		'viu.ca',
		'yukoncollege.yk.ca',

		// CCRR - Child Care Resource Referral
		'abbotsfordccrr.ca',
		'islandswellnesssociety.com',
		'bvcdc.ca',
		'ccrr.ccscranbrook.ca',
		'cariboofamily.org',
		'kamloopsy.org',
		'kelownachildcare.com',
		'nona-cdc.com',
		'boysandgirlsclubs.ca',
		'goldencommunityresources.ca',
		'cariboofamily.org',
		'pdcrs.com',
		'shuswapchildrens.ca',
		'trailfair.ca',
		'kootenaykids.ca',
		'nbcy.org',
		'quesnelbc.com ',
		'spcrs.ca',
		'readrightsociety.com',
		'lcss.ca',
		'missioncommunityservices.com',
		'childcareoptions.ca',
		'pacific-care.bc.ca',
		'clementscentre.org',
		'sfrs.ca/ccrr',
		'childcarevictoria.ca',
		'nscr.bc.ca',
		'wstcoast.org',
		'sscs.ca',
		'coastccrr.ca',
		'volunteerrichmond.ca',
		'vanymca.org',

		// School Districts
		'sd5.bc.ca',
		'sd6.bc.ca',
		'sd8.bc.ca',
		'sd10.bc.ca',
		'sd19.bc.ca',
		'sd20.bc.ca',
		'sd22.bc.ca',
		'sd23.bc.ca',
		'sd27.bc.ca',
		'sd28.bc.ca',
		'sd33.bc.ca',
		'sd34.bc.ca',
		'sd35.bc.ca',
		'surreyschools.ca',
		'web.deltasd.bc.ca',
		'sd38.bc.ca',
		'vsb.bc.ca',
		'sd40.bc.ca',
		'sd41.bc.ca',
		'sd42.ca',
		'sd43.bc.ca',
		'sd44.ca',
		'westvancouverschools.ca',
		'sd46.bc.ca',
		'sd47.bc.ca',
		'sd48seatosky.org',
		'sd49.bc.ca',
		'sd50.bc.ca',
		'sd51.bc.ca',
		'sd52.bc.ca',
		'sd53.bc.ca',
		'sd54.bc.ca',
		'sd57.bc.ca',
		'sd58.bc.ca',
		'sd59.bc.ca',
		'prn.bc.ca',
		'sd61.bc.ca',
		'sd62.bc.ca',
		'sd63.bc.ca',
		'sd64.bc.ca',
		'sd67.bc.ca',
		'sd68.bc.ca',
		'sd69.bc.ca',
		'sd70.bc.ca',
		'sd71.bc.ca',
		'sd72.bc.ca',
		'sd73.bc.ca',
		'sd74.bc.ca',
		'mpsd.ca',
		'sd78.bc.ca',
		'sd79.bc.ca',
		'sd81.bc.ca',
		'cmsd.bc.ca',
		'sd83.bc.ca',
		'sd84.bc.ca',
		'sd85.bc.ca',
		'sd87.bc.ca',
		'sd91.bc.ca',
		'nisgaa.bc.ca',
		'csf.bc.ca',

		// Child Development centers
		'bvcdc.ca',
		'cdcfsj.ca',
		'kitimatcdc.ca',
		'cdcpg.org',
		'quesnelcdc.com',
		'spcdc.ca',
		'terracechilddevelopmentcentre.com',
		'cdcyukon.ca',
		'cccdca.org',
		'starbrightokanagan.ca',
		'osns.org',
		'kamloopschildrenstherapy.com',
		'ccscranbrook.ca',
		'shuswapchildrens.ca',
		'cvcda.ca',
		'albernichildrenfirst.ca',
		'clementscentre.org',
		'bcfamilyhearing.com',
		'develop.bc.ca',
		'fvcdc.org',
		'rmcdc.com',
		'sharesociety.ca',
		'sccss.ca',
		'bc-cfa.org',
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

		if ( isset( $_POST ) && ( 'request-details' != $bp->signup->step ) ) {
			return;
		}

		// Only filter email addresses for Organizers
		// (must be from a recognized agency)
		if ( 0 === strcmp( $_POST['field_3'], 'Organizer' ) ) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$ok     = $this->checkDomain( $domain );

			if ( false == $ok ) {
				$bp->signup->errors['signup_email'] = 'Please use an email address from an allowed agency or institution within British Columbia';
			}
		}

//		add_action( 'user_register', function( $user_id ){
//			update_user_meta( $user_id, 'wp_capabilities', 'contributor' );
//		} );
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
	 * Compares the domain of the users email to a list of BC Institutional domains
	 *
	 * @param string $domain
	 *
	 * @return boolean
	 */
	private function checkDomain( $domain ) {

		if ( empty( $domain ) ) {
			return false;
		}

		if ( in_array( $domain, $this->bc_domains ) ) {
			return true;
		}

		// target subdomain, ex: geog.ubc.ca
		$parts = explode( '.', $domain );

		if ( count( $parts ) == 3 ) {
			$base_domain = $parts[1] . '.' . $parts[2];

			foreach ( $this->bc_domains as $inst ) {
				if ( false !== strpos( $inst, $base_domain ) ) {
					return true;
				}
			}
		}

		return false;
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

		if ( isset( $_POST['field_3'] ) ) {
			$usermeta['eypd_role'] = $_POST['field_3'];
		}

		return $usermeta;
	}

	/**
	 * At the moment after signup, during activation, update capabilities to contributor
	 *
	 * @param $signup
	 *
	 * @return mixed
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

			//check if the signup usermeta value is present
			if ( isset( $meta['eypd_role'] ) && 0 === strcmp( 'Organizer', $meta['eypd_role'] ) ) {
				$current->set_role( 'contributor' );
			}

		}

		return $user_id;
	}
}
