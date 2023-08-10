<?php

namespace EcoProfile\Master\Traits;

trait EPM_AutoGeneratePasswordTrait
{
    protected function epm_should_generate_password()
    {
        $auto_generate_password = get_option('epm_auto_generate_pass', '0');
        //var_dump($auto_generate_password);
        return $auto_generate_password !== '1';
    }
}
