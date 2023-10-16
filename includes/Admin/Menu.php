<?php

namespace EcoProfile\Master\Admin;

/**
 * Admin Menu class
 * Responsible for managing admin menus.
 */
class Menu
{
    /**
     * Slug for the main menu page.
     *
     * @var string
     */
    public $slug = EP_MASTER_SLUG;

    /**
     * Variables for plugin settings and form label placeholders.
     *
     * @var string
     */
    public $epm_admin_settings;
    public $epm_form_label_placeholder;

    /**
     * Constructor to initialize the menu class.
     *
     * @param string $epm_admin_settings          Variable for plugin settings.
     * @param string $epm_form_label_placeholder  Variable for form label placeholders.
     */
    public function __construct($epm_admin_settings, $epm_form_label_placeholder)
    {
        $this->epm_admin_settings = $epm_admin_settings;
        $this->epm_form_label_placeholder = $epm_form_label_placeholder;

        // Add an action to create the admin menu.
        add_action('admin_menu', array($this, 'epm_init_menu'));
    }

    /**
     * Initialize the admin menu.
     *
     * @return void
     */
    public function epm_init_menu()
    {
        $menu_position = 50;
        $capability = 'manage_options';
        $logo_icon = 'dashicons-businessperson';

        // Add the main menu page.
        add_menu_page(
            esc_attr__('Eco Profile Master', 'eco-profile-master'), // Page title
            esc_attr__('Eco Profile Master', 'eco-profile-master'), // Menu title
            $capability, // Capability
            $this->slug, // Menu slug
            [$this, 'epm_plugin_page'], // Callback function
            $logo_icon, // Icon for the menu
            $menu_position // Menu position
        );

        // Add sub-menu pages.
        add_submenu_page(
            $this->slug, // Parent menu slug
            esc_attr__('General Information', 'eco-profile-master'), // Page title
            esc_attr__('General Information', 'eco-profile-master'), // Menu title
            $capability, // Capability
            $this->slug, // Menu slug
            [$this, 'epm_plugin_page'] // Callback function
        );

        add_submenu_page(
            $this->slug, // Parent menu slug
            esc_attr__('Settings', 'eco-profile-master'), // Page title
            esc_attr__('Settings', 'eco-profile-master'), // Menu title
            $capability, // Capability
            'eco-profile-master-settings', // Menu slug
            [$this->epm_admin_settings, 'epm_plugin_settings_page'] // Callback function
        );

        add_submenu_page(
            $this->slug, // Parent menu slug
            esc_attr__('Form Labels', 'eco-profile-master'), // Page title
            esc_attr__('Form Labels', 'eco-profile-master'), // Menu title
            $capability, // Capability
            'eco-profile-master-form-labels', // Menu slug
            [$this->epm_form_label_placeholder, 'epm_form_fields_label_plugin_page'] // Callback function
        );
    }

    /**
     * Callback function for the main plugin page.
     *
     * @return void
     */
    public function epm_plugin_page()
    {
        require_once EP_MASTER_TEMPLATE_PATH . '/features/general-settings/general.php';
    }
}
