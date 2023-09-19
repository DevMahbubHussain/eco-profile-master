<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;
use EcoProfile\Master\Traits\EPM_LoginTrait;
use WP_Error;

class Login
{
    use EPM_Form_ValidationTrait;
    use EPM_LoginTrait;
    private $username_or_email_error = '';
    private $password_error = '';
    public function __construct()
    {
        add_shortcode('epm-login', array($this, 'epm_render_login_form'));
        add_action('init', array($this, 'epm_process_login'));
    }
    
    public function epm_render_login_form()
    {
        ob_start();
        $this->epm_render_login_form_style();
        return ob_get_clean();
    }


    private function epm_render_login_form_style()
    {
        require_once  __DIR__ . '/views/login/login_form.php';
    }

    public function epm_process_login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['epm_login'])) {
            $this->validateNonce('epm_user_login_nonce', 'epm_user_login_nonce');
            $username_or_email = sanitize_user($_POST['username_or_email']);
            $password = $_POST['epm_user_password'];
            $errors = $this->validateLoginForm($username_or_email, $password);
            if (empty($errors)) {
                $this->epm_user_login(null, $username_or_email, $password);

                // redirect user dashboard page
                wp_redirect(admin_url());
                exit;
            }
        }
    }

    private function epm_user_login($user, $username, $password)
    {
        if (is_email($username)) {
            $user = get_user_by('email', $username);
            if (!$user) {
                return new WP_Error('invalid_email', __('Invalid email address.'));
            }

            $username = $user->user_login;
        }
        $credentials = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => true
        );
        $user = wp_signon($credentials);

        if (is_wp_error($user)) {
            return $user;
        } else {
            return $user;
        }
    }
}
