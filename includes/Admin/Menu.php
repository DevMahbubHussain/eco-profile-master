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
     *
     * @var [type]
     */

    public $settings_api;

    /**
     * Hold metabox api class 
     * Variable
     * @var string
     */

    public $metabox_api;

    /**
     * Constructor
     */
    public function __construct($settings_api, $metabox_api)
    {
        $this->settings_api = $settings_api;
        $this->metabox_api = $metabox_api;
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
        add_submenu_page($this->slug, esc_attr__('Settings', 'eco-profile-master'), esc_attr__('Settings', 'eco-profile-master'), $capability, 'eco-profile-master-settings', [$this->settings_api, 'plugin_settings_page']);
        add_submenu_page($this->slug, esc_attr__('Admin Bar', 'eco-profile-master'), esc_attr__('Admin Bar', 'eco-profile-master'), $capability, 'eco-profile-master-admin-bar', [$this, 'admin_bar_plugin_page']);
        add_submenu_page($this->slug, esc_attr__('Email Customizer', 'eco-profile-master'), esc_attr__('Email Customizer', 'eco-profile-master'), $capability, 'fx_smb', [$this->metabox_api, 'email_customizer_plugin_page']);
        add_submenu_page($this->slug, esc_attr__('User Listing', 'eco-profile-master'), esc_attr__('User Listing', 'eco-profile-master'), $capability, 'eco-profile-master-user-listing', [$this, 'user_listings_plugin_page']);
    }

    /**
     * Plugin page callback function
     *
     * @return void
     */
    public function epm_plugin_page()
    {
        require_once EP_MASTER_TEMPLATE_PATH . '/features/general-settings/general.php ';
    }

    /**
     * Plugin Settings callback function
     */
    // public function email_customizer_plugin_page()
    // {
    //     echo "i am email customizer callback";
    // }


    public function admin_bar_plugin_page()
    {
        echo "Admin Bar cb";
    }


    public function user_listings_plugin_page()
    {
        echo "User Listing Page";
      
    }



    
}
