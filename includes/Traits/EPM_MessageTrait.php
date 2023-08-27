<?php

namespace EcoProfile\Master\Traits;

trait EPM_MessageTrait
{

    // private function set_error_message($message)
    // {
    //     set_transient('epm_registration_error_message', $message, 30); // Store the message for 30 seconds
    // }

    // private function set_success_message($message)
    // {
    //     set_transient('epm_registration_success_message', $message, 30);
    // }

    // private function get_error_message()
    // {
    //     return get_transient('epm_registration_error_message');
    // }

    // private function get_success_message()
    // {
    //     return get_transient('epm_registration_success_message');
    // }


    protected $registration_messages = array();

    public function add_message($message)
    {
        $this->registration_messages[] = $message;
    }

    public function get_messages()
    {
        return $this->registration_messages;
    }

    public function display_messages()
    {
        // Display messages as HTML list
        if (!empty($this->registration_messages)) {
            echo '<ul class="registration-messages">';
            foreach ($this->registration_messages as $message) {
                echo '<li>' . esc_html($message) . '</li>';
            }
            echo '</ul>';
        }
    }
}
