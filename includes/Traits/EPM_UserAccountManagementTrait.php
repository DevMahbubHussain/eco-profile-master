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
            update_user_meta($user_id, 'epm_user_phone', isset($data['epm_user_phone']) ? sanitize_text_field($data['epm_user_phone']) : '');
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => sanitize_text_field($data['epm_user_firstname']),
                'last_name' => sanitize_text_field($data['epm_user_lastname']),
                'user_url' => esc_url($data['epm_user_website']),
                'description' => sanitize_textarea_field($data['epm_user_bio']),

            ));
            // Handle the advanced field
            update_user_meta($user_id, 'epm_user_birthdate', isset($data['epm_user_birthdate']) ? sanitize_text_field($data['epm_user_birthdate']) : '');
            $labelsPlaceholders = $this->epm_label_placeholder();
            $advanced_fields = [
                'epm_user_gender',
                'epm_user_occupation',
                'epm_user_religion',
                'epm_user_skin_color',
                'epm_user_blood_group',
            ];
            foreach ($advanced_fields as $field) {
                if (isset($data[$field])) {
                    $this->handle_epm_user_advanced_field($user_id, $field, $data[$field], $labelsPlaceholders);
                }
            }
            // mailing address 
            $mailing_fields = [
                'epm_user_house',
                'epm_user_road',
                'epm_user_location',
            ];
            foreach ($mailing_fields as $field) {
                if (isset($data[$field])) {
                    $this->handle_epm_user_mailing_field($user_id, $field, $data[$field], $labelsPlaceholders);
                }
            }
            // Handle social media links
            $this->update_social_media_links($user_id, $data);
            // Handle image upload
            $this->upload_user_avatar('epm_user_avatar', $user_id);
            $this->upload_user_cover_image('epm_user_cover_image', $user_id);
        }
        // Handle user creation success
        $this->handle_user_creation_success($user_id, $data);
        return $user_id;
    }

    /**
     * Handle saving user meta data for various fields.
     *
     * @param int    $user_id       The user ID.
     * @param string $field_name    The name of the field (e.g., 'epm_user_occupation').
     * @param string $data_value    The value of the field from the form data.
     * @param array  $labels_placeholders An array of labels and placeholders for the field.
     */
    public function handle_epm_user_advanced_field($user_id, $field_name, $data_value, $labels_placeholders)
    {
        $sanitized_value = isset($data_value) ? sanitize_text_field($data_value) : '';

        // Retrieve the placeholder value for the specific field
        $field_placeholder = isset($labels_placeholders[$field_name]['placeholder']) ? $labels_placeholders[$field_name]['placeholder'] : '';

        if ($sanitized_value === $field_placeholder) {
            $saved_value = ''; // Store an empty value if it matches the placeholder
        } else {
            $saved_value = $sanitized_value;
        }
        $field_name_with_prefix = 'epm_user_' . $field_name;

        update_user_meta($user_id, $field_name_with_prefix, $saved_value);
    }

    //  mailing address
    public function handle_epm_user_mailing_field($user_id, $field_name, $data_value, $labels_placeholders)
    {
        // Check if the field exists in the data and is not empty
        if (isset($data_value) && !empty($data_value)) {
            // Sanitize the data value
            $sanitized_value = sanitize_text_field($data_value);
        } else {
            $sanitized_value = ''; // Set an empty value for empty or undefined data
        }

        // Retrieve the placeholder value for the specific field
        $field_placeholder = isset($labels_placeholders[$field_name]['placeholder']) ? $labels_placeholders[$field_name]['placeholder'] : '';

        // Check if the sanitized value matches the placeholder
        if ($sanitized_value === $field_placeholder) {
            $saved_value = ''; // Store an empty value if it matches the placeholder
        } else {
            $saved_value = $sanitized_value;
        }
        update_user_meta($user_id, $field_name, $saved_value);
    }
    
    /**
     * Uploads a user avatar and updates user meta with the image URL.
     *
     * @param string $file_input_name The name attribute of the file input field.
     * @param int $user_id The user ID to associate with the uploaded avatar.
     * @return string|WP_Error The image URL on success or a WP_Error object on failure.
     */
    public function upload_user_avatar($file_input_name, $user_id)
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
     * Uploads a user avatar and updates user meta with the image URL.
     *
     * @param string $file_input_name The name attribute of the file input field.
     * @param int $user_id The user ID to associate with the uploaded avatar.
     * @return string|WP_Error The image URL on success or a WP_Error object on failure.
     */
    public function upload_user_cover_image($file_input_name, $user_id)
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
                update_user_meta($user_id, 'epm_user_cover_image', $image_url);
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
    public function update_social_media_links($user_id, $data)
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
            $error_message = __('Error setting user role: ', 'text-domain') . $result->get_error_message();
            echo esc_html($error_message);
        }
    }
}
