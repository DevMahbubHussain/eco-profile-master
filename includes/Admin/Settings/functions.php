<?php

/**
 * Eco Profile Master All functions
 *
 * @package eco-profile-master-functions
 */

/**
 * Admin general settings function. 
 *
 * Process and save the form fields settings submitted by the user.
 *
 * This function is triggered when the form is submitted. It verifies the nonce,
 * checks user capabilities, sanitizes input, and updates the plugin options.
 * After processing, it redirects the user back to the referring page with a success message.
 *
 * @since 1.0.0
 */
function epm_general_settings_form_submission()
{
    if (isset($_POST['updated']) && $_POST['updated'] === 'true') {

        if (!isset($_POST['epm_general_settings'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['general_settings_nonce'], 'general_settings_nonce') || !current_user_can('manage_options')) {
            wp_die(__('Security check failed.', 'eco-profile-master'));
        }
        // Define an array with the option names and their corresponding POST keys
        $options = array(
            'epm_form_style' => 'epm_form_style',
            'epm_automatically_login' => 'epm_automatically_login',
            'epm_email_confirmation_activated' => 'epm_email_confirmation_activated',
            'epm_admin_approval' => 'epm_admin_approval',
            'epm_show_logout' => 'epm_show_logout',
            'epm_display_email' => 'epm_display_email',
            'epm_display_phone_number' => 'epm_display_phone_number',
            'epm_image' => 'epm_image',
            'epm_cimage' => 'epm_cimage',
            'epm_mailing_address' => 'epm_mailing_address',
            'epm_display_social_links' => 'epm_display_social_links',
            'epm_lost_password_page' => 'epm_lost_password_page',
            'epm_login_page' => 'epm_login_page',
            'epm_profile_page' => 'epm_profile_page',
            'epm_pass_reset_page' => 'epm_pass_reset_page'
        );
        // Loop through the options, sanitize the values, and update the options
        foreach ($options as $option_name => $post_key) {
            $option_value = isset($_POST[$post_key]) ? sanitize_text_field($_POST[$post_key]) : '';
            update_option($option_name, $option_value);
        }
        wp_safe_redirect(add_query_arg('epm_action_result', 'success', wp_get_referer()));
        exit();
    }
}

/**
 * Admin advanved settings function. 
 *
 * Process and save the form fields settings submitted by the user.
 *
 * This function is triggered when the form is submitted. It verifies the nonce,
 * checks user capabilities, sanitizes input, and updates the plugin options.
 * After processing, it redirects the user back to the referring page with a success message.
 *
 * @since 1.0.0
 */
function epm_advanced_settings_form_submission()
{
    if (isset($_POST['updated']) && $_POST['updated'] === 'true') {

        if (!isset($_POST['epm_advanced_settings'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['advanced_settings_nonce'], 'advanced_settings_nonce') || !current_user_can('manage_options')) {
            wp_die(__('Security check failed.', 'eco-profile-master'));
        }

        // Define an array with the checkbox names
        $checkboxes = array(
            'epm_email_confirmation',
            'epm_remember_me',
            'epm_send_credentials',
            'epm_first_lastname_captitilize',
            'epm_user_gender',
            'epm_user_birthdate',
            'epm_user_occupation',
            'epm_user_religion',
            'epm_user_skin_color',
            'epm_user_blood_group',
            'epm_facebook_url',
            'epm_twitter_url',
            'epm_linkedin_url',
            'epm_youtube_url',
            'epm_instagram_url'
        );

        // Loop through the checkboxes and update the options
        foreach ($checkboxes as $checkbox) {
            ${$checkbox} = isset($_POST[$checkbox]) ? (int) $_POST[$checkbox] : 0;
            update_option($checkbox, ${$checkbox});
        }
        wp_safe_redirect(add_query_arg('epm_action_result', 'success', wp_get_referer()));
        exit();
    }
}

/**
 * Admin bar settings function. 
 * 
 * Process and save the form fields settings submitted by the user.
 *
 * This function is triggered when the form is submitted. It verifies the nonce,
 * checks user capabilities, sanitizes input, and updates the plugin options.
 * After processing, it redirects the user back to the referring page with a success message.
 *
 * @since 1.0.0
 */
function update_epm_display_admin_settings()
{
    if (!isset($_POST['epm_admin_bar'])) {
        return;
    }
    if (!isset($_POST['update_epm_display_admin_settings_nonce']) || !wp_verify_nonce($_POST['update_epm_display_admin_settings_nonce'], 'update_epm_display_admin_settings_nonce')) {
        wp_die(__('Security check failed.', 'eco-profile-master'));
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('Security check failed.', 'eco-profile-master'));
    }

    if (isset($_POST['epm_display_admin_settings'])) {
        $admin_settings = $_POST['epm_display_admin_settings'];
        // Sanitize and validate the data 
        $allowed_values = array('default', 'show', 'hide');

        foreach ($admin_settings as $role => $visibility) {
            if (!in_array($visibility, $allowed_values)) {
                // Invalid value, set to 'default' as fallback
                $admin_settings[$role] = 'default';
            }
        }
        $admin_settings = array_map('sanitize_text_field', $admin_settings);
        update_option('epm_display_admin_settings', $admin_settings);
    }
    wp_safe_redirect(add_query_arg('epm_action_result', 'success', wp_get_referer()));
    exit();
}

/**
 * Process and save the form fields settings submitted by the user.
 *
 * This function is triggered when the form is submitted. It verifies the nonce,
 * checks user capabilities, sanitizes input, and updates the plugin options.
 * After processing, it redirects the user back to the referring page with a success message.
 *
 * @return void
 * @since 1.0.0
 */
function epm_admin_form_fields_settings()
{
    if (!isset($_POST['epm_form_settings'])) {
        return;
    }
    if (!isset($_POST['form_fields_settings_nonce']) || !wp_verify_nonce($_POST['form_fields_settings_nonce'], 'form_fields_settings_nonce')) {
        wp_die(__('Security check failed.', 'eco-profile-master'));
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('Not allowed.', 'eco-profile-master'));
    }

    $sections = array(
        'name' => 'epm_form_heading_name',
        'contact_info' => 'epm_form_heading_contact_info',
        'about_yourself' => 'epm_form_heading_about_yourself',
        'profile_image' => 'epm_form_heading_profile_image',
        'cover_image' => 'epm_form_heading_cover_image',
        'social_links' => 'epm_form_heading_social_links',
        'mailing_address' => 'epm_form_heading_ mailing_address'
    );

    foreach ($sections as $section => $option_name) {
        $section_value = isset($_POST[$option_name]) ? sanitize_text_field($_POST[$option_name]) : '';
        $hide_option_name = $option_name . '_hide';
        $hide_value = isset($_POST[$hide_option_name]) && $_POST[$hide_option_name] === '1' ? '1' : '0';

        update_option($option_name, $section_value);
        update_option($hide_option_name, $hide_value);
    }

    wp_safe_redirect(add_query_arg('epm_action_result', 'success', wp_get_referer()));
    exit();
}

/**
 * Display admin notice based on the epm_action_result query parameter.
 *
 * This function is hooked into the admin_notices action and checks the value of
 * the epm_action_result query parameter. If the value is 'success', a success message
 * is displayed. If the value is 'error', an error message is displayed.
 *
 * @since 1.0.0
 */
function display_admin_notice()
{
    // Check for the custom query parameter
    $action_result = isset($_GET['epm_action_result']) ? $_GET['epm_action_result'] : '';

    if ($action_result === 'success') {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Settings saved successfully!', 'echo-profile-master') . '</p></div>';
    } elseif ($action_result === 'error') {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Failed to save settings. Please try again.', 'echo-profile-master') . '</p></div>';
    }
}
add_action('admin_notices', 'display_admin_notice');

/**
 * Get the selected lost password page option for the general settings.
 *
 * Retrieves the lost password page option from the plugin settings and generates
 * a list of options with the currently selected page marked as 'selected'.
 *
 * @since 1.0.0
 */
function epm_lost_password_page()
{
    $epm_pages = epm_get_my_pages();

    foreach ($epm_pages as $page) :
        $selected = (get_option('epm_lost_password_page') === $page) ? 'selected' : '';
?>
        <option value="<?php echo esc_attr($page); ?>" <?php echo $selected; ?>>
            <?php echo esc_html(ucfirst($page)); ?>
        </option>
    <?php
    endforeach;
}

function epm_login_page()
{
    $epm_pages = epm_get_my_pages();

    foreach ($epm_pages as $page) :
        $selected = (get_option('epm_login_page') === $page) ? 'selected' : '';
    ?>
        <option value="<?php echo esc_attr($page); ?>" <?php echo $selected; ?>>
            <?php echo esc_html(ucfirst($page)); ?>
        </option>
    <?php
    endforeach;
}

function epm_profile_page()
{
    $epm_pages = epm_get_my_pages();

    foreach ($epm_pages as $page) :
        $selected = (get_option('epm_profile_page') === $page) ? 'selected' : '';
    ?>
        <option value="<?php echo esc_attr($page); ?>" <?php echo $selected; ?>>
            <?php echo esc_html(ucfirst($page)); ?>
        </option>
    <?php
    endforeach;
}

function epm_password_reset_form()
{
    $epm_pages = epm_get_my_pages();

    foreach ($epm_pages as $page) :
        $selected = (get_option('epm_pass_reset_page') === $page) ? 'selected' : '';
    ?>
        <option value="<?php echo esc_attr($page); ?>" <?php echo $selected; ?>>
            <?php echo esc_html(ucfirst($page)); ?>
        </option>
    <?php
    endforeach;
}

/**
 * Admin notice after user approved.
 *
 * Display a success notice when a user is approved.
 *
 * @since 1.0.0
 */
function epm_approval_success_notice()
{
    // Check if the approval was successful
    if (isset($_GET['approved']) && $_GET['approved'] === '1') {
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('The account has been approved, and the email has been sent to the user.', 'eco-profile-master'); ?></p>
        </div>
    <?php
    }
}
add_action('admin_notices', 'epm_approval_success_notice');

/**
 * Admin notice after user unapproved.
 *
 * Display a success notice when a user is unapproved.
 *
 * @since 1.0.0
 */
function epm_unapproved_success_notice()
{
    // Check if the unapproval was successful
    if (isset($_GET['unapproved']) && $_GET['unapproved'] === '1') {
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('The account has been unapproved successfully.', 'eco-profile-master'); ?></p>
        </div>
    <?php
    }
}
add_action('admin_notices', 'epm_unapproved_success_notice');

/**
 * Admin notice after user rejection.
 *
 * Display a success notice when a user is rejected.
 *
 * @since 1.0.0
 */
function epm_reject_success_notice()
{
    // Check if the rejection was successful
    if (isset($_GET['rejected']) && $_GET['rejected'] === '1') {
    ?>
        <div class="notice notice-success is-dismissible">
            <p><?php _e('The account has been rejected successfully.', 'eco-profile-master'); ?></p>
        </div>
<?php
    }
}
add_action('admin_notices', 'epm_reject_success_notice');
