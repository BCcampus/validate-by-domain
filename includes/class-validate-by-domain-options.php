<?php
/**
 * Created by PhpStorm.
 * User: alexparedes
 * Date: 3/2/18
 * Time: 12:02 PM
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
			__( 'Default user role:', 'WordPress' ),
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

		$options = get_option( 'validate_by_domain_settings' );
		?><input
        type='checkbox'
        name='validate_by_domain_settings[validate_enable]' <?php checked( $options['validate_enable'], 1 ); ?>
        value='1'><?php
	}

	/**
	 * Render the options page role selection field
	 */
	function role_render() {

		$options = get_option( 'validate_by_domain_settings' );
		?>
        <select name='validate_by_domain_settings[validate_role]'>
            <option value='1' <?php selected( $options['validate_role'], 1 ); ?>>Contributor</option>
            <option value='2' <?php selected( $options['validate_role'], 2 ); ?>>Editor</option>
            <option value='3' <?php selected( $options['validate_role'], 3 ); ?>>Author</option>
            <option value='4' <?php selected( $options['validate_role'], 4 ); ?>>Subscriber</option>
        </select>

		<?php

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
		$output = [];

		// Check if the current option has a value. If so, process it.
		if ( isset( $input['validate_whitelist'] ) ) {

			// Strip all HTML and PHP tags
			$output['validate_whitelist'] = strip_tags( stripslashes( $input['validate_whitelist'] ) );

			//todo: Make sure there's only one domain per line, and remove all unnecessary characters

		} // end if

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