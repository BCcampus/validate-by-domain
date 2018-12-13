<?php

/**
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @since      1.0.0
 *
 * @package    Validate_By_Domain
 * @subpackage Validate_By_Domain/inc
 */
namespace ValidateByDomain;

class Vbd {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      BC_Validate_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $bc_validate The string used to uniquely identify this plugin.
	 */
	protected $bc_validate;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->bc_validate = 'validate-by-domain';
		$this->version     = '1.3.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - BC_Validate_Loader. Orchestrates the hooks of the plugin.
	 * - BC_Validate_i18n. Defines internationalization functionality.
	 * - BC_Validate_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-loader.php';

		/**
		 * The class responsible for the options page of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-options.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-validate.php';

		/**
		 * Class responsible for a honey pot, to thwart spam accounts from being created
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-honeypot.php';

		$this->loader = new Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the BC_Validate_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_bc_validate() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the options page.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_options = new Options();

		$this->loader->add_action( 'admin_menu', $plugin_options, 'plugin_admin_add_page' );
		$this->loader->add_action( 'admin_init', $plugin_options, 'plugin_settings_init' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Validate( $this->get_bc_validate(), $this->get_version() );
		$honey_pot     = new HoneyPot();

		$this->loader->add_filter( 'bp_signup_validate', $plugin_public, 'signupUserBC' );
		$this->loader->add_filter( 'bp_signup_usermeta', $plugin_public, 'signupMetaBC' );
		$this->loader->add_filter( 'bp_core_activate_account', $plugin_public, 'mapRoleToCapability' );
		$this->loader->add_action( 'bp_after_signup_profile_fields', $honey_pot, 'addHoneyPot' );
		$this->loader->add_filter( 'bp_core_validate_user_signup', $honey_pot, 'checkHoneyPot' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_bc_validate() {
		return $this->bc_validate;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    BC_Validate_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
