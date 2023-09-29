<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Labels_PlaceholdersTrait;
use EcoProfile\Master\Traits\EPM_Signup_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Social_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;

class Profile
{
    use EPM_Signup_FieldsTrait;
    use EPM_Labels_PlaceholdersTrait;
    use EPM_Social_FieldsTrait;
    use EPM_Form_ValidationTrait;

    public function __construct()
    {
        add_shortcode('epm-profile', array($this, 'epm_render_profile_form'));
        add_action('init', array($this, 'init'));
    }


    public function epm_render_profile_form()
    {
        ob_start();
        $this->epm_render_profile_form_style();
        return ob_get_clean();
    }

    public function epm_render_profile_form_style()
    {
        $current_user = wp_get_current_user();
        require_once  __DIR__ . '/views/profile/profile_form.php';
    }

    public function init()
    {
        if (is_user_logged_in()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_profile'])) {
                $this->epm_render_profile_edit_form();
            }
        }
    }

    public function epm_render_profile_edit_form()
    {
        $user_id = get_current_user_id();
        $current_user = wp_get_current_user();
        // Verify nonce field value
        $this->validateNonce('epm_user_profile_nonce', 'epm_user_profile_action');
        // Perform custom validation
        $validation_data = $_POST;
        $validation_result = $this->epm_validate_registration_fields($validation_data);
        if (empty($validation_result)) {
            $updated_data = array(
                'ID'         => $user_id, // Specify the user ID
                'user_login'     => isset($_POST['epm_user_username']) ? sanitize_user($_POST['epm_user_username']) : '',
                'user_email'     => isset($_POST['epm_user_email']) ? sanitize_email($_POST['epm_user_email']) : '',
                'first_name'     => isset($_POST['epm_user_firstname']) ? sanitize_text_field($_POST['epm_user_firstname']) : '',
                'last_name'      => isset($_POST['epm_user_lastname']) ? sanitize_text_field($_POST['epm_user_lastname']) : '',
                'nickname'       => isset($_POST['epm_user_nickname']) ? sanitize_text_field($_POST['epm_user_nickname']) : '',
                'display_name'       => isset($_POST['epm_user_display_name']) ? sanitize_text_field($_POST['epm_user_display_name']) : '',
                'user_url'       => isset($_POST['epm_user_website']) ? esc_url_raw($_POST['epm_user_website']) : '',
                'description'    => isset($_POST['epm_user_bio']) ? sanitize_textarea_field($_POST['epm_user_bio']) : '',
                'epm_user_phone' => isset($_POST['epm_user_phone']) ? sanitize_text_field($_POST['epm_user_phone']) : '',
                // social links
                'epm_user_facebook' => isset($_POST['epm_user_facebook']) ? esc_url($_POST['epm_user_facebook']) : '',
                'epm_user_twitter'  => isset($_POST['epm_user_twitter']) ? esc_url($_POST['epm_user_twitter']) : '',
                'epm_user_linkedin' => isset($_POST['epm_user_linkedin']) ? esc_url($_POST['epm_user_linkedin']) : '',
                'epm_user_youtube'  => isset($_POST['epm_user_youtube']) ? esc_url($_POST['epm_user_youtube']) : '',
                'epm_user_instagram' => isset($_POST['epm_user_instagram']) ? esc_url($_POST['epm_user_instagram']) : '',
            );
            // Handle image upload
            $this->handle_image_upload_and_update_usermeta($user_id);
            // Update the user's data
            $result =  wp_update_user($updated_data);
            if ($result) {
                $profile_confirmation_message = __('Profile Updated Successfully.', 'eco-profile-master');
            } else {
                $profile_confirmation_message = __('Failed to Update Profile. Please try again later.', 'eco-profile-master');
            }
        } else {
            $profile_confirmation_message = __('Validation Errors.', 'eco-profile-master');
        }

        $profile_confirmation_message =  set_transient('profile_update_message', $profile_confirmation_message, 1);
        return $profile_confirmation_message;
    }

    /**
     * Handle image upload and update usermeta.
     *
     * @param int $user_id The user's ID.
     * @return bool True if successful, false otherwise.
     */
    public function handle_image_upload_and_update_usermeta($user_id)
    {
        // Check if an image file has been uploaded
        if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            // Get the previous avatar URL
            $previous_avatar_url = get_user_meta($user_id, 'epm_user_avatar', true);

            if (!empty($previous_avatar_url)) {
                // Get the attachment ID associated with the previous avatar
                $attachment_id = attachment_url_to_postid($previous_avatar_url);

                if ($attachment_id) {
                    // Delete the previous avatar from the media library
                    wp_delete_attachment($attachment_id, true);
                }
            }

            // Handle the new image upload
            $attachment_id = media_handle_upload('epm_user_avatar', 0);

            if (!is_wp_error($attachment_id)) {
                // Get the URL of the uploaded image
                $resized_image_url = wp_get_attachment_image_url($attachment_id, 'full');

                // Update user's meta data with the resized image URL
                update_user_meta($user_id, 'epm_user_avatar', $resized_image_url);

                return true;
            }
        }

        return false;
    }
}
