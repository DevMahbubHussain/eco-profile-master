<?php

namespace EcoProfile\Master;

/**
 * Frontend handler class
 */
class Frontend
{
    /**
     * Frontend constructor.
     */
    public function __construct()
    {
        $epm_signup = new Frontend\Signup();
        $this->epm_dispatch_action($epm_signup);
        new Frontend\Login();
        new Frontend\Profile();
        new Frontend\Users();
    }

    /**
     * Dispatch the action for form submission handling.
     *
     * @param Frontend\Signup $epm_signup The signup component.
     */
    public function epm_dispatch_action($epm_signup)
    {
        add_action('init', [$epm_signup, 'epm_handle_form_submission']);
    }
}
