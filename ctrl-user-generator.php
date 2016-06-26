<?php

/**
  *
 * @link              http://willemdumee.nl
 * @since             0.5.0
 * @package           Ctrl_User_Generator
 *
 * @wordpress-plugin
 * Plugin Name:       CTRL User Generator
 * Plugin URI:        http://willemdumee.nl/usergenerator/
 * Description:       Easily generate new - fake - users to test your plugin / theme of website
 * Version:           0.5.0
 * Author:            Willem Dumee
 * Author URI:        http://willemdumee.nl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ctrl-news
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CTRL_USER_GENERATOR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require CTRL_USER_GENERATOR_PLUGIN_DIR . 'includes/class-ctrl-user-generator.php';


/**
 * Begins execution of the plugin.
 * This plugin uses the structure of the Wordpres Plugin Boilerplate 
 * http://wppb.me
 *
 * @since    0.5.0
 */
function run_ctrl_user_generator() {

	$plugin = new Ctrl_User_Generator();
	$plugin->run();
}

run_ctrl_user_generator();