<?php

namespace EcoProfile\Master\Traits;
/**
 * Trait EPM_AutoGeneratePasswordTrait
 *
 * Provides methods to determine whether to auto-generate passwords.
 *
 * @package EcoProfileMaster
 */
trait EPM_AutoGeneratePasswordTrait
{
    /**
     * Checks if auto-generation of passwords should be enabled.
     *
     * @return bool Whether auto-generation of passwords should be enabled.
     */
    protected function epm_should_generate_password()
    {
        $auto_generate_password = get_option('epm_auto_generate_pass', '0');
        //var_dump($auto_generate_password);
        return $auto_generate_password !== '1';
    }
}
