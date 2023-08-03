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
        $this->dispatch_action($epm_admin_settings);
        new Admin\Menu($epm_admin_settings);
        new Admin\Settings\Epm_Settings();
    }

    public function dispatch_action($epm_admin_settings)
    {
        add_action('admin_init', [$epm_admin_settings, 'general_settings_form_handler']);

    }
}
