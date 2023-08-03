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
        $metabox_api = new Admin\Metabox\Metabox();
        new Admin\Menu($settings_api, $metabox_api);
        new Admin\Settings\Epm_Settings(); //later need to check 
        new Admin\Metabox\Metabox(); ////later need to check 
    }
}
