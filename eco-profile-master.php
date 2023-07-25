<?php
/**
 * Plugin Name:       Eco Profile Master
 * Plugin URI:        https://echologytheme.com/plugins/eco-profile-master/
 * Description:       Login, registration and edit profile shortcodes for the front-end. Also you can choose what fields should be displayed or add new (custom) ones both in the front-end and in the dashboard.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mahbub Hussain
 * Author URI:        https://mahbub.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       echo-profile-master
 * Domain Path:       /languages
 *
 * @package Eco Profile Master
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . '/vendor/autoload.php';

/**
 * The Main Plugin Class
 */
final class Eco_Profile_Master {
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	const VERSION = '1.0';

	/**
	 * Class Constructor
	 */
	private function __construct() {
		$this->define_constants();
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return \Eco_Profile_Master
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'EP_MASTER_VERSION', self::VERSION );
		define( 'EP_PROFILE_FILE', __FILE__ );
		define( 'EP_MASTER_PATH', __DIR__ );
		define( 'EP_PROFILE_URL', plugins_url( '', EP_PROFILE_FILE ) );
		define( 'EP_MASTER_ASSETS', EP_PROFILE_URL . '/assets' );
		define( 'EP_MASTER_BUILD', EP_PROFILE_URL . '/build' );
	}

}
	/**
	 * Initializes the main plugin
	 *
	 * @return \Eco_Profile_Master
	 */
function ep_master() {
	return Eco_Profile_Master::init();
}

// kick-off the plugin.
ep_master();
