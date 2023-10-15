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

/**
 * Profile iamge function.
 *
 * @return void
 */
function render_uploaded_image()
{
    $uploaded_image_src = '';
    $uploaded_image_style = 'display: none;';
    $image_width = '';
    $image_height = '';

    // Check if an image has been uploaded
    if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
        // Load WordPress core functions
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Handle the image upload
        $attachment_id = media_handle_upload('epm_user_avatar', 0);

        if (!is_wp_error($attachment_id)) {
            // Get the image URL
            $uploaded_image_src = wp_get_attachment_url($attachment_id);
            $image_width = 300;
            $image_height = 300;

            // Show the image with specified dimensions
            $uploaded_image_style = 'display: block; max-width: ' . $image_width . 'px; max-height: ' . $image_height . 'px;';
        }
    }

    echo '<img id="uploaded-image" src="' . $uploaded_image_src . '" style="' . $uploaded_image_style . '" width="' . $image_width . '" height="' . $image_height . '">';
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

/**
 * Cover Image function.
 *
 * @return void
 */
function render_cover_image()
{
    $uploaded_image_src = '';
    $uploaded_image_style = 'display: none;';
    $image_width = '';
    $image_height = '';

    // Check if an image has been uploaded
    if (isset($_FILES['epm_user_cover_image']) && $_FILES['epm_user_cover_image']['error'] === 0) {
        // Load WordPress core functions
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // Handle the image upload
        $attachment_id = media_handle_upload('epm_user_cover_image', 0);

        if (!is_wp_error($attachment_id)) {
            // Get the image URL
            $uploaded_image_src = wp_get_attachment_url($attachment_id);
            $image_width = 300;
            $image_height = 300;

            // Show the image with specified dimensions
            $uploaded_image_style = 'display: block; max-width: ' . $image_width . 'px; max-height: ' . $image_height . 'px;';
        }
    }

    echo '<img id="uploaded-cimage" src="' . $uploaded_image_src . '" style="' . $uploaded_image_style . '" width="' . $image_width . '" height="' . $image_height . '">';
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('epm_user_cover_image');
            const preview = document.getElementById('uploaded-cimage');

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
        // Verify user capability
        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized access. Please contact the site administrator.', 'eco-profile-master'));
        }

        print_r($_POST);
        exit();
    }
}

/**
 * Filter to hide or show the admin bar based on plugin settings for all user roles.
 *
 * This function retrieves the admin bar settings from the plugin's admin panel and applies
 * the configured settings to determine whether the admin bar should be displayed or hidden
 * for all user roles defined in the WordPress installation.
 *
 * @param bool $show Whether to show or hide the admin bar.
 *
 * @return bool Modified value indicating whether to show or hide the admin bar.
 */

function hide_admin_bar_for_all_roles($show)
{
    $admin_bar_settings = get_option('epm_display_admin_settings');
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;

    foreach ($user_roles as $role) {
        // Check if there is a setting for the current role, or use a default value
        $role_setting = isset($admin_bar_settings[$role]) ? $admin_bar_settings[$role] : 'default';

        // Apply the setting for each role
        if ($role_setting === 'hide') {
            // Hide the admin bar for this role
            return false;
        } elseif ($role_setting === 'show') {
            // Show the admin bar for this role
            return $show;
        }
    }

    // Handle the case of an undefined setting (e.g., show admin bar by default)
    return $show;
}

add_filter('show_admin_bar', 'hide_admin_bar_for_all_roles');


// displayConfirmationMessages message
function displayConfirmationMessages()
{
    $confirmation_messages = get_transient('confirmation_messages');

    if ($confirmation_messages && is_array($confirmation_messages)) {
        foreach ($confirmation_messages as $message) {
    ?>
            <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ml-3 text-lg font-medium">
                    <?php echo esc_html($message); ?>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                    <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        <?php
        }

        // Clear the confirmation messages from the transient
        delete_transient('confirmation_messages');
    }
}


// password reset Message
function display_confirmation_message()
{
    $confirmation_messages = get_transient('password_reset_confirmation_messages');

    if (!empty($confirmation_messages)) {
        ?>
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-lg font-medium">
                <?php echo esc_html($confirmation_messages); ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    <?php
    }
    delete_transient('password_reset_confirmation_messages');
}


// password reset successfully
function display_password_reset_confirmation_message()
{
    $confirmation_messages = get_transient('password_reset_success_messages');

    if (!empty($confirmation_messages)) {
    ?>
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-lg font-medium">
                <?php echo esc_html($confirmation_messages); ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    <?php

    }
    delete_transient('password_reset_success_messages');
}


function display_error_token_message()
{
    $confirmation_messages = get_transient('expired_token');

    if (!empty($confirmation_messages)) {
    ?>
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-lg font-medium">
                <?php echo esc_html($confirmation_messages); ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    <?php

    }
    delete_transient('expired_token');
}

/**
 * Redirect the user to a custom login page or the WordPress default login page.
 */
function custom_login_redirect()
{
    $epm_login_page = sanitize_text_field(get_option('epm_login_page', 'Login'));

    if (!empty($epm_login_page)) {
        // Redirect to the custom login page
        wp_redirect(home_url("/$epm_login_page"));
    } else {
        // Redirect to the WordPress default login page
        wp_redirect(wp_login_url());
    }

    exit;
}

/**
 * Generate the confirmation message with a login link.
 *
 * @param string $confirmation_message The base confirmation message.
 * @param string $login_page The slug of the login page.
 * @return string The formatted confirmation message.
 */
function generate_confirmation_message($confirmation_message, $login_page)
{
    $login_link = '';

    if (!empty($login_page)) {
        $login_link = sprintf(
            __('log in', 'eco-profile-master'),
            esc_url(home_url("/$login_page"))
        );
    }

    if (!empty($login_link)) {
        $confirmation_message .= ' ' . sprintf(
            __('You can now <a href="%s">log in</a>.', 'eco-profile-master'),
            esc_url(home_url("/$login_page"))
        );
    }

    return $confirmation_message;
}



/**
 * Redirect to a custom page when the specified action hook is triggered.
 */
function custom_redirect_action_hook()
{
    if (isset($_GET['action'])) {
        $action = sanitize_text_field($_GET['action']);
        if ($action === 'lost_password') {
            custom_lost_password_page();
        }
    }
}
add_action('template_redirect', 'custom_redirect_action_hook');


function custom_lost_password_page()
{
    $epm_lost_password_page = sanitize_text_field(get_option('epm_lost_password_page', 'Recover-Password'));
    if (!empty($epm_lost_password_page)) {
        // Redirect to the custom login page
        wp_redirect(home_url("/$epm_lost_password_page"));
    }
    exit; // Add exit to prevent further code execution
}


// signup
function custom_redirect_signup_hook()
{
    if (isset($_GET['action'])) {
        $action = sanitize_text_field($_GET['action']);
        if ($action === 'sign_up') {
            wp_redirect(home_url('/register'));
            exit;
        }
    }
}
add_action('template_redirect', 'custom_redirect_signup_hook');



// signin
function custom_redirect_login_hook()
{
    if (isset($_GET['action'])) {
        $action = sanitize_text_field($_GET['action']);
        if ($action === 'login_page') {
            custom_login_redirect();
        }
    }
}
add_action('template_redirect', 'custom_redirect_login_hook');




function custom_redirect_login_hook_after_logout()
{
    if (isset($_GET['action'])) {
        $action = sanitize_text_field($_GET['action']);
        if ($action === 'logout') {
            custom_login_redirect();
        }
    }
}
add_action('template_redirect', 'custom_redirect_login_hook_after_logout');

function display_current_user_image()
{
    // Get the current user's image URL from user meta
    $user_id = get_current_user_id();
    $current_image_url = get_user_meta($user_id, 'epm_user_avatar', true);

    if ($current_image_url) {
        // Extract the file name from the URL
        $file_name = basename($current_image_url);

        // Define the desired width and height for the thumbnail
        $thumbnail_width = 300; // Change this to your desired width
        $thumbnail_height = 300; // Change this to your desired height

        // Display the image as a thumbnail with the specified width and height, and set the file name as alt text
        echo '<img id="current-image" src="' . esc_url($current_image_url) . '" alt="' . esc_attr($file_name) . '" width="' . $thumbnail_width . '" height="' . $thumbnail_height . '">';
    } else {
        // Display a default image or a translated message if no image is available
        echo esc_html__('No profile image available', 'eco-profile-master');
    }
}

/**
 * display cover function.
 *
 * @return void
 */
function display_current_user_cover_image()
{
    // Get the current user's image URL from user meta
    $user_id = get_current_user_id();
    $current_image_url = get_user_meta($user_id, 'epm_user_cover_image', true);

    if ($current_image_url) {
        // Extract the file name from the URL
        $file_name = basename($current_image_url);

        $thumbnail_width = 300;
        $thumbnail_height = 300;

        // Display the image as a thumbnail with the specified width and height, and set the file name as alt text
        echo '<img id="current-cimage" src="' . esc_url($current_image_url) . '" alt="' . esc_attr($file_name) . '" width="' . $thumbnail_width . '" height="' . $thumbnail_height . '">';
    } else {
        // Display a default image or a translated message if no image is available
        echo esc_html__('No Cover image available', 'eco-profile-master');
    }
}

// profile message
function displayConfirmationprofileUpdateMessages()
{
    $confirmation_messages = get_transient('profile_update_message');
    if ($confirmation_messages) {
    ?>
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-lg font-medium">
                <?php echo esc_html($confirmation_messages); ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    <?php
    }

    // Clear the confirmation messages from the transient
    delete_transient('profile_update_message');
}

// administration message 
function displayUserRegistrationMessage()
{
    $success_message = get_transient('registration_success_message');
    if ($success_message) {
    ?>
        <div id="alert-border-1" class="flex items-center p-4 mb-4 text-blue-800 border-t-4 border-blue-300 bg-blue-50 dark:text-blue-400 dark:bg-gray-800 dark:border-blue-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <div class="ml-3 text-lg font-medium">
                <?php echo esc_html($success_message); ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                <span class="sr-only"><?php _e('Dismiss', 'eco-profile-master'); ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <?php
    }
    delete_transient('registration_success_message');
}


// user listings 
function get_epm_user_listings()
{
    $users = get_users([
        'role'    => 'subscriber',
        'orderby' => 'user_nicename',
    ]);

    if (!empty($users)) {
        foreach ($users as $user) {
            $first_name = isset($user->ID) ? get_user_meta($user->ID, 'first_name', true) : '';
            $last_name = isset($user->ID) ? get_user_meta($user->ID, 'last_name', true) : '';
            $full_name = trim($first_name . ' ' .  $last_name);
            $epm_user_avatar = isset($user->ID) ? get_user_meta($user->ID, 'epm_user_avatar', true) : '';
            $signup_date = isset($user->user_registered) ? $user->user_registered : '';
            $epm_user_signup_date = date('F j, Y', strtotime($signup_date));
        ?>
            <tr>
                <td>
                    <?php
                    $default_avatar_url = EP_MASTER_ASSETS . '/images/dhp.png';
                    if (!empty($epm_user_avatar)) {
                        echo '<img src="' . esc_url($epm_user_avatar) . '" alt="' . esc_attr__('User Avatar', 'eco-profile-master') . '" width="50" height="50">';
                    } else {
                        echo '<img src="' . esc_url($default_avatar_url) . '" alt="' . esc_attr__('Default Avatar', 'eco-profile-master') . '" width="50" height="50">';
                    }
                    ?>
                </td>
                <td><?php echo esc_attr($full_name); ?></td>
                <td><?php echo isset($user->user_email) ? $user->user_email : ''; ?></td>
                <td><?php echo esc_attr($epm_user_signup_date); ?></td>
                <td>
                    <a href="<?php echo esc_url(add_query_arg(array('user_id' => $user->ID, 'username' => $user->user_login), home_url('/profile'))); ?>">View Profile</a>
                </td>
            </tr>
<?php
        }
    } else {
        echo __('No users found', 'echo-profile-master');
    }
}


/**
 * Generate select options for user gender.
 *
 * @param string $current_value The current selected value.
 * @param array  $options       An associative array of gender options.
 */
function generate_common_select_options($current_value, $options)
{
    foreach ($options as $value => $label) {
        $selected = ($current_value === $value) ? 'selected' : '';
        echo '<option value="' . esc_attr($value) . '" ' . $selected . '>' . esc_html($label) . '</option>';
    }
}
