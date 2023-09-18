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
}
