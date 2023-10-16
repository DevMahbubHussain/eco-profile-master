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
     * Checks if common user fields should be enabled.
     *
     * @param string $field The field to check.
     * 
     * @return bool Whether the specified common user field should be enabled.
     */
    public function epm_allow_user_common_fields($field)
    {
        $allow_user_profile_image = get_option('epm_image', 'no');
        $allow_user_cover_image = get_option('epm_cimage', 'no');
        $allow_user_profile_phone = get_option('epm_display_phone_number', 'no');
        $allow_user_profile_email = get_option('epm_display_email', 'yes');
        $allow_user_social_links = get_option('epm_display_social_links', 'no');

        $allow_user_profile_image = sanitize_text_field($allow_user_profile_image);
        $allow_user_cover_image = sanitize_text_field($allow_user_cover_image);
        $allow_user_profile_phone = sanitize_text_field($allow_user_profile_phone);
        $allow_user_profile_email = sanitize_text_field($allow_user_profile_email);
        $allow_user_social_links = sanitize_text_field($allow_user_social_links);

        switch ($field) {
            case 'image':
                return $allow_user_profile_image === 'yes';
            case 'cimage':
                return $allow_user_cover_image === 'yes';
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

    /**
     * Checks if auto-generation of passwords should be enabled.
     *
     * @return bool Whether auto-generation of passwords should be enabled.
     */
    protected function epm_should_generate_password()
    {
        $auto_generate_password = get_option('epm_auto_generate_pass', '0');
        $auto_generate_password = sanitize_text_field($auto_generate_password);
        return $auto_generate_password !== '1';
    }

    /**
     * Display a form section heading based on options.
     *
     * @param string $option_name       The option name for the heading.
     * @param string $default_heading   The default heading to display if not configured.
     * 
     * @return string The section heading or an empty string if hidden.
     */
    protected function display_form_section_heading($option_name, $default_heading = '')
    {
        $heading = sanitize_text_field(get_option($option_name, $default_heading));
        $hide_option_name = $option_name . '_hide';
        $hide = sanitize_text_field(get_option($hide_option_name, '1'));
        return $hide === '1' ? $heading : '';
    }

    /**
     * Generate a section heading based on hide and heading options.
     *
     * @param string $hide_option       The hide option name.
     * @param string $heading_option    The heading option name.
     * @param string $default_hide_value The default value for hiding the section.
     * @param string $default_heading   The default heading to display if not configured.
     * 
     * @return string The section heading or an empty string if hidden.
     */
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
