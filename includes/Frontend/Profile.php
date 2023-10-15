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
        add_shortcode('epm-profile-edit', array($this, 'epm_render_profile_form'));
        add_shortcode('epm-profile', array($this, 'epm_render_profile_details_form'));
        add_action('init', array($this, 'init'));
        add_action('wp', array($this, 'epm_profile_details'));
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

    // profile details 

    public function epm_render_profile_details_form()
    {
        ob_start();
        $this->epm_render_profile_details_form_style();
        return ob_get_clean();
    }

    public function epm_render_profile_details_form_style()
    {
        if (is_user_logged_in()) {
            require_once  __DIR__ . '/views/profile/profile_details.php';
        }
    }

    public function epm_profile_details()
    {
        if (isset($_GET['action']) && $_GET['action'] === 'profile') {
            $profile_page_slug = 'profile';
            $profile_page = get_page_by_path($profile_page_slug);
            if ($profile_page && $profile_page->post_status === 'publish') {
                wp_redirect(get_permalink($profile_page));
                exit;
            } else {
                $error_message = __('Sorry, the page you are looking for is not available.', 'eco-profile-master');
                $home_link = __('Go to the homepage', 'eco-profile-master');
                $contact_admin = __('or contact the site administrator for assistance.', 'eco-profile-master');
                echo '<div class="flex flex-col items-center justify-center h-screen">';
                echo '<p class="text-2xl">' . esc_html($error_message) . '</p>';
                echo '<p class="text-lg mt-4"><a href="' . esc_url(home_url()) . '" class="text-blue-500 hover:underline">' . esc_html($home_link) . '</a></p>';
                echo '<p class="text-lg mt-4">' . esc_html($contact_admin) . '</p>';
                echo '</div>';
                exit;
            }
        }
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
            update_user_meta($user_id, 'epm_user_phone', isset($_POST['epm_user_phone']) ? sanitize_text_field($_POST['epm_user_phone']) : '');
            update_user_meta($user_id, 'epm_user_gender', isset($_POST['epm_user_gender']) ? sanitize_text_field($_POST['epm_user_gender']) : '');
            update_user_meta($user_id, 'epm_user_birthdate', isset($_POST['epm_user_birthdate']) ? sanitize_text_field($_POST['epm_user_birthdate']) : '');
            update_user_meta($user_id, 'epm_user_occupation', isset($_POST['epm_user_occupation']) ? sanitize_text_field($_POST['epm_user_occupation']) : '');
            update_user_meta($user_id, 'epm_user_house', isset($_POST['epm_user_house']) ? sanitize_text_field($_POST['epm_user_house']) : '');
            update_user_meta($user_id, 'epm_user_road', isset($_POST['epm_user_road']) ? sanitize_text_field($_POST['epm_user_road']) : '');
            update_user_meta($user_id, 'epm_user_location', isset($_POST['epm_user_location']) ? sanitize_text_field($_POST['epm_user_location']) : '');
            update_user_meta($user_id, 'epm_user_religion', isset($_POST['epm_user_religion']) ? sanitize_text_field($_POST['epm_user_religion']) : '');
            update_user_meta($user_id, 'epm_user_skin', isset($_POST['epm_user_skin_color']) ? sanitize_text_field($_POST['epm_user_skin_color']) : '');
            update_user_meta($user_id, 'epm_user_blood', isset($_POST['epm_user_blood_group']) ? sanitize_text_field($_POST['epm_user_blood_group']) : '');
            update_user_meta($user_id, 'epm_user_facebook', isset($_POST['epm_user_facebook']) ? sanitize_text_field($_POST['epm_user_facebook']) : '');
            update_user_meta($user_id, 'epm_user_twitter', isset($_POST['epm_user_twitter']) ? sanitize_text_field($_POST['epm_user_twitter']) : '');
            update_user_meta($user_id, 'epm_user_linkedin', isset($_POST['epm_user_linkedin']) ? sanitize_text_field($_POST['epm_user_linkedin']) : '');
            update_user_meta($user_id, 'epm_user_youtube', isset($_POST['epm_user_youtube']) ? sanitize_text_field($_POST['epm_user_youtube']) : '');
            update_user_meta($user_id, 'epm_user_instagram', isset($_POST['epm_user_instagram']) ? sanitize_text_field($_POST['epm_user_instagram']) : '');
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
            );
            if (isset($_POST['epm_user_password']) && !empty($_POST['epm_user_password'])) {
                $password = sanitize_text_field($_POST['epm_user_password']);
                wp_set_password($password, $user_id);
            }
            // Handle image upload
            $this->handle_image_upload_and_update_usermeta($user_id);
            $this->handle_cover_image_upload_and_update_usermeta($user_id);
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

    /**
     * Handle cover image upload and update usermeta.
     *
     * @param int $user_id The user's ID.
     * @return bool True if successful, false otherwise.
     */
    public function handle_cover_image_upload_and_update_usermeta($user_id)
    {
        // Check if an image file has been uploaded
        if (isset($_FILES['epm_user_cover_image']) && $_FILES['epm_user_cover_image']['error'] === 0) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            // Get the previous avatar URL
            $previous_avatar_url = get_user_meta($user_id, 'epm_user_cover_image', true);

            if (!empty($previous_avatar_url)) {
                // Get the attachment ID associated with the previous avatar
                $attachment_id = attachment_url_to_postid($previous_avatar_url);

                if ($attachment_id) {
                    // Delete the previous avatar from the media library
                    wp_delete_attachment($attachment_id, true);
                }
            }

            // Handle the new image upload
            $attachment_id = media_handle_upload('epm_user_cover_image', 0);

            if (!is_wp_error($attachment_id)) {
                // Get the URL of the uploaded image
                $resized_image_url = wp_get_attachment_image_url($attachment_id, 'full');

                // Update user's meta data with the resized image URL
                update_user_meta($user_id, 'epm_user_cover_image', $resized_image_url);

                return true;
            }
        }

        return false;
    }
}
