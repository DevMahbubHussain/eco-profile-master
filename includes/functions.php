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


// function render_uploaded_image()
// {
//     // Initialize variables
//     $uploaded_image_src = '';
//     $uploaded_image_alt = '';
//     $uploaded_image_style = 'display: none;'; // Hide the image by default

//     // Check if an image has been uploaded
//     if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
//         $uploaded_image_src = esc_url(wp_get_attachment_url(media_handle_upload('epm_user_avatar', 0)));

//         // Get the uploaded image's name
//         $uploaded_image_name = sanitize_file_name($_FILES['epm_user_avatar']['name']);

//         $uploaded_image_alt = sprintf(esc_attr__('Image: %s', 'eco-profile-master'), $uploaded_image_name);
//         //$uploaded_image_style = 'display: block;'; // Show the image
//         $uploaded_image_style = 'display: block; max-width: 300px; max-height: 300px;'; // Show the image with max dimensions
//     }

//     echo '<img id="uploaded-image" src="' . $uploaded_image_src . '" alt="' . $uploaded_image_alt . '" style="' . $uploaded_image_style . '">';
// }



function render_uploaded_image()
{
    // Initialize variables
    // $uploaded_image_src = '';
    // $uploaded_image_alt = __('profile image', 'eco-profile-master');
    // $uploaded_image_style = 'display: none;'; // Hide the image by default
    // $uploaded_image_width = '300';
    // $uploaded_image_height = '300';

    $uploaded_image_src = '';
    $uploaded_image_style = 'display: none;'; // Hide the image by default

    // if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
    //     $uploaded_image_src = esc_url(wp_get_attachment_url(media_handle_upload('epm_user_avatar', 0)));

    //     // Get the uploaded image's name
    //     $uploaded_image_name = sanitize_file_name($_FILES['epm_user_avatar']['name']);

    //     $uploaded_image_alt = sprintf(esc_attr__('Image: %s', 'eco-profile-master'), $uploaded_image_name);
    //     $uploaded_image_style = 'display: block; max-width: 300px; max-height: 300px;'; // Show the image with max dimensions

    //     // Get the dimensions of the uploaded image
    //     $attachment_id = media_handle_upload('epm_user_avatar', 0);
    //     $image_metadata = wp_get_attachment_metadata($attachment_id);

    //     if ($image_metadata) {
    //         $uploaded_image_width = $image_metadata['width'];
    //         $uploaded_image_height = $image_metadata['height'];
    //     }
    // }


    // Check if an image has been uploaded
    if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
        $uploaded_image_src = esc_url(wp_get_attachment_url(media_handle_upload('epm_user_avatar', 0)));
        //$uploaded_image_alt = sprintf(esc_attr__('Image: %s', 'eco-profile-master'), $uploaded_image_name);
        $uploaded_image_style = 'display: block; max-width: 300px; max-height: 300px;'; // Show the image with max dimensions
    }

    // echo '<img id="uploaded-image" src="' . $uploaded_image_src . '" alt="' . $uploaded_image_alt . '" style="' . $uploaded_image_style . '" width="' . $uploaded_image_width . '" height="' . $uploaded_image_height . '">';
    // JavaScript for image preview

    echo '<img id="uploaded-image" src="' . $uploaded_image_src . '" style="' . $uploaded_image_style . '">';
    // echo '<img id="uploaded-image" src="' . $uploaded_image_src . '"  style="' . $uploaded_image_style . '" width="' . $uploaded_image_width . '" height="' . $uploaded_image_height . '">';
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('epm_user_avatar');
            const preview = document.getElementById('uploaded-image');

            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });
        });
    </script>
<?php
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
