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

    // public function renderSocialFields()
    // {
    //     $allowedFields = $this->epm_allow_user_social_fields();

    //     foreach ($allowedFields as $fieldKey => $isEnabled) {
    //         if ($isEnabled) {
    //             $fieldName = 'epm_user_' . $fieldKey;
    //             $label = ucwords($fieldKey);

    //             echo sprintf(
    //                 '<div class="flow">
    //                     <label for="%s" class="text-gray-700">%s Label</label>
    //                     <input type="text" id="%s" name="%s" class="input input-bordered w-full" placeholder="%s Placeholder">
    //                 </div>',
    //                 esc_attr($fieldName),
    //                 esc_attr($label),
    //                 esc_attr($fieldName),
    //                 esc_attr($fieldName),
    //                 esc_attr($label)
    //             );
    //         }
    //     }
    // }
}
