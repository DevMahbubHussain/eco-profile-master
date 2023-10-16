<?php

namespace EcoProfile\Master\Traits;

trait EPM_MessageTrait
{
    protected $registration_messages = array();

    /**
     * Add a Registration Message
     *
     * Adds a message to the registration messages array.
     *
     * @param string $message The message to add.
     */

    public function add_message($message)
    {
        $this->registration_messages[] = $message;
    }

    /**
     * Get Registration Messages
     *
     * Retrieves the registration messages array.
     *
     * @return array An array of registration messages.
     */

    public function get_messages()
    {
        return $this->registration_messages;
    }

    /**
     * Display Registration Messages
     *
     * Displays registration messages as an HTML list.
     */
    
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
