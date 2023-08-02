<?php

namespace EcoProfile\Master;

/**
 * The admin class
 */
class Admin
{

    public function __construct()
    {
        $settings_api = new Admin\Settings\Epm_Settings_Fields();
        new Admin\Menu($settings_api);
        new Admin\Settings\Epm_Settings(); //later need to check 
    }
}
