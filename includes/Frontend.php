<?php

namespace EcoProfile\Master;

/**
 * Frontend handler class
 */

class Frontend
{
    public function __construct()
    {
        $epm_signup = new Frontend\Signup();
        $this->epm_dispatch_action($epm_signup);
       // new Frontend\Signup();
        new Frontend\Shortcode();
        new Frontend\Login();
    }

    public function epm_dispatch_action($epm_signup)
    {
        add_action('init', [$epm_signup, 'epm_handle_form_submission']);
    }


}
