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
		register_deactivation_hook(__FILE__, array($this, 'epm_deactice'));
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
		$installed = get_option('epm_installed');
		if (!$installed) {

			update_option('epm_installed', time());
		}
		update_option('epm_version', EP_MASTER_VERSION);

		// general settings
		$epm_general_default_options = array(
			'epm_form_style' => __('Style 1', 'eco-profile-master'),
			'epm_automatically_login' => __('No', 'eco-profile-master'),
			'epm_email_confirmation_activated' => __('No', 'eco-profile-master'),
			'epm_admin_approval' => __('No', 'eco-profile-master'),
			'epm_loginwith' => __('Username and Email', 'eco-profile-master'),
			'epm_display_email' => __('Yes', 'eco-profile-master'),
			'epm_display_phone_number' => __('No', 'eco-profile-master'),
			'epm_image' => __('No', 'eco-profile-master'),
			'epm_display_social_kinks' => __('No', 'eco-profile-master')
		);

		// Loop through the array and add options using add_option
		foreach ($epm_general_default_options as $option_name => $general_default_value) {
			add_option($option_name, $general_default_value);
		}

		// Dynamically create a new page for password recovery
		$recover_password_page_title = __('Recover Password', 'eco-profile-master');
		$recover_password_page_content = ''; // You can set content if needed
		$recover_password_page = array(
			'post_title' => $recover_password_page_title,
			'post_content' => $recover_password_page_content,
			'post_status' => 'publish',
			'post_type' => 'page'
		);
		$recover_password_page_id = wp_insert_post($recover_password_page);

		if (!is_wp_error($recover_password_page_id)) {
			// Set the page title in the settings option
			update_option('epm_lost_password_page', $recover_password_page_title);
		}

		// Default values for advanced settings
		$epm_default_advanced_settings = array(
			'epm_email_confirmation' => 1,
			'epm_remember_me' => 0,
			'epm_auto_login_pass_reset' => 0,
			'epm_auto_generate_pass' => 0,
			'epm_first_lastname_captitilize' => 0
		);

		// Default values for advanced settings
		$epm_default_advanced_settings = array(
			'epm_email_confirmation' => 1,
			'epm_remember_me' => 0,
			'epm_auto_login_pass_reset' => 0,
			'epm_auto_generate_pass' => 0,
			'epm_first_lastname_captitilize' => 0
		);
		foreach ($epm_default_advanced_settings as $option_name => $default_value) {
			add_option($option_name, $default_value);
		}

		// Set default values for form headings and show/hide checkboxes
		$epm_form_sections_headings = array(
			'name' => __('Name', 'eco-profile-master'),
			'contact_info' => __('Contact Info', 'eco-profile-master'),
			'about_yourself' => __('About Yourself', 'eco-profile-master'),
			'profile_image' => __('Profile Image', 'eco-profile-master'),
			'social_links' => __('Social Links', 'eco-profile-master'),
		);

		foreach ($epm_form_sections_headings as $section_key => $section_label) {
			$option_name = "epm_form_heading_$section_key";
			$hide_option_name = "epm_form_heading_{$section_key}_hide";

			if (!get_option($option_name)) {
				add_option($option_name, $section_label);
			}

			if (!get_option($hide_option_name)) {
				add_option($hide_option_name, '1'); // Default to "Show"
			}
		}

		// default value for labels and placeholder
		$fields = array(
			'username', 'firstname', 'lastname', 'nickname', 'email',
			'phone', 'website', 'biographical', 'password', 'repassword',
			'facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'image'
		);

		$default_values = array();
		foreach ($fields as $field) {
			$default_label = __($field === 'repassword' ? 'Repeat Password' : ucwords(str_replace('_', ' ', $field)), 'eco-profile-master');
			$default_placeholder = __('Enter your ' . ($field === 'repassword' ? 'password again for confirmation' : str_replace('_', ' ', $field)), 'eco-profile-master');
			if (in_array($field, array('facebook', 'twitter', 'linkedin', 'youtube', 'instagram'))) {
				$default_label = __('Enter your ' . ucwords(str_replace('_', ' ', $field)) . ' url', 'eco-profile-master');
				$default_placeholder = $default_label;
			}

			$default_values[$field] = array(
				'label' => $default_label,
				'placeholder' => $default_placeholder,
			);

			if ($field === 'image') {
				$default_values[$field]['label'] = __('Upload your profile image', 'eco-profile-master'); // Change label to 'Image'
				unset($default_values[$field]['placeholder']);
			}
		}

		update_option('epm_form_label_placeholder', $default_values);

		flush_rewrite_rules();
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
	public function epm_deactice()
	{
		$epm_general_settings_options_to_delete = array(
			'epm_form_style',
			'epm_automatically_login',
			'epm_email_confirmation_activated',
			'epm_admin_approval',
			'epm_loginwith',
			'epm_display_email',
			'epm_display_phone_number',
			'epm_image',
			'epm_display_social_kinks',
			'epm_lost_password_page' // Delete the "Select Recover Password Page" option
		);

		foreach ($epm_general_settings_options_to_delete as $option_name) {
			delete_option($option_name);
		}

		// Additional code to delete pages if needed
		$recover_password_page_id = get_option('epm_lost_password_page');
		if ($recover_password_page_id) {
			wp_delete_post($recover_password_page_id, true);
		}

		// Delete advanced settings options
		$epm_advanced_settings_options_to_delete = array(
			'epm_email_confirmation',
			'epm_remember_me',
			'epm_auto_login_pass_reset',
			'epm_auto_generate_pass',
			'epm_first_lastname_captitilize'
		);

		foreach ($epm_advanced_settings_options_to_delete as $option_name) {
			delete_option($option_name);
		}


		// Delete options for form headings and show/hide checkboxes
		$epm_form_sections_headings = array(
			'name',
			'contact_info',
			'about_yourself',
			'profile_image',
			'social_links',
		);

		foreach ($epm_form_sections_headings as $section_key) {
			$option_name = "epm_form_heading_$section_key";
			$hide_option_name = "epm_form_heading_{$section_key}_hide";
			$epm_form_headings_options_to_delete[] = $option_name;
			$epm_form_headings_options_to_delete[] = $hide_option_name;
		}

		foreach ($epm_form_headings_options_to_delete as $option_name) {
			delete_option($option_name);
		}
		// delete default value for labels and placeholder 
		delete_option('epm_form_label_placeholder');
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
