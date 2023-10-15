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
 * @package EcoProfileMaster
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
	 * Class Constructor
	 *
	 * Initializes the plugin, autoloads classes, defines constants, and registers hooks.
	 *
	 * @since 1.0.0
	 */
	private function __construct()
	{
		require_once __DIR__ . '/vendor/autoload.php';
		$this->epm_define_constants();
		register_activation_hook(__FILE__, array($this, 'epm_activate'));
		register_deactivation_hook(__FILE__, array($this, 'epm_deactive'));
		$this->epm_add_hooks();
	}

	/**
	 * Adds hooks for plugin functionality.
	 *
	 * Registers WordPress actions and filters to initiate specific
	 * functionalities of the plugin, including localization setup and
	 * plugin action links.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function epm_add_hooks()
	{
		add_action('plugins_loaded', array($this, 'epm_plugin_init'));
		// Localize our plugin
		add_action('init', [$this, 'localization_setup']);
		// Add the plugin page links
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']);
	}

	/**
	 * Initializes a singleton instance.
	 *
	 * This method ensures that only one instance of the class is created
	 * during its lifetime. If an instance doesn't exist, it creates one.
	 *
	 * @since 1.0.0
	 *
	 * @return \Eco_Profile_Master The singleton instance.
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
	 * Define required plugin constants.
	 *
	 * Sets up fundamental constants for the plugin, such as version,
	 * paths, URLs, and asset directories.
	 *
	 * @since 1.0.0
	 */
	public function epm_define_constants()
	{
		define('EP_MASTER_VERSION', self::VERSION);
		define('EP_PROFILE_FILE', __FILE__);
		define('EP_MASTER_DIR', __DIR__);
		define('EP_MASTER_PATH', dirname(EP_PROFILE_FILE));
		define('EP_MASTER_URL', plugins_url('', EP_PROFILE_FILE));
		define('EP_MASTER_ASSETS', EP_MASTER_URL . '/src/assets');
		define('EP_MASTER_BUILD', EP_MASTER_URL . '/build');
		define('EP_MASTER_SLUG', self::SLUG);
		define('EP_MASTER_TEMPLATE_PATH', EP_MASTER_PATH . '/templates');
	}

	/**
	 * Plugin activation.
	 *
	 * Handles plugin activation by updating installation time and version.
	 * Additionally, flushes rewrite rules to ensure proper permalink structure.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function epm_activate()
	{
		$installer = new \EcoProfile\Master\Installer();
		$installer->run();
	}

	/**
	 * Plugin deactivation function.
	 *
	 * This method for deactivation-related tasks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function epm_deactive()
	{
		$unstaller = new \EcoProfile\Master\Uninstall();
		$unstaller->run();
	}

	/**
	 * Initialize the plugin.
	 *
	 * Initiates the plugin by including required files and initializing components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function epm_plugin_init()
	{
		$this->includes();
	}

	/**
	 * Include required files and initialize components.
	 *
	 * Conditionally includes necessary files based on the current request type (admin or frontend).
	 * Initializes admin, frontend, and common components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes()
	{
		if ($this->is_request('admin')) {
			$this->init_admin();
		} elseif ($this->is_request('frontend')) {
			$this->init_frontend();
		}
		// Initialize common classes
		$this->init_common();
	}

	/**
	 * Initialize admin components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_admin()
	{
		new \EcoProfile\Master\Admin();
	}

	/**
	 * Initialize frontend components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_frontend()
	{
		new \EcoProfile\Master\Frontend();
	}

	/**
	 * Initialize common components.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_common()
	{
		new \EcoProfile\Master\Assets\Manager();
		// ... other common component initializations ...
	}

	/**
	 * Initialize plugin for localization.
	 *
	 * Sets up localization for the plugin by loading the translation files
	 * and setting script translations for localization.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function localization_setup()
	{
		load_plugin_textdomain('echo-profile-master', false, dirname(plugin_basename(__FILE__)) . '/languages');

		if (is_admin()) {
			// Load script translation for wp-scripts
			wp_set_script_translations('ep-master-js', 'echo-profile-master', plugin_dir_path(__FILE__) . 'languages/');
		}
	}


	/**
	 * Determine the type of request.
	 *
	 * Determines the type of request being made (admin, ajax, cron, frontend) based on the provided $type parameter.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type The type of request to check (admin, ajax, cron, frontend).
	 *
	 * @return bool Whether the current request matches the specified type.
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

	/**
	 * Generate plugin action links.
	 *
	 * Adds a "Settings" link to the plugin's action links.
	 *
	 * @since 1.0.0
	 *
	 * @param array $links Existing action links.
	 * @return array Modified action links with the added "Settings" link.
	 */

	public function plugin_action_links($links)
	{
		$links[] = '<a href="' . admin_url('admin.php?page=eco-profile-master-settings') . '">' . __('Settings', ' echo-profile-master') . '</a>';
		return $links;
	}
}

/**
 * Initialize the main plugin.
 *
 * Initializes the Eco_Profile_Master plugin and returns its instance.
 *
 * @since 1.0.0
 *
 * @return \Eco_Profile_Master The main plugin instance.
 */

function epm_master()
{
	return Eco_Profile_Master::init();
}

/**
 * Kick off the plugin.
 *
 * Initializes and starts the Eco_Profile_Master plugin.
 *
 * @since 1.0.0
 */
epm_master();
