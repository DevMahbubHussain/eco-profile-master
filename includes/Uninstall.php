<?php

namespace EcoProfile\Master;

class Uninstall
{
    public function run()
    {
        $this->remove_plugin_default_value();
    }

    public function remove_plugin_default_value()
    {
        $epm_general_settings_options_to_delete = array(
            'epm_form_style',
            'epm_automatically_login',
            'epm_email_confirmation_activated',
            'epm_admin_approval',
            'epm_display_email',
            'epm_display_phone_number',
            'epm_image',
            'epm_cimage',
            'epm_mailing_address',
            'epm_display_social_kinks',
            'epm_lost_password_page' // Delete the "Select Recover Password Page" option
        );

        foreach ($epm_general_settings_options_to_delete as $option_name) {
            delete_option($option_name);
        }

        // Additional code to delete pages if needed
        $page_option_names = array(
            'epm_lost_password_page',
            'epm_login_page',
            'epm_profile_page',
        );
        foreach ($page_option_names as $option_name) {
            $page_id = get_option($option_name);

            if ($page_id) {
                wp_delete_post($page_id, true);
                delete_option($option_name);
            }
        }

        // Delete advanced settings options
        $epm_advanced_settings_options_to_delete = array(
            'epm_email_confirmation',
            'epm_remember_me',
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

        foreach ($epm_advanced_settings_options_to_delete as $option_name) {
            delete_option($option_name);
        }

        // Delete options for form headings and show/hide checkboxes
        $epm_form_sections_headings = array(
            'name',
            'contact_info',
            'about_yourself',
            'profile_image',
            'cover_image',
            'social_links',
            'mailing_address',
            'occupation',
            'religion',
            'skin',
            'gender',
            'blood'
        );

        foreach ($epm_form_sections_headings as $section_key) {
            $option_name = "epm_form_heading_$section_key";
            $hide_option_name = "epm_form_heading_{$section_key}_hide";
            $epm_form_headings_options_to_delete[] = $option_name;
            $epm_form_headings_options_to_delete[] = $hide_option_name;
        }

        foreach ($epm_form_headings_options_to_delete as $option_name) {
            delete_option($option_name);
        }
        // delete default value for labels and placeholder 
        delete_option('epm_form_label_placeholder');

        // delete all plugin pages
        $this->epm_plugin_deactive_pages();

        //recover page delete
        $page_id = get_page_by_path('recover-password');
        if ($page_id) {
            wp_delete_post($page_id->ID, true);
        }
    }

    public function epm_plugin_deactive_pages()
    {
        $pages_to_delete = array('login', 'register', 'profile-edit', 'listings', 'new-password-form', 'profile', 'recover-password');
        foreach ($pages_to_delete as $page_slug) {
            $page_id = get_page_by_path($page_slug);
            if ($page_id) {
                wp_delete_post($page_id->ID, true);
            }
        }
    }
}
