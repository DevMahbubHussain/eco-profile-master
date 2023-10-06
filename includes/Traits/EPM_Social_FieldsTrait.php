<?php

namespace EcoProfile\Master\Traits;

/**
 * Trait EPM_Social_FieldsTrait
 *
 * @package EcoProfileMaster
 */
trait EPM_Social_FieldsTrait
{
    protected function epm_allow_user_social_fields()
    {
        $enable_fb_field = get_option('epm_facebook_url', '1');
        $enable_fb_field = sanitize_text_field($enable_fb_field);

        $enable_twitter_field = get_option('epm_twitter_url', '1');
        $enable_twitter_field = sanitize_text_field($enable_twitter_field);

        $enable_linkedin_field = get_option('epm_linkedin_url', '1');
        $enable_linkedin_field = sanitize_text_field($enable_linkedin_field);

        $enable_youtube_field = get_option('epm_youtube_url', '1');
        $enable_youtube_field = sanitize_text_field($enable_youtube_field);

        $enable_instagram_field = get_option('epm_instagram_url', '1');
        $enable_instagram_field = sanitize_text_field($enable_instagram_field);

        return [
            'facebook' => $enable_fb_field === '1',
            'twitter' => $enable_twitter_field === '1',
            'linkedin' => $enable_linkedin_field === '1',
            'youtube' => $enable_youtube_field === '1',
            'instagram' => $enable_instagram_field === '1',
        ];
    }


    public function getEnabledSocialFields()
    {
        $socialFields = [
            'facebook' => 'epm_user_facebook',
            'twitter' => 'epm_user_twitter',
            'linkedin' => 'epm_user_linkedin',
            'youtube' => 'epm_user_youtube',
            'instagram' => 'epm_user_instagram',
            // Add other social fields...
        ];
        $enabledFields = [];

        foreach ($socialFields as $fieldKey => $fieldName) {
            $isEnabled = get_option('epm_' . $fieldKey . '_url', '1');
            $isEnabled = sanitize_text_field($isEnabled);

            if ($this->epm_allow_user_social_fields() && $isEnabled === '1') {
                $enabledFields[$fieldKey] = $fieldName;
            }
        }

        return $enabledFields;
    }

    /**
     * Advanced field function.
     *
     * @return void
     */
    protected function epm_allow_user_advanced_fields()
    {
        $enable_fb_gender = get_option('epm_user_gender', '1');
        $enable_fb_gender = sanitize_text_field($enable_fb_gender);

        $enable_birthdate_field = get_option('epm_user_birthdate', '0');
        $enable_birthdate_field = sanitize_text_field($enable_birthdate_field);

        $enable_occupation_field = get_option('epm_user_occupation', '0');
        $enable_occupation_field = sanitize_text_field($enable_occupation_field);

        $enable_religion_field = get_option('epm_user_religion', '0');
        $enable_religion_field = sanitize_text_field($enable_religion_field);

        $enable_skin_color_field = get_option('epm_user_skin_color', '0');
        $enable_skin_color_field = sanitize_text_field($enable_skin_color_field);

        $enable_blood_group_field = get_option('epm_user_blood_group', '0');
        $enable_blood_group_field = sanitize_text_field($enable_blood_group_field);

        return [
            'gender' => $enable_fb_gender === '1',
            'birthdate' => $enable_birthdate_field === '1',
            'occupation' =>  $enable_occupation_field === '1',
            'religion' => $enable_religion_field === '1',
            'skin' =>  $enable_skin_color_field === '1',
            'blood' =>  $enable_blood_group_field === '1',
        ];
    }

}
