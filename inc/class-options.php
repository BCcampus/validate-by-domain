<?php
/**
 * All of the functionality for the plugins options page in the dashboard
 */
namespace ValidateByDomain;

class Options {

	public function plugin_admin_add_page() {

		add_options_page(
			'Validate by Domain',
			'Validate by Domain',
			'manage_options',
			'validate_by_domain', [
				$this,
				'plugin_options_page',
			]
		);

	}

	/**
	 * Register the plugin settings, create fields
	 */
	function plugin_settings_init() {

		$args = [
			'sanitize_callback' => [ $this, 'sanitize_input' ],
		];

		$page = $options = 'validate_by_domain';

		register_setting(
			$options,
			$options . '_settings',
			$args
		);

		add_settings_section(
			$options . '_section',
			__( 'Validate by Domain Settings', 'validate-by-domain' ),
			'',
			$page
		);

		add_settings_field(
			'validate_enable',
			__( 'Enable', 'validate-by-domain' ),
			[ $this, 'enable_render' ],
			$page,
			$options . '_section'
		);

		add_settings_field(
			'field_num',
			__( 'Field Number', 'validate-by-domain' ),
			[ $this, 'field_render' ],
			$page,
			$options . '_section'
		);

		add_settings_field(
			'validate_role',
			__( 'Role', 'validate-by-domain' ),
			[ $this, 'role_render' ],
			$page,
			$options . '_section'
		);

		add_settings_field(
			'validate_whitelist',
			__( 'Whitelist', 'validate-by-domain' ),
			[ $this, 'whitelist_render' ],
			$page,
			$options . '_section'
		);

	}

	function field_render() {
		$options = get_option( 'validate_by_domain_settings' );

		// add default
		if ( ! isset( $options['field_num'] ) ) {
			$options['field_num'] = 0;
		}

		echo "<input type='text' name='validate_by_domain_settings[field_num]' value='{$options['field_num']}'></br><small class='form-text text-muted'>Integrates with buddypress - set the field ID of the form element on a sign up form.</small>";
	}

	/**
	 * Render the options page enable field
	 */
	function enable_render() {

		$options = get_option( 'validate_by_domain_settings' );

		// add default
		if ( ! isset( $options['validate_enable'] ) ) {
			$options['validate_enable'] = 0;
		}

		echo "<input type='checkbox' name='validate_by_domain_settings[validate_enable]'" . checked( $options['validate_enable'], 1, false ) . " value='1'>";
	}

	/**
	 * Render the options page role selection field
	 */
	function role_render() {
		$options                              = get_option( 'validate_by_domain_settings' );
		( $options['validate_role'] ) ? $role = $options['validate_role'] : $role = 'Subscriber';
		?>
		<select name='validate_by_domain_settings[validate_role]>'
		<?php
		wp_dropdown_roles( $role );
		?>
		</select> </br><small class='form-text text-muted'>The WP role that new users will be put into if their email domain matches one of the whitelisted domains.</small>
		<?php
	}

	/**
	 * Render the options page whitelist field
	 */
	function whitelist_render() {

		$options = get_option( 'validate_by_domain_settings' );
		// add default
		if ( ! isset( $options['validate_whitelist'] ) ) {
			$options['validate_whitelist'] = '';
		}

		echo "<textarea cols='60' rows='15' name='validate_by_domain_settings[validate_whitelist]'>" . $options['validate_whitelist'] . '</textarea></br><small class="form-text text-muted">A list of email domains that will be permitted during self-registration.</small>';

	}

	/**
	 * @param $input
	 *
	 * @return array
	 */
	function sanitize_input( $input ) {
		$domains  = [];
		$integers = [ 'validate_enable', 'field_num' ];

		// strip tags, parse, make list unique, check for domain pattern, trim whitespace
		if ( isset( $input['validate_whitelist'] ) ) {

			// Strip all HTML and PHP tags
			$input['validate_whitelist'] = strip_tags( stripslashes( $input['validate_whitelist'] ) );

			// Split the string by new lines, commas, single space, or multiple whitespace
			$input['validate_whitelist'] = preg_split( "/(\r\n|\n|\r|,|[\s]|[\s][\s])/", $input['validate_whitelist'] );

			// Make items unique
			$input['validate_whitelist'] = array_unique( $input['validate_whitelist'] );

			// make sure they have a valid domain pattern
			// @see https://stackoverflow.com/questions/3026957/how-to-validate-a-domain-name-using-regex-php#16491074
			foreach ( $input['validate_whitelist'] as $k => $domain ) {
				$ok = filter_var( $domain, FILTER_VALIDATE_REGEXP, [ 'options' => [ 'regexp' => '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/' ] ] );
				if ( $ok ) {
					$domains[] = $ok;
				}
			}

			// Removes empty elements created by blank new lines, trim any whitespace before or after
			$input['validate_whitelist'] = array_filter( array_map( 'trim', $domains ) );

			// Let's send back string with one item per line
			$input['validate_whitelist'] = implode( PHP_EOL, $input['validate_whitelist'] );

		}

		// integers
		foreach ( $integers as $int ) {
			$input[ $int ] = absint( $input[ $int ] );
		}

		return $input;

	}


	/**
	 * The function to be called to output the content for the settings page
	 */
	function plugin_options_page() {
		?>
		<form id='vbd_settings' action='options.php' method='post'>

			<?php
			settings_fields( 'validate_by_domain' );
			do_settings_sections( 'validate_by_domain' );
			submit_button();
			?>

		</form>
		<?php
	}

}
