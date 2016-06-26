<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://willemdumee.nl
 * @since      0.5.0
 *
 * @package    Ctrl_News
 * @subpackage Ctrl_News/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.5.0
 * @package    Ctrl_User_Generator
 * @subpackage Ctrl_User_Generator/includes
 * @author     Willem Dumee <willemdumee@gmail.com>
 */
class Ctrl_User_Generator_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string $domain The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.5.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    0.5.0
	 *
	 * @param    string $domain The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}

}
