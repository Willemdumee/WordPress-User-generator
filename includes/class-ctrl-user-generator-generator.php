<?php

/**
 * @package    Ctrl_User_Generator
 * @subpackage Ctrl_User_Generator/admin
 * @author     Willem Dumee <willemdumee@gmail.com>
 */
class Ctrl_User_Generator_Generator {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 *  email address of site admin
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var
	 */
	private $admin_email;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * @since   0.5.0
	 * @access  private
	 * @var     array
	 */
	private $userlist;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.5.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 *   adds the User Generator page to the admin menu
	 */
	public function display_admin_page() {
		add_menu_page( 'User generator Page', 'User Generator', 'manage_options', 'user-generator',
			array( $this, 'show_admin_page' ) );
	}

	/**
	 *   shows the actual user generator page
	 */
	public function show_admin_page() {
		include CTRL_USER_GENERATOR_PLUGIN_DIR . '/templates/user-generator-page.php';
	}

	/**
	 *   the alax functionality for submitting new users
	 */
	function generate_users_javascript() { ?>
		<script type="text/javascript">
			jQuery(document).ready(function () {

				jQuery('#generate_users_form').submit(function (e) {
					e.preventDefault();
					var data = jQuery(this).serialize();
					jQuery('.message p').text('').hide();

					jQuery.post(ajaxurl, data, function (response) {
						jQuery('.message p').text(response).show();
					});
				});
			});
		</script> <?php
	}

	/**
	 *   The callback function for displaying if users were made
	 */
	function generate_users_callback() {
		$this->admin_email = get_option( 'admin_email' );
		$nonce = $_REQUEST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'generate_users' ) ) {
			return;
		}
		$iterations = sanitize_text_field( $_POST['iterations'] );
		$category   = sanitize_text_field( $_POST['user-category'] );
		$role       = sanitize_text_field( $_POST['user-role'] );

		$this->generate_users( $iterations, $role, $category );

		if ( empty( $this->userlist ) ) {
			echo 'No users were created';
		} else {
			$this->send_mail();
			$count_users = count( $this->userlist );
			echo "{$count_users} {$role}(s) were created and an email was sent to {$this->admin_email}";
		}

		wp_die();
	}

	/**
	 * Gets the users from the attached Json files
	 *
	 * @param $category
	 *
	 * @return mixed
	 */
	private function get_users_from_file( $category ) {
		$file = file_get_contents( CTRL_USER_GENERATOR_PLUGIN_DIR . "/data/{$category}-users.json" );
		$data = json_decode( $file, true );

		return $data['users'];
	}

	/**
	 * @param int $iterations
	 * @param string $role
	 * @param string $category
	 */
	private function generate_users( $iterations = 1, $role = 'subscriber', $category = 'starwars' ) {
		$users = $this->get_users_from_file( $category );
		if (! $users)
			return;

		shuffle( $users );
		$i = 0;
		foreach ( $users as $user ) {
			if ( $i < $iterations ) {
				$user_id = username_exists( $user['username'] );
				if ( ! $user_id AND false == email_exists( $user['email'] ) ) {
					$user_created = $this->generate_user( $user, $role );
					if ( false == $user_created ) {
						continue;
					}
					$i ++;
				}
			}
		}
	}

	/**
	 * @param $user
	 * @param $role
	 *
	 * @return bool
	 */
	private function generate_user( $user, $role ) {
		$password = wp_generate_password( 12, false );
		$user_id  = wp_create_user( $user['username'], $password, $user['email'] );

		if ( $user_id ) {
			$this->userlist[ $user['email'] ] = $password;

			wp_update_user(
				array(
					'ID'       => $user_id,
					'nickname' => $user['name']
				)
			);

			/** Set the role */
			$user = new WP_User( $user_id );
			$user->set_role( $role );

			return true;
		}

		return false;
	}

	/**
	 *  Send email to site admin to list the new test-users and passwords
	 */
	private function send_mail() {
		$message = __('the following users have been added:', 'ctrl-user-generator') . PHP_EOL;
		foreach ( $this->userlist as $key => $value ) {
			$message .= "email: {$key} , password: {$value}" . PHP_EOL;
		}

		wp_mail( $this->admin_email, __('Your user registrations', 'ctrl-user-generator'), $message );
	}
}
