<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;
use EcoProfile\Master\Traits\EPM_LoginTrait;
use WP_Error;

/**
 * Login Class
 *
 * Handles user login, password reset, and custom password reset on the front end.
 *
 * @package EcoProfile\Master\Frontend
 */
class Login
{
    use EPM_Form_ValidationTrait;
    use EPM_LoginTrait;
    private $username_or_email_error = '';
    private $password_error = '';

    /**
     * Class Constructor
     *
     * Initializes the Login class and sets up hooks and shortcodes for user login,
     * password reset, and custom password reset functionalities.
     */
    public function __construct()
    {
        add_shortcode('epm-login', array($this, 'epm_render_login_form'));
        add_action('template_redirect', array($this, 'epm_process_login'));
        add_shortcode('epm-pass-recover', array($this, 'epm_render_password_reset_form'));
        add_action('template_redirect', array($this, 'epm_process_reset_password'));
        add_shortcode('epm-password-reset-form', array($this, 'epm_redirect_to_custom_lostpassword'));
        add_action('template_redirect', array($this, 'epm_process_custom_lostpassword'));
    }

    /**
     * Render Login Form
     *
     * Generates and returns the HTML markup for the login form or displays a logged-in user message.
     *
     * @return string HTML markup for the login form or a logged-in user message.
     */

    public function epm_render_login_form()
    {
        ob_start();
        $this->epm_render_login_form_style();
        return ob_get_clean();
    }

    /**
     * Render Login Form Style
     *
     * Displays the login form or a logged-in user message depending on the user's status.
     *
     * @return void
     */

    private function epm_render_login_form_style()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('administrator', $current_user->roles)) {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in as %s. <a href="%s">Log out »</a>', 'eco-profile-master'), $current_user->display_name, wp_logout_url(home_url('/login'))) . '</p>';
            } else {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in. <a href="%s">Log out »</a>', 'eco-profile-master'), wp_logout_url(home_url('/login'))) . '</p>';
            }
        } else {
            require_once  __DIR__ . '/views/login/login_form.php';
        }
    }

    /**
     * Process User Login
     *
     * Validates and processes user login if the login form is submitted.
     *
     * @return void
     */

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
    /**
     * User Login
     *
     * Authenticates a user based on their provided credentials and logs them in.
     *
     * @param WP_User|WP_Error|null $user      User object if login is successful, WP_Error if unsuccessful.
     * @param string                $username  The username or email address for login.
     * @param string                $password  The user's password.
     *
     * @return WP_User|WP_Error|null The logged-in user or WP_Error in case of authentication failure.
     */
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

    /**
     * Render the Password Reset Form
     *
     * Generates and returns the HTML for the password reset form to be displayed.
     *
     * @return string HTML content of the password reset form.
     */

    public function epm_render_password_reset_form()
    {
        ob_start();
        $this->epm_render_password_reset_form_style();
        return ob_get_clean();
    }

    /**
     * Render the Password Reset Form Style
     *
     * Generates and displays the style and content of the password reset form, including logged-in user information
     * or the password reset form template.
     */

    private function epm_render_password_reset_form_style()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('administrator', $current_user->roles)) {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in as %s. <a href="%s">Log out »</a>', 'eco-profile-master'), $current_user->display_name, wp_logout_url(home_url('/login'))) . '</p>';
            } else {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in. <a href="%s">Log out »</a>', 'eco-profile-master'), wp_logout_url(home_url('/login'))) . '</p>';
            }
        } else {
            require_once  __DIR__ . '/views/login/password_reset_form.php';
        }
    }

    /**
     * Process Password Reset Request
     *
     * Handles the password reset request submitted by the user. Validates the request, generates a password
     * reset link, and sends a password reset email to the user if the request is valid.
     *
     * @return string Confirmation message about the password reset process.
     */

    public function epm_process_reset_password()
    {
        $confirmation_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['epm_password_reset'])) {
            // Validate nonce
            $this->validateNonce('epm_user_password_reset_nonce', 'epm_user_password_reset_action');
            $user_email = sanitize_email($_POST['epm_user_email']);
            $user = get_user_by('email', $user_email);
            $epm_new_pass_page = lcfirst(sanitize_text_field(get_option('epm_pass_reset_page', 'new-password-form')));
            $epm_pass_page = !empty($epm_new_pass_page) ? $epm_new_pass_page : 'wp-login.php?action=lostpassword';
            if ($user) {
                // $redirect_page = home_url('/pass');
                $token = wp_generate_password(32, false);
                update_user_meta($user->ID, 'password_reset_token', $token);
                $reset_link = home_url("/$epm_pass_page/?token=$token&reset_password=1");
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

        $confirmation_messages =  set_transient('password_reset_confirmation_messages', $confirmation_message, 1);
        return $confirmation_messages;
    }

    /**
     * Redirect to Custom Password Reset Form
     *
     * Redirects users to a custom password reset form. If the user is already logged in, it provides
     * the option to log out before accessing the reset form.
     *
     * @return string HTML content of the custom password reset form.
     */

    public function epm_redirect_to_custom_lostpassword()
    {

        ob_start();
        $this->epm_custom_password_reset_form();
        return ob_get_clean();
    }

    /**
     * Custom Password Reset Form
     *
     * Displays a custom password reset form. If the user is already logged in, it provides the option to log out
     * before accessing the custom reset form.
     *
     * @return void
     */

    private function epm_custom_password_reset_form()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('administrator', $current_user->roles)) {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in as %s. <a href="%s">Log out »</a>', 'eco-profile-master'), $current_user->display_name, wp_logout_url(home_url('/login'))) . '</p>';
            } else {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in. <a href="%s">Log out »</a>', 'eco-profile-master'), wp_logout_url(home_url('/login'))) . '</p>';
            }
        } else {
            require_once  __DIR__ . '/views/login/custom-password-reset-form.php';
        }
    }

    /**
     * Process Custom Lost Password Request
     *
     * Initiates the processing of a custom lost password request, including the validation
     * of the reset token and password update if required.
     *
     * @return void
     */

    public function epm_process_custom_lostpassword()
    {
        $this->epm_custom_password_reset_process();
    }

    /**
     * Process Custom Password Reset Request
     *
     * Handles the processing of a custom password reset request, including token validation
     * and, if necessary, updating the user's password. Additionally, it handles form submissions
     * for password reset.
     *
     * @return mixed|void Returns an error message in case of invalid or expired token,
     *                     false for invalid form submissions, or void for successful processing.
     */

    private function epm_custom_password_reset_process()
    {
        if (isset($_GET['reset_password']) && $_GET['reset_password'] === '1') {
            $token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
            $user = get_users(array('meta_key' => 'password_reset_token', 'meta_value' => $token));
            if ($user) {
                $this->epm_custom_password_reset_form_validation($user);
            } else {
                $error_token = __('Invalid or expired token.', 'eco-profile-master');
                $error_token =  set_transient('expired_token', $error_token, 1);
                return $error_token;
            }
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['epm_password_reset_form'])) {
                $new_password = sanitize_text_field($_POST['epm_user_password']);
                $confirm_password = sanitize_text_field($_POST['epm_user_confirm_password']);
                if ($this->validateResetForm($new_password, $confirm_password)) return false;
                $error_token = __('Invalid or expired token.', 'eco-profile-master');
                $error_token =  set_transient('expired_token', $error_token, 1);
                return $error_token;
            }
        }
    }

    /**
     * Validate and Process Custom Password Reset Form
     *
     * Validates and processes the custom password reset form submission, updating the user's
     * password and handling the associated user redirection after a successful password reset.
     *
     * @param WP_User[] $user An array of WordPress user objects.
     *
     * @return mixed|void Returns success message in case of a successful password reset,
     *                     void if validation fails, or void for successful processing.
     */

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
                custom_login_redirect();
                $password_reset_message = __('Password reset successful. You can now login with your new password.', 'eco-profile-master');
                $password_reset_messages =  set_transient('password_reset_success_messages', $password_reset_message, 1);
                return $password_reset_messages;
            }
        }
    } 
    
}
