<?php

namespace EcoProfile\Master\Traits;

/**
 * Trait EPM_Signup_FieldsTrait
 * 
 * @package EcoProfileMaster
 */
trait EPM_Signup_FieldsTrait
{
    /**
     * Checks if allow-profile-image of users should be enabled.
     *
     * @return bool Whether allow-user-upload-profile-image should be enabled.
     */

    // protected function epm_allow_user_profile_image_upload()
    // {
    //     $allow_user_profile_image = get_option('epm_image', 'yes');
    //     $allow_user_profile_image = sanitize_text_field($allow_user_profile_image);
    //     //var_dump($allow_user_profile_image);
    //     return $allow_user_profile_image === 'yes';
    // }

    // protected function epm_allow_user_common_fields()
    // {

    //     $allow_user_profile_email = get_option('epm_display_email', 'yes');
    //     $allow_user_profile_email = sanitize_text_field($allow_user_profile_email);

    //     $allow_user_profile_phone = get_option('epm_display_phone_number', 'no');
    //     $allow_user_profile_phone = sanitize_text_field($allow_user_profile_phone);

    //     $allow_user_profile_image = get_option('epm_image', 'no');
    //     $allow_user_profile_image = sanitize_text_field($allow_user_profile_image);

    //     $allow_user_social_links = get_option('epm_display_social_links', 'no');
    //     $allow_user_social_links = sanitize_text_field($allow_user_social_links);

    //     return $allow_user_profile_image === 'yes' && $allow_user_profile_phone === 'yes' && $allow_user_profile_email === 'yes' && $allow_user_social_links === 'yes';
    // }



    public function epm_allow_user_common_fields($field)
    {
        $allow_user_profile_image = get_option('epm_image', 'no');
        $allow_user_profile_phone = get_option('epm_display_phone_number', 'no');
        $allow_user_profile_email = get_option('epm_display_email', 'yes');
        $allow_user_social_links = get_option('epm_display_social_links', 'no');

        $allow_user_profile_image = sanitize_text_field($allow_user_profile_image);
        $allow_user_profile_phone = sanitize_text_field($allow_user_profile_phone);
        $allow_user_profile_email = sanitize_text_field($allow_user_profile_email);
        $allow_user_social_links = sanitize_text_field($allow_user_social_links);

        switch ($field) {
            case 'image':
                return $allow_user_profile_image === 'yes';
            case 'phone':
                return $allow_user_profile_phone === 'yes';
            case 'email':
                return $allow_user_profile_email === 'yes';
            case 'social_links':
                return $allow_user_social_links === 'yes';
            default:
                return false; // Field not recognized
        }
    }



    



    // protected function epm_allow_user_social_fields()
    // {
    //     $enable_fb_field = get_option('epm_facebook_url', '1');
    //     $enable_fb_field = sanitize_text_field($enable_fb_field);

    //     $enable_twitter_field = get_option('epm_twitter_url', '1');
    //     $enable_twitter_field = sanitize_text_field($enable_twitter_field);

    //     $enable_linkedin_field = get_option('epm_linkedin_url', '1');
    //     $enable_linkedin_field = sanitize_text_field($enable_linkedin_field);

    //     $enable_youtube_field = get_option('epm_youtube_url', '1');
    //     $enable_youtube_field = sanitize_text_field($enable_youtube_field);

    //     $enable_instagram_field = get_option('epm_instagram_url', '1');
    //     $enable_instagram_field = sanitize_text_field($enable_instagram_field);

    //     return $enable_fb_field  === '1' && $enable_twitter_field  === '1' && $enable_linkedin_field === '1' &&  $enable_youtube_field === '1' &&  $enable_instagram_field === '1';
    // }


    /**
     * Checks if auto-generation of passwords should be enabled.
     *
     * @return bool Whether auto-generation of passwords should be enabled.
     */

    protected function epm_should_generate_password()
    {
        $auto_generate_password = get_option('epm_auto_generate_pass', '0');
        $auto_generate_password = sanitize_text_field($auto_generate_password);
        //var_dump($auto_generate_password);
        return $auto_generate_password !== '1';
    }

    /**
     * Checks if capitalize name fields should be enabled.
     *
     * @return array Whether capitalize name fields should be enabled.
     */
    protected function  epm_capitalize_and_store_names($first_name, $last_name)
    {
        $capitalize_names = get_option('epm_first_lastname_captitilize', '0');
        $capitalize_names = sanitize_text_field($capitalize_names);

        $capitalized_first_name = $capitalize_names === '1' ? ucfirst($first_name) : $first_name;
        $capitalized_last_name = $capitalize_names === '1' ? ucfirst($last_name) : $last_name;

        return array($capitalized_first_name, $capitalized_last_name);

        //Use the trait method to capitalize and store names
        // list($stored_first_name, $stored_last_name) = $this->epm_capitalize_and_store_names($first_name, $last_name);
    }


    // protected function display_form_section_heading()
    // {
    //     $epm_form_heading_name = sanitize_text_field(get_option('epm_form_heading_name', 'Name'));
    //     $epm_form_heading_name_hide = sanitize_text_field(get_option('epm_form_heading_name_hide', '1'));

    //     return $epm_form_heading_name_hide === '1' ? $epm_form_heading_name : '';

    // }

    protected function display_form_section_heading($option_name, $default_heading = '')
    {
        $heading = sanitize_text_field(get_option($option_name, $default_heading));
        $hide_option_name = $option_name . '_hide';
        $hide = sanitize_text_field(get_option($hide_option_name, '1'));

        return $hide === '1' ? $heading : '';
    }

    public function generate_section_heading($hide_option, $heading_option, $default_hide_value, $default_heading)
    {
        $heading_hide = $this->display_form_section_heading($hide_option, $default_hide_value);
        $heading = sanitize_text_field(get_option($heading_option, $default_heading));

        if ($heading_hide === '1') {
            return "$heading";
        } else {
            return '';
        }
    }
}
