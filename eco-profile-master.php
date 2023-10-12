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
		$installed = get_option('epm_installed');
		if (!$installed) {

			update_option('epm_installed', time());
		}
		update_option('epm_version', EP_MASTER_VERSION);

		// general settings
		$epm_general_default_options = array(
			'epm_form_style' => __('Style 1', 'eco-profile-master'),
			'epm_automatically_login' => __('no', 'eco-profile-master'),
			'epm_email_confirmation_activated' => __('no', 'eco-profile-master'),
			'epm_admin_approval' => __('no', 'eco-profile-master'),
			'epm_display_email' => __('yes', 'eco-profile-master'),
			'epm_display_phone_number' => __('no', 'eco-profile-master'),
			'epm_image' => __('no', 'eco-profile-master'),
			'epm_mailing_address' => __('no', 'eco-profile-master'),
			'epm_display_social_links' => __('no', 'eco-profile-master')
		);

		// Loop through the array and add options using add_option
		foreach ($epm_general_default_options as $option_name => $general_default_value) {
			add_option($option_name, $general_default_value);
		}

		// Dynamically create a new page for password recovery
		$recover_password_page_title = __('Recover-Password', 'eco-profile-master');
		$login_page_title = __('Login', 'eco-profile-master');
		$login_profile_title = __('Profile Edit', 'eco-profile-master');
		$slug = 'recover-password';
		$recover_password_page = array(
			'post_title' => $recover_password_page_title,
			'post_name'     => $slug,
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_content'  => "<!-- wp:shortcode -->[epm-pass-recover]<!-- /wp:shortcode -->",
		);
		$recover_password_page_id = wp_insert_post($recover_password_page);

		if (!is_wp_error($recover_password_page_id)) {
			// Set the page title in the settings option
			update_option('epm_lost_password_page', $recover_password_page_title);
			update_option('epm_login_page', $login_page_title);
			update_option('epm_profile_page', $login_profile_title);
		}

		// Default values for advanced settings
		$epm_default_advanced_settings = array(
			'epm_email_confirmation' => 1,
			'epm_remember_me' => 0,
			'epm_send_credentials' => 1,
			'epm_first_lastname_captitilize' => 0,
			'epm_user_gender' => 1,
			'epm_user_birthdate' => 0,
			'epm_user_occupation' => 0,
			'epm_user_religion' => 0,
			'epm_user_skin_color' => 0,
			'epm_user_blood_group' => 0,
			'epm_facebook_url' => 1,
			'epm_twitter_url' => 1,
			'epm_linkedin_url' => 1,
			'epm_youtube_url' => 1,
			'epm_instagram_url' => 1
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
			'mailing_address' => __('Mailing Address', 'eco-profile-master'),
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
			'facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'image',
			'occupation', 'religion', 'skin', 'gender', 'birthdate', 'blood', 'house',
			'road', 'location'
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
				$default_values[$field]['label'] = __('Upload your profile image', 'eco-profile-master');
				unset($default_values[$field]['placeholder']);
			}
		}

		update_option('epm_form_label_placeholder', $default_values);


		// plugin pages 
		$this->epm_plugin_pages('login', 'Login', 'epm-login');
		$this->epm_plugin_pages('register', 'Registration', 'epm-register');
		$this->epm_plugin_pages('new-password-form', 'Pick a New Password', 'epm-password-reset-form');
		$this->epm_plugin_pages('profile-edit', 'Profile Edit', 'epm-profile-edit');
		$this->epm_plugin_pages('listings', 'User Listings', 'epm-user-listings');

		flush_rewrite_rules();
	}

	/**
	 * Plugin pages with shortcodes function.
	 *
	 * @param [type] $slug
	 * @param [type] $title
	 * @param [type] $shortcode
	 * @return void
	 */
	public function epm_plugin_pages($slug, $title, $shortcode)
	{
		global $wpdb;
		if ($wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = '$slug'") === null) {

			$current_user = wp_get_current_user();

			$page = array(
				'post_title'    => __($title, 'echo-profile-master'),
				'post_name'     => $slug,
				'post_status'   => 'publish',
				'post_author'   => $current_user->ID,
				'post_type'     => 'page',
				'post_content'  => "<!-- wp:shortcode -->[$shortcode]<!-- /wp:shortcode -->",
			);

			wp_insert_post($page);
		}
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
		$epm_general_settings_options_to_delete = array(
			'epm_form_style',
			'epm_automatically_login',
			'epm_email_confirmation_activated',
			'epm_admin_approval',
			'epm_display_email',
			'epm_display_phone_number',
			'epm_image',
			'epm_mailing_address',
			'epm_display_social_kinks',
			'epm_lost_password_page' // Delete the "Select Recover Password Page" option
		);

		foreach ($epm_general_settings_options_to_delete as $option_name) {
			delete_option($option_name);
		}

		// Additional code to delete pages if needed
		$page_option_names = array(
			'epm_lost_password_page',
			'epm_login_page',
			'epm_profile_page',
		);
		foreach ($page_option_names as $option_name) {
			$page_id = get_option($option_name);

			if ($page_id) {
				wp_delete_post($page_id, true);
				delete_option($option_name);
			}
		}

		// Delete advanced settings options
		$epm_advanced_settings_options_to_delete = array(
			'epm_email_confirmation',
			'epm_remember_me',
			'epm_first_lastname_captitilize',
			'epm_user_gender',
			'epm_user_birthdate',
			'epm_user_occupation',
			'epm_user_religion',
			'epm_user_skin_color',
			'epm_user_blood_group',
			'epm_facebook_url',
			'epm_twitter_url',
			'epm_linkedin_url',
			'epm_youtube_url',
			'epm_instagram_url'
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
			'mailing_address',

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

		// delete all plugin pages
		$this->epm_plugin_deactive_pages();

		//recover page delete
		$page_id = get_page_by_path('recover-password');
		if ($page_id) {
			wp_delete_post($page_id->ID, true);
		}
	}

	public function epm_plugin_deactive_pages()
	{
		$pages_to_delete = array('login', 'register', 'profile-edit', 'listings', 'new-password-form');
		foreach ($pages_to_delete as $page_slug) {
			$page_id = get_page_by_path($page_slug);
			if ($page_id) {
				wp_delete_post($page_id->ID, true);
			}
		}
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
