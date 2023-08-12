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

    protected function epm_allow_user_profile_image_upload()
    {
        $allow_user_profile_image = get_option('epm_image', 'yes');
        $allow_user_profile_image = sanitize_text_field($allow_user_profile_image);
        //var_dump($allow_user_profile_image);
        return $allow_user_profile_image === 'yes';
    }

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


    protected function display_form_section_heading()
    {
        $form_section_heading_name = sanitize_text_field(get_option('epm_form_heading_name', '1'));

        if ($form_section_heading_name) {
            return '<h3>' . esc_html(sanitize_text_field(get_option('epm_form_heading_name_hide', 'Name'))) . '</h3>';
        }
        return '';
    }
}
