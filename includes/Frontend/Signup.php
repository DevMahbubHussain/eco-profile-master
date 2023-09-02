<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Labels_PlaceholdersTrait;
use EcoProfile\Master\Traits\EPM_Signup_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Social_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;
use EcoProfile\Master\Traits\EPM_UserAccountManagementTrait;
use EcoProfile\Master\Traits\EPM_MessageTrait;

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
    

    // use EPM_So
    private $registrationSuccess = false;

    /**
     * Constructor.
     *
     * Initializes the Signup class and registers the shortcode for rendering
     * the user activation signup form.
     */
    public function __construct()
    {
        //  add_action('init', array($this, 'init'));
        add_shortcode('epm-register', array($this, 'epm_render_activate_user_signup'));
        add_action('init', array($this, 'handle_confirmation_link'));
    }

    public function handle_confirmation_link()
    {
        if (isset($_GET['key'])) {
            $user_id = intval($_GET['user_id']);
            $confirmation_key = sanitize_text_field($_GET['key']);

            if ($this->verify_confirmation_key($user_id, $confirmation_key)) {

                // $is_user_approved_by_admin = get_option('your_plugin_user_approved', true);

                // if ($is_user_approved_by_admin &&  $this->is_user_approved($user_id)) {
                //     // Check if auto-login is enabled from admin panel
                //     $auto_login_enabled = get_option('your_plugin_auto_login', true);
                //     if ($auto_login_enabled) {
                //         // Auto-login the user
                //         $this->auto_login($user_id);
                //     }
                // } else {
                //     // do others 
                //     // wait for admin approval 
                //     // Optionally, notify admin about successful confirmation
                //     $this->notify_admin_confirmation($user_id);
                // }
                update_user_meta($user_id, 'email_verified', true);
                delete_user_meta($user_id, 'confirmation_key');
                wp_redirect(home_url('/auto-draft/'));
                echo "Verification done";
                exit;
            } else {
                // Redirect to an error page
                // wp_redirect(home_url('/confirmation-error'));
                // exit;
                echo 'Email verification failed. Please try again.';
            }
        }
    }

    private function verify_confirmation_key($user_id, $key)
    {
        // Get the stored verification key for the user
        $stored_key = get_user_meta($user_id, 'confirmation_key', true);

        // Compare the provided key with the stored key
        if ($key === $stored_key) {
            // Remove the verification key
            delete_user_meta($user_id, 'confirmation_key');
            return true;
        } else {
            // Keys don't match
            return false;
            echo 'Email verification failed. Please try again.';
        }
    }
    

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
        echo $this->epm_handle_form_submission(); // Call the form processing function here
        error_log('can called 2 times?Debug message: This is a test. EPM TRAIT METHODS ');
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
        $this->$epm_form_renderer();
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

    public function init_hook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_register'])) {
            $this->epm_process_signup();
        }
    }

    /**
     * Signup Process function
     *
     * @return void
     */
    private function epm_process_signup()
    {

        // Validate user capability
        // $this->validateUserCapability();

        if ($_POST['user_registration'] !== 'user_registration') {
            wp_die(__('Security check failed. Please try again.', 'eco-profile-master'));
        }
        // Verify nonce field value
        $this->validateNonce('user_registration_nonce', 'user_registration_nonce');
        $validation_data = $_POST;
        $validation_result = $this->epm_validate_registration_fields($validation_data);
        add_filter('pre_option_users_can_register', '__return_true');
        if (empty($validation_result)) {
            $user_id = $this->create_user($validation_data);
            if ($user_id) {
                 // Other actions like sending emails, logging in, etc.
                $this->set_user_role($user_id);
                $send_confirmation = get_option('epm_email_confirmation_activated', 'no');
                // var_dump($send_confirmation);
                //  $is_admin_aproved = get_option('your_plugin_send_confirmation', true);

                if ($send_confirmation === 'yes') {
                    $this->send_confirmation_email($user_id, $validation_data);
                    $this->notify_admin_for_approval($user_id);
                    error_log('Confirmation email sent.');
                    $this->add_message(__('Confirmation email sent. Please check your inbox.', 'eco-profile-master'));
                } else {
                    $this->add_message(__('Registration successful. Please wait for admin approval.', 'eco-profile-master'));
                }

                // next check 
                // if ($is_admin_aproved) {
                //     $this->notify_admin_for_approval($user_id, $validation_data);
                //     $this->add_message(__('Registration successful. Please wait for admin approval.', 'eco-profile-master'));
                // }

                // Check if automatic login is enabled
                // $auto_login_enabled = get_option('your_plugin_auto_login', true);
                // if ($auto_login_enabled) {
                //     // Auto-login the user
                //     $this->auto_login($user_id);
                //     // Redirect to user's profile or dashboard
                //     wp_redirect(home_url('/user-profile'));
                //     exit();
                // } else {
                //     // Display login form
                //     wp_redirect(home_url('/login'));
                //     exit();
                // }
            }
        } else {
            // Handle validation errors
        }

        // return ob_get_clean();
    }

    public function display_registration_messages()
    {
        $this->display_messages();
    }
}
