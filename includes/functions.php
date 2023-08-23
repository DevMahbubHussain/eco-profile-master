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


// function epm_merge_options_with_defaults()
// {
//     $default_options = array(
//         'form_style' => 'style1',
//         'automatically_login' => 'no',
//         'email_confirmation_activated' => 'no',
//         'admin_approval' => 'no',
//         'loginwith' => 'usernameemail',
//         'display_email' => 'yes',
//         'display_phone_number' => 'no',
//         'image' => 'yes',
//         'display_social_links' => 'no',
//         //'lost_password_page' => 0, // Default page ID for "Select Recover Password Page"
//     );

//     $saved_options = get_option('epm_general_settings', array());

//     return wp_parse_args($saved_options, $default_options);
// }


/**
 * Signup form submission handler 
 */

function epm_activate_user_signup()
{
    // form submission code goes here 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_register'])) {

        // Verify hidden field value
        if ($_POST['user_registration'] !== 'user_registration') {
            wp_die(__('Security check failed. Please try again hidden.', 'eco-profile-master'));
        }


        // Verify nonce
        // if (!isset($_POST['user_registration_nonce']) || !wp_verify_nonce($_POST['user_registration_nonce'], 'user_registration_nonce')) {
        //     wp_die(__('Security check failed. Please try again nonce.', 'eco-profile-master'));
        // }

        //$this->validateNonce();

        // Verify user capability
        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized access. Please contact the site administrator.', 'eco-profile-master'));
        }

        print_r($_POST);
        exit();
    }


}
