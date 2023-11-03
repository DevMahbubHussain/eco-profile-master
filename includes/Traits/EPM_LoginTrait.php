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
        //email confirmation. 
        $send_confirmation = sanitize_text_field(get_option('epm_email_confirmation_activated', 'no'));
        if ($send_confirmation === 'yes') {
            if (!empty($username_or_email) && !empty($password)) {
                $user = $user_by_email ? $user_by_email : $user_by_login;

                if ($user) {
                    // Check if email confirmation is required for this user
                    $email_confirmation_required = get_user_meta($user->ID, 'email_confirmation_required', true);

                    if ($email_confirmation_required === 'yes') {
                        // Check if the user's email is confirmed
                        $is_email_verified = get_user_meta($user->ID, 'email_verified', true);

                        if ($is_email_verified === '1') {
                            // Email is confirmed, proceed with password check
                            if (!wp_check_password($password, $user->user_pass, $user->ID)) {
                                $this->errors['password'] = __('Incorrect password.', 'eco-profile-master');
                            }
                        } else {
                            // Email is not confirmed
                            $this->errors['username_or_email_confirmed'] = __('Your email is not confirmed. Please check your inbox for the confirmation email.', 'eco-profile-master');
                        }
                    }
                }
            }
        }
        $admin_approval_required = $this->isAdminApprovalRequired();
        if (!empty($username_or_email) && !empty($password)) {
            $user = $this->getUserByEmailOrLogin($username_or_email);

            if ($user) {
                $admin_approval_status = get_user_meta($user->ID, 'epm_admin_approval', true);

                if ($admin_approval_required && $admin_approval_status === 'unapproved') {
                    // Check the registration timestamp
                    $registration_timestamp = get_user_meta($user->ID, 'registration_timestamp', true);
                    $admin_approval_timestamp = get_option('admin_approval_confirmation_timestamp');

                    if ($registration_timestamp > $admin_approval_timestamp) {
                        // User is not approved, display an error message
                        $this->errors['admin_approval_error'] = __('Your account is pending admin approval.', 'eco-profile-master');
                    } else {
                        // Proceed with password check
                        if (!wp_check_password($password, $user->user_pass, $user->ID)) {
                            $this->errors['password'] = __('Incorrect password.', 'eco-profile-master');
                        }
                    }
                }
            }
        }

        return $this->errors;
    }

    /**
     * Check if admin approval is required based on the WordPress setting.
     *
     * @return bool True if admin approval is required, false if not.
     */
    private function isAdminApprovalRequired()
    {
        $admin_approval_setting =  sanitize_text_field(get_option('epm_admin_approval', 'no'));
        // Check if admin approval is required
        return $admin_approval_setting == 'yes';
    }

    /**
     * Check if a user has been approved by the admin.
     *
     * @param WP_User $user The user to check for admin approval.
     * @return bool True if the user is approved, false if not.
     */
    private function isAdminApproved($user)
    {
        // Check if the user's 'epm_admin_approval' is 'approved'
        $admin_approval_status = get_user_meta($user->ID, 'epm_admin_approval', true);
        return $admin_approval_status === 'approved';
    }

    /**
     * Get a user by email or username for login validation.
     *
     * @param string $username_or_email The username or email for the user.
     * @return WP_User|false WP_User object if found, false if not.
     */
    private function getUserByEmailOrLogin($username_or_email)
    {
        $user_by_email = get_user_by('email', $username_or_email);
        $user_by_login = get_user_by('login', $username_or_email);

        return $user_by_email ? $user_by_email : $user_by_login;
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
