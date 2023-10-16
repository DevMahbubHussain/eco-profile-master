<?php

namespace EcoProfile\Master\Admin\Settings;

/**
 * Eco Profile Master Admin Settings Wrapper Class.
 * 
 * @since 1.0.0
 */
class Epm_Settings
{
    /**
     * Plugin settings page handler.
     *
     * @return void
     */
    public function epm_plugin_settings_page()
    {
        if (isset($_GET['page']) && sanitize_text_field(wp_unslash($_GET['page'])) == 'eco-profile-master-settings') {
            $template = __DIR__ . '/views/form-settings.php';
        }
        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Form fields plugin page handler.
     *
     * @return void
     */
    public function epm_form_fields_plugin_page()
    {
        if (isset($_GET['page']) && sanitize_text_field(wp_unslash($_GET['page'])) == 'eco-profile-master-form-fields') {
            $template = __DIR__ . '/views/form-settings.php';
        }
        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * General settings form handler.
     *
     * @return void
     */
    public function epm_general_settings_form_handler()
    {
        epm_general_settings_form_submission();
    }

    /**
     * Advanced settings form handler.
     *
     * @return void
     */
    public function epm_advanced_settings_form_handler()
    {
        epm_advanced_settings_form_submission();
    }

    /**
     * Admin Bar form handler.
     *
     * @return void
     */
    public function epm_admin_bar_form_handler()
    {
        update_epm_display_admin_settings();
    }

    /**
     * Form fields handler.
     *
     * @return void
     */
    public function epm_form_fields_handler()
    {
        epm_admin_form_fields_settings();
    }
}
