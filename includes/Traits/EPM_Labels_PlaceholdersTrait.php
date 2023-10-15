<?php

namespace EcoProfile\Master\Traits;

/**
 * Trait EPM_Labels_PlaceholdersTrait
 * 
 * @package EcoProfileMaster
 */
trait EPM_Labels_PlaceholdersTrait
{
    /**
     * Retrieve sanitized label and placeholder values for form fields.
     *
     * This method retrieves and sanitizes label and placeholder values for form fields
     * from the stored options. It ensures that the labels and placeholders are safe for display.
     *
     * @return string A formatted string containing sanitized label and placeholder values.
     */
    protected function epm_label_placeholder()
    {
        $fieldMappings = array(
            'username' => array('label', 'placeholder'),
            'firstname' => array('label', 'placeholder'),
            'lastname' => array('label', 'placeholder'),
            'nicknmae' => array('label', 'placeholder'),
            'email' => array('label', 'placeholder'),
            'phone' => array('label', 'placeholder'),
            'website' => array('label', 'placeholder'),
            'biographical' => array('label', 'placeholder'),
            'password' => array('label', 'placeholder'),
            'repassword' => array('label', 'placeholder'),
            'occupation' => array('label', 'placeholder'),
            'religion' => array('label', 'placeholder'),
            'skin' => array('label', 'placeholder'),
            'gender' => array('label', 'placeholder'),
            'birthdate' => array('label', 'placeholder'),
            'blood' => array('label', 'placeholder'),
            'house' => array('label', 'placeholder'),
            'road' => array('label', 'placeholder'),
            'location' => array('label', 'placeholder'),
            'facebook' => array('label', 'placeholder'),
            'twitter' => array('label', 'placeholder'),
            'linkedin' => array('label', 'placeholder'),
            'youtube' => array('label', 'placeholder'),
            'instagram' => array('label', 'placeholder'),
            'image' => array('label', ''),
            'cimage' => array('label', ''),
            // Add more fields here
        );

        $values = get_option('epm_form_label_placeholder', array()); // Get the array directly
        // sanitize the entire array 
        foreach ($fieldMappings as $fieldKey => $fieldLabels) {
            foreach ($fieldLabels as $labelType) {
                if (isset($values[$fieldKey][$labelType])) {
                    $values[$fieldKey][$labelType] = sanitize_text_field($values[$fieldKey][$labelType]);
                }
            }
        }
        $formattedFields = array(
            'username' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'firstname' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'lastname' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'nickname' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'email' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'phone' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'website' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'biographical' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'password' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'repassword' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'occupation' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'religion' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'skin' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'gender' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'birthdate' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'blood' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'house' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'road' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'location' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'facebook' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'twitter' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'linkedin' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'youtube' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'instagram' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'image' => array(
                'label' => '',
                'placeholder' => ''
            ),
            'cimage' => array(
                'label' => '',
                'placeholder' => ''
            ),
            // Add more fields here
        );

        // name section
        if (isset($values['username']['label'])) {
            $formattedFields['username']['label'] = $values['username']['label'];
        }

        if (isset($values['username']['placeholder'])) {
            $formattedFields['username']['placeholder'] = $values['username']['placeholder'];
        }

        if (isset($values['firstname']['label'])) {
            $formattedFields['firstname']['label'] = $values['firstname']['label'];
        }

        if (isset($values['firstname']['placeholder'])) {
            $formattedFields['firstname']['placeholder'] = $values['firstname']['placeholder'];
        }

        if (isset($values['lastname']['label'])) {
            $formattedFields['lastname']['label'] = $values['lastname']['label'];
        }

        if (isset($values['lastname']['placeholder'])) {
            $formattedFields['lastname']['placeholder'] = $values['lastname']['placeholder'];
        }

        if (isset($values['nickname']['label'])) {
            $formattedFields['nickname']['label'] = $values['nickname']['label'];
        }

        if (isset($values['nickname']['placeholder'])) {
            $formattedFields['nickname']['placeholder'] = $values['nickname']['placeholder'];
        }

        // contact info

        if (isset($values['email']['label'])) {
            $formattedFields['email']['label'] = $values['email']['label'];
        }

        if (isset($values['email']['placeholder'])) {
            $formattedFields['email']['placeholder'] = $values['email']['placeholder'];
        }

        if (isset($values['phone']['label'])) {
            $formattedFields['phone']['label'] = $values['phone']['label'];
        }

        if (isset($values['phone']['placeholder'])) {
            $formattedFields['phone']['placeholder'] = $values['phone']['placeholder'];
        }

        if (isset($values['website']['label'])) {
            $formattedFields['website']['label'] = $values['website']['label'];
        }

        if (isset($values['website']['label'])) {
            $formattedFields['website']['placeholder'] = $values['website']['placeholder'];
        }
        // bio section

        if (isset($values['biographical']['placeholder'])) {
            $formattedFields['biographical']['placeholder'] = $values['biographical']['placeholder'];
        }
        if (isset($values['biographical']['label'])) {
            $formattedFields['biographical']['label'] = $values['biographical']['label'];
        }

        if (isset($values['password']['placeholder'])) {
            $formattedFields['password']['placeholder'] = $values['password']['placeholder'];
        }
        if (isset($values['password']['label'])) {
            $formattedFields['password']['label'] = $values['password']['label'];
        }

        if (isset($values['repassword']['placeholder'])) {
            $formattedFields['repassword']['placeholder'] = $values['repassword']['placeholder'];
        }
        if (isset($values['repassword']['label'])) {
            $formattedFields['repassword']['label'] = $values['repassword']['label'];
        }
        // occupation 
        if (isset($values['occupation']['placeholder'])) {
            $formattedFields['occupation']['placeholder'] = $values['occupation']['placeholder'];
        }
        if (isset($values['occupation']['label'])) {
            $formattedFields['occupation']['label'] = $values['occupation']['label'];
        }
        // religion 
        if (isset($values['religion']['placeholder'])) {
            $formattedFields['religion']['placeholder'] = $values['religion']['placeholder'];
        }
        if (isset($values['religion']['label'])) {
            $formattedFields['religion']['label'] = $values['religion']['label'];
        }
        // skin 
        if (isset($values['skin']['placeholder'])) {
            $formattedFields['skin']['placeholder'] = $values['skin']['placeholder'];
        }
        if (isset($values['skin']['label'])) {
            $formattedFields['skin']['label'] = $values['skin']['label'];
        }
        // gender 
        if (isset($values['gender']['placeholder'])) {
            $formattedFields['gender']['placeholder'] = $values['gender']['placeholder'];
        }
        if (isset($values['gender']['label'])) {
            $formattedFields['gender']['label'] = $values['gender']['label'];
        }
        // birthdate 
        if (isset($values['birthdate']['placeholder'])) {
            $formattedFields['birthdate']['placeholder'] = $values['birthdate']['placeholder'];
        }
        if (isset($values['birthdate']['label'])) {
            $formattedFields['birthdate']['label'] = $values['birthdate']['label'];
        }
        // blood 
        if (isset($values['blood']['placeholder'])) {
            $formattedFields['blood']['placeholder'] = $values['blood']['placeholder'];
        }
        if (isset($values['blood']['label'])) {
            $formattedFields['blood']['label'] = $values['blood']['label'];
        }

        // Mailing Address

        if (isset($values['house']['placeholder'])) {
            $formattedFields['house']['placeholder'] = $values['house']['placeholder'];
        }
        if (isset($values['house']['label'])) {
            $formattedFields['house']['label'] = $values['house']['label'];
        }

        if (isset($values['road']['placeholder'])) {
            $formattedFields['road']['placeholder'] = $values['road']['placeholder'];
        }
        if (isset($values['road']['label'])) {
            $formattedFields['road']['label'] = $values['road']['label'];
        }

        if (isset($values['location']['placeholder'])) {
            $formattedFields['location']['placeholder'] = $values['location']['placeholder'];
        }
        if (isset($values['location']['label'])) {
            $formattedFields['location']['label'] = $values['location']['label'];
        }
                
        // social 
        if (isset($values['facebook']['placeholder'])) {
            $formattedFields['facebook']['placeholder'] = $values['facebook']['placeholder'];
        }
        if (isset($values['facebook']['label'])) {
            $formattedFields['facebook']['label'] = $values['facebook']['label'];
        }

        if (isset($values['twitter']['placeholder'])) {
            $formattedFields['twitter']['placeholder'] = $values['twitter']['placeholder'];
        }
        if (isset($values['twitter']['label'])) {
            $formattedFields['twitter']['label'] = $values['twitter']['label'];
        }

        if (isset($values['linkedin']['placeholder'])) {
            $formattedFields['linkedin']['placeholder'] = $values['linkedin']['placeholder'];
        }
        if (isset($values['linkedin']['label'])) {
            $formattedFields['linkedin']['label'] = $values['linkedin']['label'];
        }

        if (isset($values['youtube']['placeholder'])) {
            $formattedFields['youtube']['placeholder'] = $values['youtube']['placeholder'];
        }
        if (isset($values['youtube']['label'])) {
            $formattedFields['youtube']['label'] = $values['youtube']['label'];
        }

        if (isset($values['instagram']['placeholder'])) {
            $formattedFields['instagram']['placeholder'] = $values['instagram']['placeholder'];
        }
        if (isset($values['instagram']['label'])) {
            $formattedFields['instagram']['label'] = $values['instagram']['label'];
        }
        // profile image
        if (isset($values['image']['label'])) {
            $formattedFields['image']['label'] = $values['image']['label'];
        }

        // cover image
        if (isset($values['cimage']['label'])) {
            $formattedFields['cimage']['label'] = $values['cimage']['label'];
        }
        return $formattedFields;
    }
}
