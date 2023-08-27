<?php

namespace EcoProfile\Master;

/**
 * The admin class
 */
class Admin
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $epm_admin_settings = new Admin\Settings\Epm_Settings();
        $epm_form_label_placeholder = new Admin\Settings\EPM_LabelPlaceholderSettings();
        $this->dispatchAction($epm_admin_settings);
        new Admin\Menu($epm_admin_settings, $epm_form_label_placeholder);
        new Admin\Settings\EPM_Users_columns();
    }

    public function dispatchAction($epm_admin_settings)
    {
        add_action('admin_init', [$epm_admin_settings, 'epm_advanced_settings_form_handler']);
        add_action('admin_init', [$epm_admin_settings, 'epm_admin_bar_form_handler']);
        add_action('admin_init', [$epm_admin_settings, 'epm_form_fields_handler']);
       // add_action('admin_init', [$epm_admin_settings, 'epm_handle_user_actions']);
        // add_action('admin_init', [$epm_form_label_placeholder, 'epm_form_labels_placeholder_handler']);

    }
}
