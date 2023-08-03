<?php

/**
 * All functions
 *
 * @package eco-profile-master-functions
 */



function user_listing($name, $lastname, $vechile, $dropdown)
{
    update_option('awesome_firstname', $name);
    update_option('awesome_lastname', $lastname);
    update_option('vehicle2', $vechile);
    update_option('sandbox_dropdown', $dropdown);
?>
    <div class="updated">
        <p>Your fields were saved!</p>
    </div>
<?php
}



/**
 * Settings API utility functions
 */


/**
 * Get the value of a settings field
 *
 * @param [type] $option
 * @param [type] $section
 * @param string $default
 * @return void
 */
function get_options_data($option, $section, $default = '')
{

    $options = get_option($section);

    if (isset($options[$option])) {
        return $options[$option];
    }

    return $default;
}
