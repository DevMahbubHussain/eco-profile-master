<?php

/**
 * Get all the pages
 *
 * @return array page names with key value pairs
 */
function epm_get_my_pages()
{
    $pages = get_pages();
    $pages_options = array();
    if ($pages) {
        foreach ($pages as $page) {
            $pages_options[$page->ID] = $page->post_title;
        }
    }

    return $pages_options;
}


function epm_merge_options_with_defaults()
{
    $default_options = array(
        'form_style' => 'style1',
        'automatically_login' => 'no',
        'email_confirmation_activated' => 'no',
        'admin_approval' => 'no',
        'loginwith' => 'usernameemail',
        'display_email' => 'yes',
        'display_phone_number' => 'no',
        'image' => 'yes',
        'display_social_links' => 'no',
        //'lost_password_page' => 0, // Default page ID for "Select Recover Password Page"
    );

    $saved_options = get_option('epm_general_settings', array());

    return wp_parse_args($saved_options, $default_options);
}


/**
 * Signup form submission handler 
 */

function epm_activate_user_signup()
{
    // form submission code goes here 


}
