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

if (!defined('ABSPATH')) {
	exit;
}


/**
 * The Main Plugin Class
 */
final class Eco_Profile_Master
{
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	const VERSION = '1.0';

	/**
	 * Plugin slug.
	 *
	 * @var string
	 *
	 */
	const SLUG = 'eco-profile-master';

	/**
	 * Holds various class instances.
	 *
	 * @var array
	 *
	 */
	private $container = [];

	/**
	 * Class Constructor
	 */
	private function __construct()
	{
		require_once __DIR__ . '/vendor/autoload.php';
		$this->epm_define_constants();
		register_activation_hook(__FILE__, array($this, 'epm_activate'));
		register_deactivation_hook(__FILE__, array($this, 'epm_deactice'));
		add_action('plugins_loaded', array($this, 'epm_plugin_init'));
		add_action('wp_loaded', [$this, 'flush_rewrite_rules']);
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return \Eco_Profile_Master
	 */
	public static function init()
	{
		static $instance = false;

		if (!$instance) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 *
	 * @param $prop
	 *
	 * @return mixed
	 */
	public function __get($prop)
	{
		if (array_key_exists($prop, $this->container)) {
			return $this->container[$prop];
		}

		return $this->{$prop};
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param $prop
	 *
	 * @return mixed
	 */
	public function __isset($prop)
	{
		return isset($this->{$prop}) || isset($this->container[$prop]);
	}

	/**
	 * Define the required plugin constants
	 *
	 * @return void
	 */
	public function epm_define_constants()
	{
		define('EP_MASTER_VERSION', self::VERSION);
		define('EP_PROFILE_FILE', __FILE__);
		define('EP_MASTER_PATH', __DIR__);
		define('EP_MASTER_URL', plugins_url('', EP_PROFILE_FILE));
		define('EP_MASTER_ASSETS', EP_MASTER_URL . '/src/assets');
		define('EP_MASTER_BUILD', EP_MASTER_URL . '/build');
		define('EP_MASTER_SLUG', self::SLUG);
	}

	/**
	 * Plugin activation
	 *
	 * @return void
	 */
	public function epm_activate()
	{
		$installed = get_option('epm_installed');
		if (!$installed) {

			update_option('epm_installed', time());
		}
		update_option('epm_version', EP_MASTER_VERSION);
	}

	/**
	 * Placeholder for deactivation function.
	 *
	 * @return void
	 */
	public function epm_deactice()
	{
		// do somthing in deactivate
	}
	/**
	 * Flush rewrite rules after plugin is activated.
	 *
	 */
	public function flush_rewrite_rules()
	{
		// fix rewrite rules
	}

	/**
	 * Initialize the plugin
	 *
	 * @return void
	 */
	public function epm_plugin_init()
	{
		$this->includes();
	}

	/**
	 * Include the required files.
	 *
	 * @return void
	 */
	public function includes()
	{
		if ($this->is_request('admin')) {
			$this->container['admin_menu'] = new \EcoProfile\Master\Admin\Menu();
		} elseif ($this->is_request('frontend')) {
			$this->container['forntend_shortcode'] = new \EcoProfile\Master\Frontend\Shortcode();
		}

		// Common classes
	}

	/**
	 * Initialize the hooks.
	 *
	 * @return void
	 */
	public function init_hooks()
	{
		// Localize our plugin
		add_action('init', [$this, 'localization_setup']);
	}

	/**
	 * Initialize plugin for localization.
	 *
	 * @uses load_plugin_textdomain()
	 *
	 * @return void
	 */
	public function localization_setup()
	{
		load_plugin_textdomain('echo-profile-master', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	/**
	 * What type of request is this.
	 *
	 * @param string $type admin, ajax, cron or frontend
	 *
	 * @return bool
	 */
	private function is_request($type)
	{
		switch ($type) {
			case 'admin':
				return is_admin();

			case 'ajax':
				return defined('DOING_AJAX');

			case 'rest':
				return defined('REST_REQUEST');

			case 'cron':
				return defined('DOING_CRON');

			case 'frontend':
				return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
		}
	}
}

/**
 * Initializes the main plugin
 *
 * @return \Eco_Profile_Master
 */
function ep_master()
{
	return Eco_Profile_Master::init();
}

// kick-off the plugin.
ep_master();
