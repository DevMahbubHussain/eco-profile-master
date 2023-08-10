<?php

namespace EcoProfile\Master\Frontend;

use EcoProfile\Master\Traits\EPM_AutoGeneratePasswordTrait;



/**
 * Class Signup.
 *
 * Represents the Signup wrapper class responsible for managing user registration
 * and rendering the user activation signup form.
 */
class Signup
{
    use EPM_AutoGeneratePasswordTrait;


    /**
     * Constructor.
     *
     * Initializes the Signup class and registers the shortcode for rendering
     * the user activation signup form.
     */
    public function __construct()
    {
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
        $this->epm_process_signup();
    }

    /**
     * Signup Process function
     *
     * @return void
     */
    private function epm_process_signup()
    {
        ob_start();
        epm_activate_user_signup(); // calling 
        return ob_get_clean();
    }
}
