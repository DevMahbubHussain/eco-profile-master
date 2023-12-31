<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Labels_PlaceholdersTrait;
use EcoProfile\Master\Traits\EPM_Signup_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Social_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;
use EcoProfile\Master\Traits\EPM_UserAccountManagementTrait;
use EcoProfile\Master\Traits\EPM_MessageTrait;
use EcoProfile\Master\Traits\EPM_LoginTrait;

/**
 * Class Signup.
 *
 * Represents the Signup wrapper class responsible for managing user registration
 * and rendering the user activation signup form.
 */
class Signup
{
    //use EPM_AutoGeneratePasswordTrait;
    use EPM_Signup_FieldsTrait;
    use EPM_Labels_PlaceholdersTrait;
    use EPM_Social_FieldsTrait;
    use EPM_Form_ValidationTrait;
    use EPM_UserAccountManagementTrait;
    use EPM_MessageTrait;
    use EPM_LoginTrait;
    private $registrationSuccess = false;

    /**
     * Constructor.
     *
     * Initializes the Signup class and registers the shortcode for rendering
     * the user activation signup form.
     */
    public function __construct()
    {
        add_shortcode('epm-register', array($this, 'epm_render_activate_user_signup'));
        add_action('init', array($this, 'handle_confirmation_link'));
    }

    /**
     * Handle User Email Confirmation Link
     *
     * This method is responsible for processing the email confirmation link. It checks if the provided user ID and
     * confirmation key are valid, and if so, marks the user as verified, removes the confirmation key, and redirects
     * the user to the login page. Additionally, it triggers an email confirmation handler. If the verification fails,
     * it may redirect to an error page or display an error message to the user.
     */
    public function handle_confirmation_link()
    {
        if (isset($_GET['key']) && isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            $confirmation_key = sanitize_text_field($_GET['key']);

            if ($this->verify_confirmation_key($user_id, $confirmation_key)) {
                // Remove the verification key
                delete_user_meta($user_id, 'confirmation_key');
                // Mark the user as verified
                update_user_meta($user_id, 'email_verified', true);
                // Redirect the user to the login page
                custom_login_redirect();
                $this->EmailConfirmationHandler();
                exit;
            } else {
                // Redirect to an error page or display an error message
                $error_message = __('Email verification failed. Please try again.', 'eco-profile-master');
                set_transient('email_verification_error', $error_message, 60);
            }
        }
    }

    /**
     * Verify User Email Confirmation Key
     *
     * This method compares the provided confirmation key with the stored verification key for a user.
     *
     * @param int   $user_id  The ID of the user for whom confirmation is being verified.
     * @param string $confirmation_key  The confirmation key provided in the confirmation link.
     *
     * @return bool True if the provided confirmation key matches the stored key, indicating successful verification;
     *              otherwise, false.
     */

    private function verify_confirmation_key($user_id, $confirmation_key)
    {
        // Get the stored verification key for the user
        $stored_key = get_user_meta($user_id, 'confirmation_key', true);
        // Compare the provided key with the stored key
        if ($confirmation_key === $stored_key) {
            // Keys match
            return true;
        } else {
            // Keys don't match
            return false;
        }
    }

    /**
     * Get the Eco Profile Master Form Style
     *
     * Retrieve the selected form style for Eco Profile Master from the WordPress options.
     *
     * @return string The sanitized key representing the chosen form style, e.g., 'style1'.
     */

    public function get_epm_form_styles()
    {
        $epm_form_style = get_option('epm_form_style', 'style1');
        return sanitize_key($epm_form_style);
    }

    /**
     * Render the signup form shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Content inside the shortcode.
     * @return string Rendered HTML content of the signup form.
     */
    public function epm_render_activate_user_signup($atts, $content = '')
    {
        ob_start();
        $this->epm_render_form_based_on_style();
        echo $this->epm_handle_form_submission();
        return ob_get_clean();
    }

    /**
     * Renders a form based on the selected style.
     *
     * This function selects an appropriate rendering function based on the current
     * form style and invokes it to generate the HTML form markup. It supports multiple
     * styles and corresponding render functions for customization.
     *
     * @access private
     * @since 1.0.0
     * @return void
     */
    private function epm_render_form_based_on_style()
    {
        $epm_form_style =  $this->get_epm_form_styles();
        $epm_form_style_renderers = array(
            'style2' => 'render_epm_style2_form',
            'style3' => 'render_epm_style3_form',
            'style1' => 'render_epm_common_form',
        );
        // Add more styles and corresponding render functions as needed

        // Check if the form style exists in the array, else default to a common style
        $epm_form_renderer = isset($epm_form_style_renderers[$epm_form_style])
            ? $epm_form_style_renderers[$epm_form_style]
            : $epm_form_style_renderers['style1'];
        // Call the chosen rendering function
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if (in_array('administrator', $current_user->roles)) {
                echo '<p class="text-left">' . __('You are already logged in as a', 'echo-profile-master') . ' ' . $current_user->display_name . '</p>';
                $this->$epm_form_renderer();
            } else {
                echo '<p class="text-left">' . sprintf(__('You are currently logged in. <a href="%s">Log out »</a>', 'eco-profile-master'), wp_logout_url(home_url('/login'))) . '</p>';
            }
        } else {
            $this->$epm_form_renderer();
        }
    }

    /**
     * Renders the form using Style 2.
     *
     * This function includes the corresponding view file 'signup_form_style2.php'
     * to generate the HTML markup for the signup form using Style 2.
     *
     * @access private
     * @since 1.0.0
     * @return void
     */

    private function render_epm_style2_form()
    {
        include __DIR__ . '/views/signup_form_style2.php';
    }

    /**
     * Renders the form using Style 3.
     *
     * This function includes the corresponding view file 'signup_form_style3.php'
     * to generate the HTML markup for the signup form using Style 3.
     *
     * @access private
     * @since 1.0.0
     * @return void
     */
    private function render_epm_style3_form()
    {
        include __DIR__ . '/views/signup_form_style3.php';
    }

    /**
     * Renders the form using the common style.
     *
     * This function includes the corresponding view file 'signup_form.php'
     * to generate the HTML markup for the signup form using the common style.
     *
     * @access private
     * @since 1.0.0
     * @return void
     */
    private function render_epm_common_form()
    {
        include __DIR__ . '/views/signup_form.php';
    }

    /**
     * Handles form submission and processing.
     *
     * @since 1.0.0
     * @return void
     */
    public function epm_handle_form_submission()
    {
        $this->init_hook();
    }

    /**
     * Initialize Hook for User Registration
     *
     * This method serves as a hook initialization for user registration. It checks if a POST request with 'user_register'
     * is received and triggers the user registration process accordingly.
     */

    public function init_hook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_register'])) {
            $this->epm_process_signup();
        }
    }

    /**
     * Process User Signup
     *
     * This method handles the user registration process. It validates registration fields, creates a new user if validation
     * is successful, and triggers actions based on email confirmation, admin approval, and automatic login options.
     * Additionally, it handles security checks, sends emails, sets user roles, and redirects users as needed.
     */

    private function epm_process_signup()
    {

        if ($_POST['user_registration'] !== 'user_registration') {
            wp_die(__('Security check failed. Please try again.', 'eco-profile-master'));
        }
        $this->validateNonce('user_registration_nonce', 'user_registration_nonce');
        $validation_data = $_POST;
        $validation_result = $this->epm_validate_registration_fields($validation_data);
        add_filter('pre_option_users_can_register', '__return_true');
        if (empty($validation_result)) {
            $user_id = $this->create_user($validation_data);
            if ($user_id) {
                // Other actions like sending emails, logging in, etc.
                $this->set_user_role($user_id);
                $send_confirmation = sanitize_text_field(get_option('epm_email_confirmation_activated', 'no'));
                // Email Confirmation Options
                if ($send_confirmation === 'yes') {
                    $this->send_confirmation_email($user_id, $validation_data);
                    $this->add_message(__('Confirmation email sent. Please check your inbox.', 'eco-profile-master'));
                    return;
                }
                // Admin Approval Options
                $is_admin_approved = sanitize_text_field(get_option('epm_admin_approval', 'no'));
                if ($is_admin_approved === 'yes') {
                    $this->notify_admin_for_approval($user_id);
                    $this->add_message(__('Registration successful. Please wait for admin approval.', 'eco-profile-master'));
                    return;
                }
                // Check if automatic login is enabled
                $automatic_login_option = get_option('epm_automatically_login', 'no');

                if ($automatic_login_option === 'yes') {
                    if (!current_user_can('administrator')) {
                        $this->auto_login($user_id);
                    }
                } else {
                    // Redirect the user to the login page
                    if (!current_user_can('administrator')) {
                        custom_login_redirect();
                    }
                }
                if (current_user_can('administrator')) {
                    // Set a transient for the success message
                    set_transient('registration_success_message', 'User registration successful!', 10); // Transient expires after 10 seconds
                }
            }
        } 
    }

    /**
     * Display registration messages.
     * Delegates to the display_messages method to display messages.
     */
    
    public function display_registration_messages()
    {
        $this->display_messages();
    }

}
