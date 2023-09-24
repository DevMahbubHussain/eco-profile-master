<?php

namespace EcoProfile\Master\Traits;

trait EPM_LoginTrait
{
    public $errors = array();

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

        // $approval_status = get_user_meta($user->ID, 'epm_admin_approval', true);
        // if ($approval_status !== 'approved') {
        //     $this->errors['approval_status'] = __('Your account is pending admin approval. Please wait for approval.', 'eco-profile-master');
        // }

        return $this->errors;
    }

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

    public function login_has_error($key)
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
    public function login_get_error($key)
    {
        if (isset($this->errors[$key])) {
            return $this->errors[$key];
        }

        return false;
    }


    // public function EmailConfirmationHandler()
    // {

    //     $is_admin_approved = sanitize_text_field(get_option('epm_admin_approval', 'no'));

    //     if ($is_admin_approved === 'yes') {
    //         // Display a message and redirect for admin approval
    //         return __('Your email has been confirmed. Please wait for admin approval.', 'eco-profile-master');
    //         // $this->redirectToWaitingPage();
    //     } else {
    //         // Display a message and provide a login link
    //         return __('Your email has been confirmed. You can now <a href="' . home_url('/login') . '">log in</a>.', 'eco-profile-master');
    //     }
    // }

    public function EmailConfirmationHandler()
    {
        $is_admin_approved = sanitize_text_field(get_option('epm_admin_approval', 'no'));
        $confirmation_message = '';

        if ($is_admin_approved === 'yes') {
            // Display a message and redirect for admin approval
            $confirmation_message = __('Your email has been confirmed. Please wait for admin approval.', 'eco-profile-master');
        } else {
            // Display a message and provide a login link
            $confirmation_message = __('Your email has been confirmed. You can now <a href="' . home_url('/login') . '">log in</a>.', 'eco-profile-master');
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



    // private function validateConfirmationKey($user_id, $key)
    // {
    //     // Get the stored confirmation key for the user
    //     $stored_key = get_user_meta($user_id, 'confirmation_key', true);

    //     // Check if the provided key matches the stored key
    //     if ($key === $stored_key) {
    //         // Valid confirmation key
    //         return true;
    //     } else {
    //         // Invalid confirmation key
    //         return false;
    //     }
    // }
