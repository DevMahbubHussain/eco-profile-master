<?php

namespace EcoProfile\Master;

/**
 * Represents the admin class for managing the plugin's admin interface and settings.
 */
class Admin
{
    /**
     * Class constructor for initializing and setting up various components.
     */

    public function __construct()
    {
        // Create an instance of the Epm_Settings class
        $epm_admin_settings = new Admin\Settings\Epm_Settings();

        // Create an instance of the EPM_LabelPlaceholderSettings class
        $epm_form_label_placeholder = new Admin\Settings\EPM_LabelPlaceholderSettings();

        // Dispatch actions related to admin settings
        $this->dispatchAction($epm_admin_settings);

        // Create an instance of the Admin\Menu class with necessary dependencies
        new Admin\Menu($epm_admin_settings, $epm_form_label_placeholder);

        // Create an instance of the EPM_Users_columns class
        new Admin\Settings\EPM_Users_columns();
    }

    /**
     * Dispatches actions to handle various admin settings forms.
     *
     * @param Epm_Settings $epm_admin_settings An instance of the Epm_Settings class.
     */

    public function dispatchAction($epm_admin_settings)
    { 
        // Register callback functions to handle admin settings forms on admin_init action.
        add_action('admin_init', [$epm_admin_settings, 'epm_general_settings_form_handler']);
        add_action('admin_init', [$epm_admin_settings, 'epm_advanced_settings_form_handler']);
        add_action('admin_init', [$epm_admin_settings, 'epm_admin_bar_form_handler']);
        add_action('admin_init', [$epm_admin_settings, 'epm_form_fields_handler']);
    }
}
