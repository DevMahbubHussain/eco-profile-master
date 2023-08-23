<?php

namespace EcoProfile\Master\Traits;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

/**
 * Error handler trait
 */
trait EPM_Form_ValidationTrait
{
    /**
     * Holds the errors
     *
     * @var array
     */
    public $errors = array();


    // Validate form fields
    public function epm_validate_registration_fields($data)
    {
        //$errors = array();
        $epm_user_username = sanitize_text_field($data['epm_user_username']);
        $epm_user_email = sanitize_email($data['epm_user_email']);
        $epm_user_password = $data['epm_user_password'];
        $epm_user_retype_password = $data['epm_user_retype_password'];
        $epm_user_bio =  isset($data['epm_user_bio']) ? sanitize_textarea_field($data['epm_user_bio']) : '';

        // Validate firstname if provided and not purely numeric
        $firstname = isset($data['epm_user_firstname']) ? sanitize_text_field($data['epm_user_firstname']) : '';
        if (!empty($firstname) && is_numeric($firstname)) {
            $this->errors['epm_user_firstname'] = __('First name cannot be purely numeric.', 'eco-profile-master');
        }

        // Validate lastname if provided and not purely numeric
        $lastname = isset($data['epm_user_lastname']) ? sanitize_text_field($data['epm_user_lastname']) : '';
        if (!empty($lastname) && is_numeric($lastname)) {
            $this->errors['epm_user_lastname'] = __('Last name cannot be purely numeric.', 'eco-profile-master');
        }


        $nickname = isset($data['epm_user_nickname']) ? sanitize_text_field($data['epm_user_nickname']) : '';
        if (!empty($epm_user_nickname) && is_numeric($nickname)) {
            $this->errors['epm_user_nickname'] = __('Nickname  cannot be purely numeric.', 'eco-profile-master');
        }

        // Initialize an array to store username errors
        $username_errors = array();

        if (empty($epm_user_username)) {
            $username_errors[] = __('Username is required.', 'eco-profile-master');
        }
        if (username_exists($epm_user_username)) {
            $username_errors[] = __('Username already exists. Please choose a different username.', 'eco-profile-master');
        }
        if (is_numeric($epm_user_username)) {
            $username_errors[] = __('Username cannot be purely numeric.', 'eco-profile-master');
        }

        // Store the array of error messages for epm_user_username
        if (!empty($username_errors)) {
            $this->errors['epm_user_username'] = $username_errors;
        }

        // Initialize an array to store email errors
        $email_errors = array();

        if (empty($epm_user_email)) {
            $email_errors[] = __('Email is required.', 'eco-profile-master');
        }

        if (!is_email($epm_user_email)) {
            $email_errors[] = __('Invalid email format.', 'eco-profile-master');
        }

        if (email_exists($epm_user_email)) {
            $email_errors[] = __('Email already exists. Please use a different email address.', 'eco-profile-master');
        }

        // Store the array of error messages for epm_user_email
        if (!empty($email_errors)) {
            $this->errors['epm_user_email'] = $email_errors;
        }

        // phone
        $phoneUtil = PhoneNumberUtil::getInstance();
        $epm_user_phone = isset($data['epm_user_phone']) ? sanitize_text_field($data['epm_user_phone']) : '';
        try {
            $phoneNumber = $phoneUtil->parse($epm_user_phone, null);

            if (!$phoneUtil->isValidNumber($phoneNumber)) {
                $this->errors['epm_user_phone'][] = __('Please enter a valid phone number.', 'eco-profile-master');
            }
        } catch (\libphonenumber\NumberParseException $e) {
            $this->errors['epm_user_phone'][] = __('Please enter a valid phone number.', 'eco-profile-master');
        }



        // Validate password length
        if (strlen($epm_user_password) < 6) {
            $this->errors['epm_user_password_length'] = __('Password must be at least 6 characters long.', 'eco-profile-master');
        }

        // Validate password match
        if ($epm_user_password !== $epm_user_retype_password) {
            $this->errors['epm_user_password_match'] = __('Passwords do not match.', 'eco-profile-master');
        }

        // Validate website URL if provided and not empty
        $website = isset($data['epm_user_website']) ? esc_url_raw($data['epm_user_website']) : '';
        if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
            $this->errors['epm_user_website'] = __('Please enter a valid website URL.', 'eco-profile-master');
        }

        // Validate other optional fields as full-length URLs if provided

        // $epm_social_fields = array(
        //     'epm_user_facebook' => __('Facebook', 'eco-profile-master'),
        //     'epm_user_twitter' => __('Twitter', 'eco-profile-master'),
        //     'epm_user_linkedin' => __('LinkedIn', 'eco-profile-master'),
        //     'epm_user_youtube' => __('YouTube', 'eco-profile-master'),
        //     'epm_user_instagram' => __('Instagram', 'eco-profile-master'),
        //     // Add more fields here
        // );

        // foreach ($epm_social_fields as $field_name => $field_label) {
        //     if (isset($data[$field_name]) && !empty($data[$field_name]) && !filter_var($data[$field_name], FILTER_VALIDATE_URL)) {
        //         $this->errors[$field_name] = sprintf(__('Please enter a valid %s URL.', 'eco-profile-master'), $field_label);
        //     }
        // }


        $epm_social_fields = array(
            'epm_user_facebook' => __('Facebook', 'eco-profile-master'),
            'epm_user_twitter' => __('Twitter', 'eco-profile-master'),
            'epm_user_linkedin' => __('LinkedIn', 'eco-profile-master'),
            'epm_user_youtube' => __('YouTube', 'eco-profile-master'),
            'epm_user_instagram' => __('Instagram', 'eco-profile-master'),
            // Add more fields here
        );

        $field_errors = array(); // Separate array to store errors for each field

        foreach ($epm_social_fields as $field_name => $field_label) {
            if (isset($data[$field_name]) && !empty($data[$field_name]) && !filter_var($data[$field_name], FILTER_VALIDATE_URL)) {
                $field_errors[$field_name] = sprintf(__('Please enter a valid %s URL.', 'eco-profile-master'), $field_label);
            }
        }

        // Merge the field-specific errors with the main errors array
        $this->errors = array_merge($this->errors, $field_errors);




        // Initialize an array to store image upload errors
        $image_errors = array();

        // Validate uploaded image if provided
        if (isset($_FILES['epm_user_avatar']) && $_FILES['epm_user_avatar']['error'] === 0) {
            $image_mime_types = array('image/jpeg', 'image/png', 'image/gif');
            $max_image_size = 1024 * 1024; // 1 MB

            // Check if the uploaded file is an image
            if (!in_array($_FILES['epm_user_avatar']['type'], $image_mime_types)) {
                $image_errors[] = __('Please upload a valid image file (JPEG, PNG, GIF).', 'eco-profile-master');
            }

            // Check if the image size is within limits
            if ($_FILES['epm_user_avatar']['size'] > $max_image_size) {
                $image_errors[] = __('Image size should be 1 MB or less.', 'eco-profile-master');
            }
        }

        // Store the array of error messages for epm_user_avatar
        if (!empty($image_errors)) {
            $this->errors['epm_user_avatar'] = $image_errors;
        }

        return $this->errors;
        //var_dump($this->errors);
    }


    // Verify user capability
    public function validateUserCapability()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Unauthorized access. Please contact the site administrator.', 'eco-profile-master'));
        }
    }

    // Verify nonce
    public function validateNonce($nonce_field, $nonce_action)
    {
        if (!isset($_POST[$nonce_field]) || !wp_verify_nonce($_POST[$nonce_field], $nonce_action)) {
            wp_die(__('Security check failed. Please try again nonce.', 'eco-profile-master'));
        }
    }




    /**
     * Check if the form has error
     *
     * @param  string  $key
     *
     * @return boolean
     */

    public function has_error($key)
    {
        return isset($this->errors[$key]) ? true : false;
    }

    /**
     * Get the error by key
     *
     * @param  key $key
     *
     * @return string | false
     */
    public function get_error($key)
    {
        if (isset($this->errors[$key])) {
            return $this->errors[$key];
        }

        return false;
    }
}