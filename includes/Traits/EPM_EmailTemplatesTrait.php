<?php

namespace EcoProfile\Master\Traits;

/**
 * Trait EmailTemplatesTrait
 *
 * A trait for generating email templates used in the registration process.
 *
 */
trait EPM_EmailTemplatesTrait
{
    public function generate_confirmation_email($user)
    {
        //$confirmation_key = get_user_meta($user->ID, 'confirmation_key', true);
       // var_dump($confirmation_key);
        // Create the HTML content for the confirmation email
        //$user = get_user_by('ID', $user_id);
        $site_name = get_bloginfo('name');
        $subject = __('Account Confirmation', 'eco-profile-master');
        $message = '<html>';
        $message .= '<body>';
        $message .= sprintf(
            __('Hello %s,', 'eco-profile-master'),
            $user->display_name
        ) . '<br><br>';
        $message .= sprintf(
            __('Click the following link to confirm your account on %s:', 'eco-profile-master'),
            $site_name
        ) . '<br><br>';
        $confirmation_key = get_user_meta($user->ID, 'confirmation_key', true);
        $verification_link = add_query_arg(
            array('key' => $confirmation_key, 'user_id' => $user->ID),
            home_url('/login')
           
        );
        $message .= '<a href="' . esc_url($verification_link) . '">' . __('Confirm Account', 'eco-profile-master') . '</a><br><br>';
        $message .= __('If you did not request this, please disregard this email.', 'eco-profile-master') . '<br><br>';
        $message .= '</body>';
        $message .= '</html>';

        // Set headers for HTML email
        $headers = array('Content-Type: text/html; charset=UTF-8');

        return array(
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers
        );
    }

    public function admin_confirmation_email($user_id)
    {
        // Get the new user's data
        $user = get_user_by('ID', $user_id);

        // Email subject
        $subject = __('New User Registration Requires Approval', 'eco-profile-master');

        // Email message
        $message = sprintf(
            __('<p>A new user has registered and requires approval:</p>', 'eco-profile-master')
        );

        $message .= '<ul>';
        $message .= sprintf(
            __('<li><strong>Username:</strong> %s</li>', 'eco-profile-master'),
            $user->user_login
        );
        $message .= sprintf(
            __('<li><strong>Email:</strong> %s</li>', 'eco-profile-master'),
            $user->user_email
        );
        $message .= sprintf(
            __('<li><strong>Name:</strong> %s %s</li>', 'eco-profile-master'),
            $user->first_name,
            $user->last_name
        );
        $message .= '</ul>';

        // Set headers for HTML email
        $headers = array('Content-Type: text/html; charset=UTF-8');

        return array(
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers
        );
    }
}
