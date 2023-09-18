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
        //$password  = wp_hash_password($data['epm_user_password']);

        $password  = $data['epm_user_password'];

        $user_id = wp_create_user($username, $password, $email);
        //remove_filter('pre_option_users_can_register', '__return_true');
        if (is_wp_error($user_id)) {
            // Log the error for debugging purposes
            // error_log('User creation error: ' . $user_id->get_error_message());
            //wp_die(__('User registration failed. Please try again later.', 'eco-profile-master'));
            // return array('error' => 'User registration failed');

            // Return a custom error response
            //return array('error' => 'User registration failed');
            //return false;
            echo 'User creation failed: ' . $user_id->get_error_message();
        } else {
            update_user_meta($user_id, 'epm_admin_approval', __('unapproved', 'eco-profile-master'));
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => sanitize_text_field($data['epm_user_firstname']),
                'last_name' => sanitize_text_field($data['epm_user_lastname']),
                'user_url' => esc_url($data['epm_user_website']),
                'description' => sanitize_textarea_field($data['epm_user_bio']),

            ));

            // Handle image upload
            if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
                require_once ABSPATH . 'wp-admin/includes/image.php';
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/media.php';

                $uploaded_image = media_handle_upload('epm_user_avatar', 0); // 0 means no associated post
                if (is_wp_error($uploaded_image)) {
                    // Handle image upload error
                    echo 'Image upload failed: ' . $uploaded_image->get_error_message();
                } else {
                    // Resize the uploaded image to 300x300 pixels
                    $resized_image_id = image_make_intermediate_size($uploaded_image, 300, 300, true);
                    // Get the URL of the resized image
                    $resized_image_url = wp_get_attachment_image_url($resized_image_id, 'full');

                    // update_user_meta($user_id, 'epm_user_avatar', $uploaded_image);
                    // Update user's meta data with the resized image URL
                    update_user_meta($user_id, 'profile_image', $resized_image_url);
                }
            }
            echo 'User created successfully with ID: ' . $user_id;
        }

        // Handle user creation success
        $this->handle_user_creation_success($user_id, $data);
        return $user_id;
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
            wp_redirect(home_url('/custom-dashboard'));
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
