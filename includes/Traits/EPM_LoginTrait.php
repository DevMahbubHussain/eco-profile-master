<?php

namespace EcoProfile\Master\Traits;

trait EPM_LoginTrait
{
    public $errors = array();

    /**
     * Validate Login Form
     *
     * Validates the login form fields, including username or email and password.
     * Sets error messages in the `$errors` array if validation fails.
     *
     * @param string $username_or_email The entered username or email.
     * @param string $password The entered password.
     *
     * @return array An array of error messages.
     */

    public function validateLoginForm($username_or_email, $password)
    {
        if (empty($username_or_email)) {
            $this->errors['username_or_email'] = __('Username or email is required.', 'eco-profile-master');
        } else {
            $user_by_email = get_user_by('email', $username_or_email);
            $user_by_login = get_user_by('login', $username_or_email);
            if (!$user_by_email && !$user_by_login) {
                $this->errors['username_or_email'] = __('Invalid username or email', 'eco-profile-master');
            }
        }
        if (empty($password)) {
            $this->errors['password'] = __('Password is required.', 'eco-profile-master');
        }
        if (!empty($username_or_email) && !empty($password)) {
            $user = $user_by_email ? $user_by_email : $user_by_login;
            if ($user && !wp_check_password($password, $user->user_pass, $user->ID)) {
                $this->errors['password'] = __('Incorrect password.', 'eco-profile-master');
            }
        }

        return $this->errors;
    }

    /**
     * Validate Password Reset Form
     *
     * Validates the password reset form fields, including new password and confirm password.
     * Sets error messages in the `$errors` array if validation fails.
     *
     * @param string $new_password The new password.
     * @param string $confirm_password The confirmation of the new password.
     *
     * @return array An array of error messages.
     */

    public function validateResetForm($new_password, $confirm_password)
    {
        if ($new_password !== $confirm_password) {
            $this->errors['password_mismatch'] =  __('Passwords do not match', 'eco-profile-master');
        }
        if (strlen($new_password) < 7) {
            $this->errors['password_length'] = 'Password must be at least 7 characters long.';
        }
        return $this->errors;
    }

    /**
     * Check if a Login Error Exists
     *
     * Checks if a specific login error key exists in the `$errors` array.
     *
     * @param string $key The key to check for an error.
     *
     * @return bool True if the error exists, false otherwise.
     */

    public function login_has_error($key)
    {
        return isset($this->errors[$key]) ? true : false;
    }

    /**
     * Get a Login Error Message
     *
     * Retrieves an error message from the `$errors` array by the provided key.
     *
     * @param string $key The key to get the error message.
     *
     * @return string|false The error message if it exists, false otherwise.
     */
    
    public function login_get_error($key)
    {
        if (isset($this->errors[$key])) {
            return $this->errors[$key];
        }

        return false;
    }

    /**
     * Email Confirmation Handler
     *
     * Handles email confirmation based on the admin approval setting.
     * Generates a confirmation message and sets it to be displayed to the user.
     *
     * @return string Confirmation message.
     */
    
    public function EmailConfirmationHandler()
    {
        $is_admin_approved = sanitize_text_field(get_option('epm_admin_approval', 'no'));
        $confirmation_message = '';

        if ($is_admin_approved === 'yes') {
            // Display a message and redirect for admin approval
            $confirmation_message = __('Your email has been confirmed. Please wait for admin approval.', 'eco-profile-master');
        } else {
            // Display a message and provide a login link
            $epm_login_page = sanitize_text_field(get_option('epm_login_page', 'Login'));
            $confirmation_message = __('Your email has been confirmed.', 'eco-profile-master');
            $confirmation_message = generate_confirmation_message($confirmation_message, $epm_login_page);
        }

        // Add the confirmation message to the epm_login_page
        $confirmation_messages = get_transient('confirmation_messages');
        if (!$confirmation_messages || !is_array($confirmation_messages)) {
            $confirmation_messages = array();
        }
        $confirmation_messages[] = $confirmation_message;
        set_transient('confirmation_messages', $confirmation_messages, 1);

        return $confirmation_message;
    }
}
