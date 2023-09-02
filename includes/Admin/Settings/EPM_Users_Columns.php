<?php

namespace EcoProfile\Master\Admin\Settings;

class EPM_Users_Columns
{
    public function __construct()
    {
        add_filter('manage_users_columns', array($this, 'add_custom_user_columns'));
        add_filter('manage_users_custom_column', array($this, 'populate_custom_user_column'), 10, 3);
        add_filter('user_row_actions', array($this, 'add_user_action_links'), 10, 2);
        add_action('admin_post_approve_user', array($this, 'approve_user'));
        add_action('admin_post_reject_user', array($this, 'reject_user'));
        add_action('admin_post_unapprove_user', array($this, 'unapprove_user'));
        add_action('init', array($this, 'init_custom_login_redirect'));      
    }

    // user custom columns for approval options 

    /**
     * Add Custom Columns.
     *
     * @param [type] $columns
     * @return void
     */
    public function add_custom_user_columns($columns)
    {
        $columns['approval_status'] = 'Approval Status';
        return $columns;
    }

    /**
     * Populate Custom Columns.
     *
     * @param [type] $output
     * @param [type] $column_name
     * @param [type] $user_id
     * @return void
     */
    public function populate_custom_user_column($output, $column_name, $user_id)
    {
        $user = get_userdata($user_id);

        // Check if the user has the 'subscriber' role
        if (in_array('subscriber', $user->roles, true)) {
            if ($column_name === 'approval_status') {
                // Logic to get the approval status (approved, rejected, unapproved)
                $approval_status = get_user_meta($user_id, 'epm_admin_approval', true);

                if ($approval_status === 'approved') {
                    return __('Approved', 'eco-profile-master');
                } elseif ($approval_status === 'rejected') {
                    return __('Rejected', 'eco-profile-master');
                } else {
                    return __('Unapproved', 'eco-profile-master');
                }
            }
        }

        return $output;
    }

    /**
     * Add Action Links.
     *
     * @param [type] $actions
     * @param [type] $user
     * @return void
     */
    public function add_user_action_links($actions, $user)
    {
        if (current_user_can('edit_users')) {
            $approval_status = get_user_meta($user->ID, 'epm_admin_approval', true);

            if ($approval_status === 'unapproved') {
                $actions['approved'] = '<a href="' . admin_url("admin-post.php?action=approve_user&user_id={$user->ID}") . '">' . __('Approve', 'eco-profile-master') . '</a>';
                $actions['reject'] = '<a href="' . admin_url("admin-post.php?action=reject_user&user_id={$user->ID}") . '">' . __('Reject', 'eco-profile-master') . '</a>';
            } elseif ($approval_status === 'approved') {
                $actions['unapproved'] = '<a href="' . admin_url("admin-post.php?action=unapprove_user&user_id={$user->ID}") . '">' . __('Unapprove', 'eco-profile-master') . '</a>';
            }
        }

        return $actions;
    }

    /**
     * User Approved function.
     *
     * @return void
     */
    public function approve_user()
    {
        if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
            wp_die(__('Invalid user ID', 'eco-profile-master'));
        }

        $user_id = intval($_GET['user_id']);

        // Update user meta to mark as approved
        update_user_meta($user_id, 'epm_admin_approval', 'approved');

        // Get user data
        $user = get_userdata($user_id);

        // Generate a random password
        $new_password = wp_generate_password(12);

        // Update user's password
        wp_set_password($new_password, $user_id);

        // Send an HTML email to the user with login information
        $site_url = get_site_url();
        $login_url = wp_login_url();
        $username = $user->user_login;

        $subject = __('Account Approved', 'eco-profile-master');
        $message = sprintf(
            '<html>
            <body>
                <p>Your account has been approved. You can now log in using the following credentials:</p>
                <p><strong>Site URL:</strong> %s</p>
                <p><strong>Login Page:</strong> %s</p>
                <p><strong>Username:</strong> %s</p>
                <p><strong>Password:</strong> %s</p>
            </body>
            </html>',
            $site_url,
            $login_url,
            $username,
            $new_password
        );

        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($user->user_email, $subject, $message, $headers);

        // Redirect back to the users page
        wp_redirect(admin_url('users.php'));
        exit;
    }

    /**
     *  User Reject function.
     *
     * @return void
     */
    public function reject_user()
    {
        if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
            wp_die(__('Invalid user ID', 'eco-profile-master'));
        }

        $user_id = intval($_GET['user_id']);

        // Update user meta to mark as rejected
        update_user_meta($user_id, 'epm_admin_approval', 'rejected');

        //send an email to the user notifying them of rejection
        $user = get_userdata($user_id);
        $subject = __('Account Rejected', 'eco-profile-master');
        $message = __('Your account registration has been rejected.', 'eco-profile-master');
        wp_mail($user->user_email, $subject, $message);

        // Redirect back to the users page
        wp_redirect(admin_url('users.php'));
        exit;
    }

    /**
     * User Unapproved function.
     *
     * @return void
     */
    public function unapprove_user()
    {
        // Check if the user ID is provided in the query parameter
        if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
            wp_die(__('Invalid user ID', 'eco-profile-master'));
        }

        $user_id = intval($_GET['user_id']);
        // Update user meta to mark as unapproved
        update_user_meta($user_id, 'epm_admin_approval', 'unapproved');

        // send an email to the user notifying them of unapproval
        $user = get_userdata($user_id);
        $subject = __('Account Unapproved', 'eco-profile-master');
        $message = __('Your account registration has been marked as unapproved.', 'eco-profile-master');
        wp_mail($user->user_email, $subject, $message);

        // Redirect back to the users page
        wp_redirect(admin_url('users.php'));
        exit;
    }


    /**
     * Initializes custom login redirection for subscribers.
     *
     * Checks if a user is logged in and has the role of 'subscriber.'
     * If so, it can be used to redirect subscribers to a custom dashboard page.
     */

    public function init_custom_login_redirect()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();

            // Check if the user is logged in and has a role of 'subscriber'
            if (in_array('subscriber', $current_user->roles)) {
                // $redirect_url = home_url('/custom-dashboard'); // Change 'custom-dashboard' to your actual dashboard page slug
                //wp_safe_redirect($redirect_url);
                // exit;
                //    later will work 
            }
        }
    }
}
