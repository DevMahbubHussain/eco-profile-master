<?php

namespace EcoProfile\Master\Admin\Settings;

/**
 * Eco Profile Master Admin Settings Wrapper Class.
 */
class Epm_Settings
{
    /**
     * General Settings Plugin Page Handler function.
     *
     * @return void
     */
    public function plugin_settings_page()
    {
        if (isset($_GET['page']) && sanitize_text_field(wp_unslash($_GET['page'])) == 'eco-profile-master-settings') {
            $template = __DIR__ . '/views/form-fields.php';
        }
        if (file_exists($template)) {
            include $template;
        }
    }

    public function general_settings_form_handler()
    {
        epm_general_settings_form_submission();
    }
}