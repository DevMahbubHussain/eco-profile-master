<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_Labels_PlaceholdersTrait;
use EcoProfile\Master\Traits\EPM_Signup_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Social_FieldsTrait;
use EcoProfile\Master\Traits\EPM_Form_ValidationTrait;
use EcoProfile\Master\Traits\EPM_UserAccountManagementTrait;

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

        // Validate form fields and get errors

        $validation_data = $_POST;
        // var_dump($validation_data);
        // exit();
        // $errors = $this->epm_validate_registration_fields($validation_data);
        $validation_result = $this->epm_validate_registration_fields($validation_data);
        // var_dump($validation_result);
        //var_dump($validation_result);
        add_filter('pre_option_users_can_register', '__return_true');
        if (empty($validation_result)) {
            $user_id = $this->create_user($validation_data);
            // var_dump($user_id);
            if ($user_id) {
                // echo "success";
                // // Other actions like sending emails, logging in, etc.
                $this->set_user_role($user_id);
                // $this->registrationSuccess = true;
                echo 'User registration successful!';
            } else {
                // echo '<p class="error">' . esc_html($user_id['error']) . '</p>';
                // echo "error";

                echo 'User registration failed. Please try again.';
            }
        } else {
            // Handle validation errors
        }


        // else {
        //     // Display error messages
        //     foreach ($errors as $error) {
        //         echo '<p>' . esc_html($error) . '</p>';
        //     }
        // }


        // print_r($_POST);
        // exit();




        // return ob_get_clean();
    }
}
