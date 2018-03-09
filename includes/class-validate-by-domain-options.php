<?php
/**
 * All of the functionality for the plugins options page in the dashboard
 */

class Validate_By_Domain_Options {

	public function plugin_admin_add_page() {

		add_options_page( 'Validate by Domain', 'Validate by Domain', 'manage_options', 'validate_by_domain', [
			$this,
			'plugin_options_page'
		] );

	}

	/**
	 * Register the plugin settings, create fields
	 */
	function plugin_settings_init() {

		$args = array(
			'sanitize_callback' => [ $this, 'sanitize_input' ],
		);

		register_setting( 'validate_by_domain', 'validate_by_domain_settings', $args );

		add_settings_section(
			'options_section',
			__( '', 'WordPress' ),
			'',
			'validate_by_domain'
		);

		add_settings_field(
			'validate_enable',
			__( 'Enable', 'WordPress' ),
			[ $this, 'enable_render' ],
			'validate_by_domain',
			'options_section'
		);

		add_settings_field(
			'validate_role',
			__( 'Role', 'WordPress' ),
			[ $this, 'role_render' ],
			'validate_by_domain',
			'options_section'
		);

		add_settings_field(
			'validate_whitelist',
			__( 'Whitelist', 'WordPress' ),
			[ $this, 'whitelist_render' ],
			'validate_by_domain',
			'options_section'
		);

	}

// todo: Check for the existence of the key before using it in a condition, in the render functions below (avoid Illegal string offset)

	/**
	 * Render the options page enable field
	 */
	function enable_render() {

		$options      = get_option( 'validate_by_domain_settings' );
		$enable_value = checked( $options['validate_enable'], 1, false );
		$html         = "<input type='checkbox' name='validate_by_domain_settings[validate_enable]' {$enable_value} value='1' >";

		echo $html;
	}

	/**
	 * Render the options page role selection field
	 */
	function role_render() {
		$options = get_option( 'validate_by_domain_settings' );
		( $options['validate_role'] ) ? $role = $options['validate_role'] : $role = 'Subscriber';
		?> <select name='validate_by_domain_settings[validate_role]>'
		<?php
		wp_dropdown_roles( $role );
		?></select> <?php
	}

	/**
	 * Render the options page whitelist field
	 */
	function whitelist_render() {

		$options = get_option( 'validate_by_domain_settings' );
		?>
        <textarea cols='60' rows='15'
                  name='validate_by_domain_settings[validate_whitelist]'><?php echo $options['validate_whitelist']; ?></textarea>
		<?php

	}

	/**
	 * @param $input
	 * Sanitize the whitelist
	 *
	 * @return mixed|void
	 */
	function sanitize_input( $input ) {

		// Create our array for storing the sanitized options
		$output = $domains = [];

		// add all of our options to the output
		foreach ( $input as $key => $value ) {
			$output[ $key ] = $value;
		}

		// Check if the current option has a value. If so, process it.
		if ( isset( $input['validate_whitelist'] ) ) {

			// Strip all HTML and PHP tags
			$output['validate_whitelist'] = strip_tags( stripslashes( $input['validate_whitelist'] ) );

			// Split the string by new lines, commas, single space, or multiple whitespace
			$output['validate_whitelist'] = preg_split( "/(\r\n|\n|\r|,|[\s]|[\s][\s])/", $output['validate_whitelist'] );

			// Make items unique
			$output['validate_whitelist'] = array_unique( $output['validate_whitelist'] );

			// make sure they have a valid domain pattern
			// @see https://stackoverflow.com/questions/3026957/how-to-validate-a-domain-name-using-regex-php#16491074
			foreach ( $output['validate_whitelist'] as $k => $domain ) {
				$ok = filter_var( $domain, FILTER_VALIDATE_REGEXP, [ 'options' => [ 'regexp' => '/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/' ] ] );
				if ( $ok ) {
					$domains[] = $ok;
				}
			}

			// Removes empty elements created by blank new lines, trim any whitespace before or after
			$output['validate_whitelist'] = array_filter( array_map( 'trim', $domains ) );

			// Let's send back string with one item per line
			$output['validate_whitelist'] = implode( PHP_EOL, $output['validate_whitelist'] );

		}

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'sanitize_input', $output, $input );

	}


	/**
	 * The function to be called to output the content for the settings page
	 */
	function plugin_options_page() {
		?>
        <form action='options.php' method='post'>

            <h2>Validate by Domain Options</h2>

			<?php
			settings_fields( 'validate_by_domain' );
			do_settings_sections( 'validate_by_domain' );
			submit_button();
			?>

        </form>
		<?php
	}

}