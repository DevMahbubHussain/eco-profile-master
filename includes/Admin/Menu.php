<?php

namespace EcoProfile\Master\Admin;

/**
 * Admin Menu class
 * Responsible for managing admin menus.
 */
class Menu
{

    /**
     * Slug
     * 
     * @return string
     * 
     */
    public $slug = EP_MASTER_SLUG;

    /**
     * Variable
     * @var string
     */

    public $epm_admin_settings;
    public $epm_form_label_placeholder;

    /**
     * Constructor
     */
    public function __construct($epm_admin_settings, $epm_form_label_placeholder)
    {
        $this->epm_admin_settings = $epm_admin_settings;
        $this->epm_form_label_placeholder = $epm_form_label_placeholder;
        add_action('admin_menu', array($this, 'epm_init_menu'));
    }

    /**
     * Init Menu.
     *
     *
     * @return void
     */

    public function epm_init_menu()
    {
        $menu_position = 50;
        $capability    = 'manage_options';
        $logo_icon = 'dashicons-businessperson';
        add_menu_page(esc_attr__('Eco Profile Master', 'eco-profile-master'), esc_attr__('Eco Profile Master', 'eco-profile-master'), $capability, $this->slug, [$this, 'epm_plugin_page'], $logo_icon, $menu_position);
        add_submenu_page($this->slug, esc_attr__('General Information', 'eco-profile-master'), esc_attr__('General Information', 'eco-profile-master'), $capability, $this->slug, [$this, 'epm_plugin_page']);
        add_submenu_page($this->slug, esc_attr__('Settings', 'eco-profile-master'), esc_attr__('Settings', 'eco-profile-master'), $capability, 'eco-profile-master-settings', [$this->epm_admin_settings, 'epm_plugin_settings_page']);
        add_submenu_page($this->slug, esc_attr__('Form Labels', 'eco-profile-master'), esc_attr__('Form Labels', 'eco-profile-master'), $capability, 'eco-profile-master-form-labels', [$this->epm_form_label_placeholder, 'epm_form_fields_label_plugin_page']);
        add_submenu_page($this->slug, esc_attr__('User Listing', 'eco-profile-master'), esc_attr__('User Listing', 'eco-profile-master'), $capability, 'eco-profile-master-user-listing', [$this, 'user_listings_plugin_page']);
    }


    /**
     * Plugin page callback function
     *
     * @return void
     */
    public function epm_plugin_page()
    {
        require_once EP_MASTER_TEMPLATE_PATH . '/features/general-settings/general.php';
    }

    /**
     * Plugin Settings callback function
     */
    public function plugin_settings_page()
    {
        echo "i am email customizer callback";
    }


    public function admin_bar_plugin_page()
    {
        echo "Admin Bar cb";
    }


    public function user_listings_plugin_page()
    {
        echo '<div class="wrap">';
        echo '<h1>My Custom Page</h1>';
        echo '<p>This is my custom admin page content.</p>';
        echo '</div>';
    }

    public function email_customizer_plugin_page()
    {
        echo "Email CB";
    }

    public function epm_form_fields_plugin_page()
    {
        echo "Working on Later";
    }

    public function epm_form_fields_label_plugin_page()
    {
        echo "I am for label & Placeholder";
    }
}
