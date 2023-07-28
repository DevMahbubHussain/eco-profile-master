<?php

namespace EcoProfile\Master\Admin;

/**
 * Admin Menu class
 * Responsible for managing admin menus.
 */
class Menu
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'epm_init_menu']);
    }

    /**
     * Init Menu.
     *
     *
     * @return void
     */

    public function epm_init_menu()
    {
        $slug = EP_MASTER_SLUG;
        $menu_position = 50;
        $capability    = 'manage_options';
        $logo_icon = 'dashicons-businessperson';
        add_menu_page(esc_attr__('Eco Profile Master', 'eco-profile-master'), esc_attr__('Eco Profile Master', 'eco-profile-master'), $capability, $slug, [$this, 'epm_plugin_page'], $logo_icon, $menu_position);
        add_submenu_page($slug, esc_attr__('Basic Information', 'eco-profile-master'), esc_attr__('Basic Information', 'eco-profile-master'), $capability, $slug, [$this, 'epm_plugin_page']);
        add_submenu_page($slug, esc_attr__('Settings', 'eco-profile-master'), esc_attr__('Settings', 'eco-profile-master'), $capability, 'eco-profile-master-settings', [$this, 'epm_plugin_settings_page']);
        add_submenu_page($slug, esc_attr__('Form Fields', 'eco-profile-master'), esc_attr__('Form Fields', 'eco-profile-master'), $capability, 'eco-profile-master-form-fields', [$this, 'epm_plugin_form_fields_page']);
        add_submenu_page($slug, esc_attr__('User Listing', 'eco-profile-master'), esc_attr__('User Listing', 'eco-profile-master'), $capability, 'eco-profile-master-user-listing', [$this, 'epm_plugin_user_listing_page']);
    }


    /**
     * Render the plugin page.
     * @return void
     */

    /**
     * Plugin page callback function
     *
     * @return void
     */
    public function epm_plugin_page()
    {
        echo "I am plugin page";
    }

    /**
     * Plugin Settings callback function
     */

    public function epm_plugin_settings_page()
    {
        echo 'Plugin Settings';
    }
    /**
     * Plugin form fields callback function
     */

    public function epm_plugin_form_fields_page()
    {
        echo "I am forms fields";
    }

    public function epm_plugin_user_listing_page()
    {
        echo "User Listings";
    }
}
