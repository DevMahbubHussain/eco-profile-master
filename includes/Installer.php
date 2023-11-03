<?php

namespace EcoProfile\Master;

/**
 * Installer class for initializing and configuring the plugin.
 */
class Installer
{
    /**
     * Run the installer.
     *
     * This method performs initial setup and configuration of the plugin during installation.
     *
     * @return void
     */

    public function run()
    {
        $this->add_version();
        $this->add_plugin_default_value();
    }

    /**
     * Add the plugin version and installation timestamp to the database.
     *
     * This method stores the plugin version and installation timestamp in the WordPress options table.
     *
     * @return void
     */

    public function add_version()
    {
        $installed = get_option('epm_installed');
        if (!$installed) {

            update_option('epm_installed', time());
        }
        update_option('epm_version', EP_MASTER_VERSION);
    }

    /**
     * Add default values and settings for the plugin.
     *
     * This method initializes various default values and settings for the plugin during installation.
     *
     * @return void
     */

    public function add_plugin_default_value()
    {
        $epm_general_default_options = array(
            'epm_form_style' => __('Style 1', 'eco-profile-master'),
            'epm_automatically_login' => __('no', 'eco-profile-master'),
            'epm_email_confirmation_activated' => __('no', 'eco-profile-master'),
            'epm_admin_approval' => __('no', 'eco-profile-master'),
            'epm_show_logout' => __('no', 'eco-profile-master'),
            'epm_display_email' => __('yes', 'eco-profile-master'),
            'epm_display_phone_number' => __('no', 'eco-profile-master'),
            'epm_image' => __('no', 'eco-profile-master'),
            'epm_cimage' => __('no', 'eco-profile-master'),
            'epm_mailing_address' => __('no', 'eco-profile-master'),
            'epm_display_social_links' => __('no', 'eco-profile-master')
        );

        // Loop through the array and add options using add_option
        foreach ($epm_general_default_options as $option_name => $general_default_value) {
            add_option($option_name, $general_default_value);
        }

        // Dynamically create a new page for password recovery
        $recover_password_page_title = __('Recover-Password', 'eco-profile-master');
        $login_page_title = __('Login', 'eco-profile-master');
        $login_profile_title = __('Profile Edit', 'eco-profile-master');
        $slug = 'recover-password';
        $recover_password_page = array(
            'post_title' => $recover_password_page_title,
            'post_name'     => $slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content'  => "<!-- wp:shortcode -->[epm-pass-recover]<!-- /wp:shortcode -->",
        );
        $recover_password_page_id = wp_insert_post($recover_password_page);

        if (!is_wp_error($recover_password_page_id)) {
            // Set the page title in the settings option
            update_option('epm_lost_password_page', $recover_password_page_title);
            update_option('epm_login_page', $login_page_title);
            update_option('epm_profile_page', $login_profile_title);
        }

        // Default values for advanced settings
        $epm_default_advanced_settings = array(
            'epm_email_confirmation' => 1,
            'epm_remember_me' => 0,
            'epm_send_credentials' => 1,
            'epm_first_lastname_captitilize' => 0,
            'epm_user_gender' => 1,
            'epm_user_birthdate' => 0,
            'epm_user_occupation' => 0,
            'epm_user_religion' => 0,
            'epm_user_skin_color' => 0,
            'epm_user_blood_group' => 0,
            'epm_facebook_url' => 1,
            'epm_twitter_url' => 1,
            'epm_linkedin_url' => 1,
            'epm_youtube_url' => 1,
            'epm_instagram_url' => 1
        );

        foreach ($epm_default_advanced_settings as $option_name => $default_value) {
            add_option($option_name, $default_value);
        }

        // Set default values for form headings and show/hide checkboxes
        $epm_form_sections_headings = array(
            'name' => __('Name', 'eco-profile-master'),
            'contact_info' => __('Contact Info', 'eco-profile-master'),
            'about_yourself' => __('About Yourself', 'eco-profile-master'),
            'profile_image' => __('Profile Image', 'eco-profile-master'),
            'cover_image' => __('Cover Image', 'eco-profile-master'),
            'social_links' => __('Social Links', 'eco-profile-master'),
            'mailing_address' => __('Mailing Address', 'eco-profile-master'),
        );

        foreach ($epm_form_sections_headings as $section_key => $section_label) {
            $option_name = "epm_form_heading_$section_key";
            $hide_option_name = "epm_form_heading_{$section_key}_hide";

            if (!get_option($option_name)) {
                add_option($option_name, $section_label);
            }

            if (!get_option($hide_option_name)) {
                add_option($hide_option_name, '1'); // Default to "Show"
            }
        }

        // default value for labels and placeholder
        $fields = array(
            'username', 'firstname', 'lastname', 'nickname', 'email',
            'phone', 'website', 'biographical', 'password', 'repassword',
            'facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'image', 'cimage',
            'occupation', 'religion', 'skin', 'gender', 'birthdate', 'blood', 'house',
            'road', 'location'
        );

        $default_values = array();
        foreach ($fields as $field) {
            $default_label = __($field === 'repassword' ? 'Repeat Password' : ucwords(str_replace('_', ' ', $field)), 'eco-profile-master');
            $default_placeholder = __('Enter your ' . ($field === 'repassword' ? 'password again for confirmation' : str_replace('_', ' ', $field)), 'eco-profile-master');
            if (in_array($field, array('facebook', 'twitter', 'linkedin', 'youtube', 'instagram'))) {
                $default_label = __('Enter your ' . ucwords(str_replace('_', ' ', $field)) . ' url', 'eco-profile-master');
                $default_placeholder = $default_label;
            }

            $default_values[$field] = array(
                'label' => $default_label,
                'placeholder' => $default_placeholder,
            );

            if ($field === 'image') {
                $default_values[$field]['label'] = __('Upload your profile image', 'eco-profile-master');
                unset($default_values[$field]['placeholder']);
            }

            if ($field === 'cimage') {
                $default_values[$field]['label'] = __('Profile Cover image', 'eco-profile-master');
                unset($default_values[$field]['placeholder']);
            }
        }

        update_option('epm_form_label_placeholder', $default_values);

        // plugin pages 
        $this->epm_plugin_pages('login', 'Login', 'epm-login');
        $this->epm_plugin_pages('register', 'Regisetr', 'epm-register');
        $this->epm_plugin_pages('Pick a New Password', 'Pick a New Password', 'epm-password-reset-form');
        $this->epm_plugin_pages('profile', 'Profile', 'epm-profile');
        $this->epm_plugin_pages('profile-edit', 'Profile Edit', 'epm-profile-edit');
        $this->epm_plugin_pages('user-listings', 'User Listings', 'epm-user-listings');
        flush_rewrite_rules();
    }

    /**
     * Create a new plugin page with a given slug, title, and shortcode.
     *
     * @param string $slug      The slug for the new page.
     * @param string $title     The title of the new page.
     * @param string $shortcode The shortcode to add to the new page's content.
     */
    
    public function epm_plugin_pages($slug, $title, $shortcode)
    {
        global $wpdb;
        if ($wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = '$slug'") === null) {

            $current_user = wp_get_current_user();

            $page = array(
                'post_title'    => __($title, 'echo-profile-master'),
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_author'   => $current_user->ID,
                'post_type'     => 'page',
                'post_content'  => "<!-- wp:shortcode -->[$shortcode]<!-- /wp:shortcode -->",
            );

            wp_insert_post($page);
        }
    }
}
