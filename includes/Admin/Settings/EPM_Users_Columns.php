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
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        if ($column_name === 'approval_status') {
            // Logic to get the approval status (approved, rejected, unapproved)
            $approval_status = get_user_meta($user_id, 'epm_admin_approval', true);
            // var_dump($approval_status);

            if ($approval_status === 'approved') {
                return __('Approved', 'eco-profile-master');
            } elseif ($approval_status === 'rejected') {
                return __('Rejected', 'eco-profile-master');
            } else {
                return __('Unapproved', 'eco-profile-master');
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
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
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
        error_log('approve_user() is being called.');
        if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
            wp_die('Invalid user ID');
        }
        $user_id = intval($_GET['user_id']);
        // Update user meta to mark as approved
        update_user_meta($user_id, 'epm_admin_approval', 'approved');

        //send an email to the user notifying them of approval
        $user = get_userdata($user_id);
        $subject = __('Account Approved', 'eco-profile-master');
        $message = __('Your account has been approved. You can now log in and access your account.', 'eco-profile-master');
        wp_mail($user->user_email, $subject, $message);
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
            wp_die('Invalid user ID');
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
            wp_die('Invalid user ID');
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
}
