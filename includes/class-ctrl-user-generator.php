<?php

/**
 * Core plugin class
 *
 * @link       http://willemdumee.nl
 * @since      0.5.0
 *
 * @package    Ctrl_User_Generator
 * @subpackage Ctrl_User_Generator/includes
 */

class Ctrl_User_Generator {

	/**
	 * @since    0.5.0
	 * @access   protected
	 * @var      Ctrl_User_Generator_Loader $loader
	 */
	protected $loader;

	/**
	 * @since    0.5.0
	 * @access   protected
	 * @var      string $plugin_name
	 */
	protected $plugin_name;

	/**
	 * @since    0.5.0
	 * @access   protected
	 * @var      string $version
	 */
	protected $version;

	/**
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, set the locale
	 *
	 * @since    0.5.0
	 */
	public function __construct() {

		$this->plugin_name = 'ctrl-user-generator';
		$this->version     = '0.5.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_generator_hooks();
	}

	/**
	 * Load the required dependencies
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ctrl_User_Generator_i18n. Defines internationalization functionality.
	 * - Ctrl_User_Generator_Loader. Orchestrates the hooks of the plugin.
	 * - Ctrl_User_Generator_Generator. Defines all hooks.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function load_dependencies() {
		
		require_once CTRL_USER_GENERATOR_PLUGIN_DIR  . 'includes/class-ctrl-user-generator-i18n.php';

		require_once CTRL_USER_GENERATOR_PLUGIN_DIR  . 'includes/class-ctrl-user-generator-loader.php';

		require_once CTRL_USER_GENERATOR_PLUGIN_DIR  . 'includes/class-ctrl-user-generator-generator.php';

		$this->loader = new Ctrl_User_Generator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ctrl_User_Generator_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register the hooks
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_generator_hooks() {

		$plugin_admin = new Ctrl_User_Generator_Generator(  $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'display_admin_page' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'generate_users_javascript' );
		$this->loader->add_action( 'wp_ajax_generate_users', $plugin_admin, 'generate_users_callback' );
	}
	
	/**
	 * @since     0.5.0
	 * @return    string  
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * @since     0.5.0
	 * @return    string 
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * @since    0.5.0
	 */
	public function run() {
		$this->loader->run();
	}
}
