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
        add_action('template_redirect', array($this, 'epm_process_login'));
        add_shortcode('epm-pass-recover', array($this, 'epm_render_password_reset_form'));
        add_action('template_redirect', array($this, 'epm_process_reset_password'));
        add_shortcode('custom-password-reset-form', array($this, 'epm_redirect_to_custom_lostpassword'));
        add_action('template_redirect', array($this, 'epm_process_custom_lostpassword'));
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
                $epm_profile_page = sanitize_text_field(get_option('epm_profile_page', 'Profile'));
                // redirect user to the dashboard or the profile page
                if (!empty($epm_profile_page)) {
                    wp_redirect(home_url("/$epm_profile_page"));
                } else {
                    wp_redirect(admin_url());
                }
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


    // password reset options 

    public function epm_render_password_reset_form()
    {
        ob_start();
        $this->epm_render_password_reset_form_style();
        //echo $this->epm_process_reset_password();
        return ob_get_clean();
    }

    private function epm_render_password_reset_form_style()
    {
        require_once  __DIR__ . '/views/login/password_reset_form.php';
    }


    /**
     * epm_process_reset_password function.
     *
     * @return void
     */
    public function epm_process_reset_password()
    {
        $confirmation_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['epm_password_reset'])) {
            // Validate nonce
            $this->validateNonce('epm_user_password_reset_nonce', 'epm_user_password_reset_action');
            $user_email = sanitize_email($_POST['epm_user_email']);
            $user = get_user_by('email', $user_email);
            if ($user) {
                // $redirect_page = home_url('/pass');
                $token = wp_generate_password(32, false);
                update_user_meta($user->ID, 'password_reset_token', $token);
                // $reset_link = home_url("/pass?token=$token");
                //$reset_link = add_query_arg(array('token' => $token, 'reset_password' => 1), home_url('/'));
                $reset_link = home_url("/pass?token=$token&reset_password=1");
                // Create the reset password button with translation support
                $reset_button_label = __('Reset Password', 'eco-profile-master');
                $reset_button_url = esc_url($reset_link);
                $reset_button = sprintf('<a href="%s" style="background-color: #0073e6; color: #ffffff; padding: 10px 20px; text-decoration: none; display: inline-block;">%s</a>', $reset_button_url, $reset_button_label);

                // Email subject and message
                $email_subject = __('Password Reset', 'eco-profile-master');
                $email_message = '<html><body>';
                $email_message .= '<p>' . __('Click the following button to reset your password:', 'eco-profile-master') . '</p>';
                $email_message .= '<p>' . $reset_button . '</p>';
                $email_message .= '</body></html>';

                // Headers for HTML email
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8',
                );

                // Send the HTML email
                $email_sent = wp_mail($user_email, $email_subject, $email_message, $headers);

                if ($email_sent) {
                    $confirmation_message = __('Password reset email sent. Check your inbox.', 'eco-profile-master');
                } else {
                    $confirmation_message = __('Failed to send the password reset email. Please try again later.', 'eco-profile-master');
                }
            } else {
                $confirmation_message = __('User not found.', 'eco-profile-master');
            }
        }

        // Get the existing confirmation messages or initialize an empty array
        // Store the updated array of confirmation messages in the transient
        $confirmation_messages =  set_transient('password_reset_confirmation_messages', $confirmation_message, 1);
        // Return the confirmation message
        return $confirmation_messages;
    }



    public function epm_redirect_to_custom_lostpassword()
    {

        ob_start();
        $this->epm_custom_password_reset_form();
        // echo $this->epm_custom_password_reset_process();
        return ob_get_clean();
    }

    private function epm_custom_password_reset_form()
    {
        require_once  __DIR__ . '/views/login/custom-password-reset-form.php';
    }

    public function epm_process_custom_lostpassword()
    {
        $this->epm_custom_password_reset_process();
    }

    private function epm_custom_password_reset_process()
    {
        if (isset($_GET['reset_password']) && $_GET['reset_password'] === '1') {
            $token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
            $user = get_users(array('meta_key' => 'password_reset_token', 'meta_value' => $token));
            if ($user) {
                $this->epm_custom_password_reset_form_validation($user);
            } else {
                echo 'Invalid or expired token.';
            }
        }
    }

    private function epm_custom_password_reset_form_validation($user)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['epm_password_reset_form'])) {
            $this->validateNonce('epm_user_new_password_reset_nonce', 'epm_user_new_password_reset_action');
            $new_password = sanitize_text_field($_POST['epm_user_password']);
            $confirm_password = sanitize_text_field($_POST['epm_user_confirm_password']);
            $errors = $this->validateResetForm($new_password, $confirm_password);
            if (empty($errors)) {
                $user_id = $user[0]->ID;
                wp_set_password($new_password, $user_id);
                delete_user_meta($user_id, 'password_reset_token');
                // redirect login page and set message with trainsent to shows in login page
                echo 'Password reset successful. You can now login with your new password.';
            }
        }
    }

 










    



   




}
