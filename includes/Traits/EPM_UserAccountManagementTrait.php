<?php

namespace EcoProfile\Master\Traits;

use EcoProfile\Master\Traits\EPM_EmailTemplatesTrait;

trait EPM_UserAccountManagementTrait
{
    use EPM_EmailTemplatesTrait;

    private function create_user($data)
    {
        // Logic to create a new user account
        $username = $data['epm_user_username'];
        $email = $data['epm_user_email'];
        $password  = $data['epm_user_password'];
        $confirmation_key = wp_generate_password(20, false);
           
        $user_id = wp_create_user($username, $password, $email);
        remove_filter(
            'pre_option_users_can_register',
            '__return_true'
        );
        if (is_wp_error($user_id)) {
            echo 'User creation failed: ' . $user_id->get_error_message();
        } else {
            $is_admin_approved = sanitize_text_field(get_option('epm_admin_approval', 'no'));
            if ($is_admin_approved === 'yes') {
                update_user_meta($user_id, 'epm_admin_approval', __('unapproved', 'eco-profile-master'));
            }
            update_user_meta($user_id, 'confirmation_key', $confirmation_key);
            update_user_meta($user_id, 'epm_user_phone', sanitize_text_field($data['epm_user_phone']));
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => sanitize_text_field($data['epm_user_firstname']),
                'last_name' => sanitize_text_field($data['epm_user_lastname']),
                'user_url' => esc_url($data['epm_user_website']),
                'description' => sanitize_textarea_field($data['epm_user_bio']),

            ));
            // Handle social media links
            $this->update_social_media_links($user_id, $data);
            // Handle image upload
            $this->upload_user_avatar('epm_user_avatar', $user_id);
            echo 'User created successfully with ID: ' . $user_id;
        }
        // Handle user creation success
        $this->handle_user_creation_success($user_id, $data);
        return $user_id;
    }

    /**
     * Uploads a user avatar and updates user meta with the image URL.
     *
     * @param string $file_input_name The name attribute of the file input field.
     * @param int $user_id The user ID to associate with the uploaded avatar.
     * @return string|WP_Error The image URL on success or a WP_Error object on failure.
     */
    function upload_user_avatar($file_input_name, $user_id)
    {
        if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] === 0) {
            // Load necessary WordPress functions
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload($file_input_name, 0);

            if (is_wp_error($attachment_id)) {
                $error_message = $attachment_id->get_error_message();
                _e('Image upload failed: ', 'eco-profile-master');
                echo $error_message;
                return $attachment_id;
            } else {
                $image_url = wp_get_attachment_url($attachment_id);
                update_user_meta($user_id, 'epm_user_avatar', $image_url);
                return $image_url;
            }
        }
    }

    /**
     * Update user meta for social media links, handling empty values.
     *
     * @param int $user_id The user ID to update user meta for.
     * @param array $data An array containing social media link data.
     */
    function update_social_media_links($user_id, $data)
    {
        // Define the social media fields and loop through them
        $social_media_fields = array(
            'epm_user_facebook',
            'epm_user_twitter',
            'epm_user_linkedin',
            'epm_user_youtube',
            'epm_user_instagram',
        );

        foreach ($social_media_fields as $field) {
            // Check if the field exists in the data and is not empty
            if (isset($data[$field]) && !empty($data[$field])) {
                // Update user meta with the sanitized URL
                update_user_meta($user_id, $field, esc_url($data[$field]));
            } else {
                // Set user meta to an empty string for empty values
                update_user_meta($user_id, $field, '');
            }
        }
    }




    public function handle_user_creation_success($user_id, $data)
    {
        // Set user role
        $this->set_user_role($user_id);

        // Send confirmation email
        // $this->send_confirmation_email($user_id);

        // // Auto-login the user
        // $this->auto_login($user_id);

        // // Notify admin for approval
        // $this->notify_admin_for_approval($user_id);
    }

    private function send_confirmation_email($user_id)
    {
        $user = get_user_by('ID', $user_id);
        $send_confirmation = sanitize_text_field(get_option('epm_email_confirmation_activated', 'no'));
        if (!$send_confirmation) {
            return;
        }
        $email_data = $this->generate_confirmation_email($user);
        // Send the email
        wp_mail($user->user_email,  $email_data['subject'], $email_data['message'], $email_data['headers']);
    }


    private function notify_admin_for_approval($user_id)
    {
        // Get the admin email address
        $admin_email = get_option('admin_email');
        $email_data = $this->admin_confirmation_email($user_id);
        wp_mail($admin_email,  $email_data['subject'], $email_data['message'], $email_data['headers']);
    }

    private function auto_login($user_id)
    {
        $user = get_userdata($user_id);
        $password = sanitize_text_field($_POST['epm_user_password']);
        $creds = array(
            'user_login'    => $user->user_login,
            'user_password' => $password,
            'remember'      => true,
        );
        $user_signin = wp_signon($creds, false);

        if (!is_wp_error($user_signin)) {
            wp_clear_auth_cookie();
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
            $epm_profile_page = sanitize_text_field(get_option('epm_profile_page', 'Profile'));
            if (!empty($epm_profile_page)) {
                wp_redirect(home_url("/$epm_profile_page"));
            }
           // wp_redirect(home_url('/custom-dashboard'));
            exit;
        }
    }

    private function set_user_role($user_id)
    {
        // Get the default role for new users
        $default_role = get_option('default_role');

        // Set the user's role to the default role
        $result = wp_update_user(array(
            'ID' => $user_id,
            'role' => $default_role,
        ));

        if (is_wp_error($result)) {
            // Log the error for debugging purposes
            error_log('Error setting user role: ' . $result->get_error_message());
        }
    }
}
