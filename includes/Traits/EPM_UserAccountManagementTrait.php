<?php

namespace EcoProfile\Master\Traits;

trait EPM_UserAccountManagementTrait
{

    private function create_user($data)
    {
        // Logic to create a new user account
        $username = $data['epm_user_username'];
        $email = $data['epm_user_email'];
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
        $this->send_confirmation_email($user_id);

        // // Auto-login the user
        // $this->auto_login($user_id);

        // // Notify admin for approval
        // $this->notify_admin_for_approval($user_id);
    }

    private function send_confirmation_email($user_id)
    {
        $user = get_user_by('ID', $user_id);
        $send_confirmation = sanitize_text_field(get_option('epm_email_confirmation_activated', true));

        if (!$send_confirmation) {
            return;
        }

        $confirmation_key = wp_generate_password(20, false);
        update_user_meta($user_id, 'confirmation_key', $confirmation_key);

        $site_name = get_bloginfo('name'); // Get the site name
        $subject = __('Account Confirmation', 'eco-profile-master');

        // Build the HTML email message
        $message = '<html>';
        $message .= '<body>';
        $message .= sprintf(
            __('Hello %s,', 'eco-profile-master'), // Customize the greeting as needed
            $user->display_name
        ) . '<br><br>';
        $message .= sprintf(
            __('Click the following link to confirm your account on %s:', 'eco-profile-master'),
            $site_name
        ) . '<br><br>';
        $confirmation_link = add_query_arg('confirmation_key', $confirmation_key, home_url('/'));
        $message .= '<a href="' . esc_url($confirmation_link) . '">' . __('Confirm Account', 'eco-profile-master') . '</a><br><br>';
        $message .= __('If you did not request this, please disregard this email.', 'eco-profile-master') . '<br><br>';
        $message .= '</body>';
        $message .= '</html>';

        // Set headers for HTML email
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send the email
        wp_mail($user->user_email, $subject, $message, $headers);
    }
    
    

    private function notify_admin_for_approval($user_id)
    {
        // Logic to notify admin for approval
    }

    private function auto_login($user_id)
    {
        // Logic to auto-login the user
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

    private function notify_admin_confirmation()
    {
        // notify_admin_confirmation logic goes here
    }

    private function is_user_approved()
    {
        // logic goes here 
    }
}
