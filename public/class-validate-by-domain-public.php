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
	 * @var      string    $bc_validate    The ID of this plugin.
	 */
	private $bc_validate;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
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
      'csf.bc.ca'
	);
	private $bc_inst = array(
      "" => "-- Select Option --",
      "accs" => "(BC) Aboriginal Child Care Society",
      "ahs" => "Aboriginal Head Start Association of British Columbia",
      "iig" => "Institute of Indigenous Government",
      "aafc" => "BC Association of Aboriginal Friendship Centres",
      "asw" => "Association of Social Workers",
      "bcc" => "BCcampus",
      "bccf" => "BC Council for Families",
      "bchl" => "BC Healthy Living Alliance",
      "bcit" => "BC Institute of Technology",
      "bcrpa" => "BC Recreation and Parks Association",
      "caddra" => "Canadian Attention Deficit Hyperactivity Disorder Resource Alliance",
      "cam" => "Camosun College",
      "cam" => "Camosun College",      
      "can" => "Canadian Cancer Society",
      "caphc" => "Canadian Association of Paediatric Health Centres",
      "capu" => "Capilano University",
      "cof" => "Childhood Obesity Foundation",
      "ch" => " Children's Hearing & Speech Centre of BC",
      "cnc" => "College of New Caledonia",
      "cotr" => "College of the Rockies",
      "cwbc" => "Children's & Women's Health Centre of British Columbia",
      "dc" => "Douglas College",
      "ecebc" => "Early Childhood Educators of British Columbia",
      "ecuad" => "Emily Carr University of Art and Design",
      "edc" => "College Educacentre College",
      "fcssbc" => "The Federation of Community Social Services of BC",
      "fnha" => "First Nations Health Authority",
      "fpcc" => "First Peoples' Cultural Council",
      "frpbc" => "The BC Association of Family Resource Programs",
      "fsi" => "Family Support Instittute",
      "hc" => "Aboriginal Hippy Canada",
      "jibc" => "Justice Institute of B.C.",
      "kpu" => "Kwantlen Polytechnic University",
      "lang" => "Langara College",
      "ldabc" => "The Learning Disabilities Association of British Columbia",
      "mcsbc" => "Metis Community Services Society of BC",
      "mc" => "Metis Commission for Children and Families of BC",
      "mfs" => "Metis Family Services",
      "nic" => "North Island College",
      "nh" => "Northern Health",
      "nvit" => "Nicola Valley Institute of Technology",
      "nwcc" => "Northwest Community College",
      "okan" => "Okanagan College",
      "phsa" => "Provincial Health Services Authority",
      "psf" => "Psychology Foundation of Canada",
      "roe" => "Roots of Empathy",
      "rru" => "Royal Roads University",
      "sac" => " School Age Child Care Association of BC",
      "selk" => "Selkirk College",
      "sfu" => "Simon Fraser University",
      "sb6" => "Success By 6",
      "svif" => "Southern Vancouver Island Family Child Care Association",
      "tbc" => "Therapy BC",
      "tru" => "Thompson Rivers University",
      "ubc" => "University of British Columbia",
      "ufv" => "University of the Fraser Valley",
      "unbc" => "University of Northern British Columbia",
      "uvic" => "University of Victoria",
      "vcc" => "Vancouver Community College",
      "viha" => "Vancouver Island Health Authority",
      "viu" => "Vancouver Island University",
      "yukc" => "Yukon College",
      
         // CCRR - Child Care Resource Referral
      "ccrr-ab" =>"Abbotsford CCRR",
      "ccrr-hagw" =>"Haida Gwaii ",
      "ccrr-sm" =>"Smithers CCRR",
      "ccrr-ek" =>"East Kootenays CCRR",
      "ccrr-cfp" =>"Cariboo Family Place",
      "ccrr-ka" =>"Kamloops CCRR",
      "ccrr-ke" =>"Kelowna CCRR",
      "ccrr-vnc" =>"Vernon NONA Centre",
      "ccrr-ve" =>"Vernon CCRR",
      "ccrr-go" =>"Golden CCRR",
      "ccrr-100mh" =>"100 Mile House CCRR",
      "ccrr-pe" =>"Penticton CCRR",
      "ccrr-sh" =>"Shuswap CCRR",
      "ccrr-tc" =>"Trail & Castlegar CCRR",
      "ccrr-wk" =>"West Kootenays CCRR",
      "ccrr-pg" =>"Prince George CCRR",
      "ccrr-qu" =>"Quesnel CCRR",
      "ccrr-npc" =>"North Peace Child CCRR",
      "ccrr-ho" =>"Hope CCRR",
      "ccrr-la" =>"Langley CCRR",
      "ccrr-mcs" =>"Mission Community Services CCRR ",
      "ccrr-dsw" =>"Delta - Surrey - White Rock CCRR",
      "ccrr-pac" =>"PacificCARE CCRR",
      "ccrr-cv" =>"Cowichan Valley CCRR",
      "ccrr-sws" =>"Sooke/Westshore CCRR",
      "ccrr-vi" =>"Victoria CCRR",
      "ccrr-ns" =>"North Shore CCRR",
      "ccrr-va" =>"Vancouver CCRR",
      "ccrr-sts" =>"Sea to Sky CCRR",
      "ccrr-sc" =>"Sunshine Coast CCRR",
      "ccrr-ri" =>"Richmond CCRR",
      "ccrr-ymca" =>"Tri Cities and Burnaby/New Westminister - YMCA CCRR",
      
         // School Districts
      "sd5" =>"Southeast Kootenay",
      "sd6" =>"Rocky Mountain",
      "sd8" =>"Kootenay Lake",
      "sd10" =>"Arrow Lakes",
      "sd19" =>"Revelstoke",
      "sd20" =>"Kootenay-Columbia",
      "sd22" =>"Vernon",
      "sd23" =>"Central Okanagan",
      "sd27" =>"Cariboo-Chilcotin",
      "sd28" =>"Quesnel",
      "sd33" =>"Chilliwack",
      "sd34" =>"Abbotsford",
      "sd35" =>"Langley",
      "ss" =>"Surrey",
      "dsd" =>"Delta",
      "sd38" =>"Richmond",
      "vsb" =>"Vancouver",
      "sd40" =>"New Westminster",
      "sd41" =>"Burnaby",
      "sd42" =>"Maple Ridge-Pitt Meadows",
      "sd43" =>"Coquitlam",
      "sd44" =>"North Vancouver",
      "wvs" =>"West Vancouver",
      "sd46" =>"Sunshine Coast",
      "sd47" =>"Powell River",
      "sd48" =>"Sea to Sky",
      "sd49" =>"Central Coast",
      "sd50" =>"Haida Gwaii",
      "sd51" =>"Boundary",
      "sd52" =>"Prince Rupert",
      "sd53" =>"Okanagan Similkameen",
      "sd54" =>"Bulkley Valley",
      "sd57" =>"Prince George",
      "sd58" =>"Nicola-Similkameen",
      "sd59" =>"Peace River South",
      "prn" =>"Peace River North",
      "sd61" =>"Greater Victoria",
      "sd62" =>"Sooke",
      "sd63" =>"Saanich",
      "sd64" =>"Gulf Islands",
      "sd67" =>"Okanagan Skaha",
      "sd68" =>"Nanaimo-Ladysmith",
      "sd69" =>"Qualicum",
      "sd70" =>"Alberni",
      "sd71" =>"Comox Valley",
      "sd72" =>"Campbell River",
      "sd73" =>"Kamloops/Thompson",
      "sd74" =>"Gold Trail",
      "mpsd" =>"Mission",
      "sd78" =>"Fraser-Cascade",
      "sd79" =>"Cowichan Valley",
      "sd81" =>"Fort Nelson",
      "cmsd" =>"Coast Mountains",
      "sd83" =>"North Okanagan-Shuswap",
      "sd84" =>"Vancouver Island West",
      "sd85" =>"Vancouver Island North",
      "sd87" =>"Stikine",
      "sd91" =>"Nechako Lakes",
      "nisgaa" =>"Nisgaa",
      "csf" =>"Conseil scolaire francophone",
   );

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $bc_validate       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $bc_validate, $version ) {

		$this->bc_validate = $bc_validate;
		$this->version = $version;
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
  
		if ( isset( $_POST ) && ( 'request-details' != $bp->signup->step )) {
			return;
		}

            // Validate the format of the email address prior to passing it to the allowable domain checker
		if ( filter_var( $_POST['signup_email'], FILTER_VALIDATE_EMAIL )) {
			$domain = $this->parseEmail( $_POST['signup_email'] );
			$ok = $this->checkDomain( $domain );

			if ( false == $ok ) {
				$bp->signup->errors['signup_email'] = 'Please use an email address from an allowed agency or institution within British Columbia';
			}
		}
        else 
            $bp->signup->errors['signup_email'] = 'There appears to be a problem in the email address. Please review and make any corrections';
	}

	/**
	 * Parses an email address and returns the domain name
	 * 
	 * @param string $email_address
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
	 * @return boolean
	 */
	private function checkDomain($domain)
	{

		if (empty($domain)) {
			return false;
		}

		if (in_array($domain, $this->bc_domains)) {
			return true;
		}
		
		// target subdomain, ex: geog.ubc.ca
		$parts = explode('.', $domain);
		
		if (count($parts) == 3) {
			$base_domain = $parts[1] . '.' . $parts[2];

			foreach ($this->bc_domains as $inst) {
				if (false !== strpos($inst, $base_domain)) {
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
		$html = '<label for="bc_inst">' . __( 'BC Institution:' ) . '</label>';
		if ( $errmsg = $errors->get_error_message( 'bc_inst' ) ) {
			$html .= '<p class="error">' . $errmsg . '</p>';
		}
		$html .= '<p><select name="bc_inst" required="true">';

		foreach ( $this->bc_inst as $id => $val ) {
			$html .= "<option value='{$id}'>{$val}</option>";
		}
		$html .= '</select><br>'
			. '(Must be a faculty member currently working at a post secondary institute in British Columbia)</p>';

		echo $html;
	}

	/**
	 * 
	 * @param array $meta
	 * @return array
	 */
	public function signupMetaBC( $meta ) {
		if ( isset( $_POST['bc_inst'] ) ) {
			$add_meta = array(
			    'bc_inst' => $_POST['bc_inst'],
			);
			$meta = array_merge( $add_meta, $meta );
		}
		return $meta;
	}

	public function signupStyleBC() {

		$html = '<style type="text/css">
		.mu_register { width: 60%; margin:0 auto; }
		</style>';
		echo $html;
	}

}
