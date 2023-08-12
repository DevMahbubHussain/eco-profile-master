<?php

namespace EcoProfile\Master\Traits;

/**
 * Trait EPM_CapitalizeNamesTrait
 * 
 * Provides methods to determine whether to Always capitalize name fields.
 * 
 * @package EcoProfileMaster
 */
trait EPM_CapitalizeNamesTrait
{
    protected function  epm_capitalize_and_store_names($first_name, $last_name)
    {
        $capitalize_names = get_option('epm_first_lastname_captitilize', '0');
        $capitalize_names = sanitize_text_field($capitalize_names);

        $capitalized_first_name = $capitalize_names === '1' ? ucfirst($first_name) : $first_name;
        $capitalized_last_name = $capitalize_names === '1' ? ucfirst($last_name) : $last_name;

        return array($capitalized_first_name, $capitalized_last_name);
    }
}
