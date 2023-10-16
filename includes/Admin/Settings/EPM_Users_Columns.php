<?php

namespace EcoProfile\Master\Admin\Settings;

class EPM_Users_Columns
{
    /**
     * Constructor.
     * Hooks into various WordPress actions and filters for managing custom user columns and actions.
     */
    public function __construct()
    {
        // Add custom columns to the user list table
        add_filter('manage_users_columns', array($this, 'add_custom_user_columns'));

        // Populate custom columns with data
        add_filter('manage_users_custom_column', array($this, 'populate_custom_user_column'), 10, 3);

        // Add custom user action links
        add_filter('user_row_actions', array($this, 'add_user_action_links'), 10, 2);

        // Define actions for approving, rejecting, and unapproving users
        add_action('admin_post_approve_user', array($this, 'approve_user'));
        add_action('admin_post_reject_user', array($this, 'reject_user'));
        add_action('admin_post_unapprove_user', array($this, 'unapprove_user'));
    }

    /**
     * Add Custom Columns.
     *
     * @param array $columns The array of columns in the user list table.
     * @return array The updated array of columns with custom columns.
     */
    public function add_custom_user_columns($columns)
    {
        $columns['approval_status'] = 'Approval Status';
        return $columns;
    }

    /**
     * Populate Custom Columns.
     *
     * @param string $output The output content for the custom column.
     * @param string $column_name The name of the custom column.
     * @param int $user_id The ID of the user being displayed.
     * @return string The updated output content for the custom column.
     */
    public function populate_custom_user_column($output, $column_name, $user_id)
    {
        // Get user data based on user ID
        $user = get_userdata($user_id);

        // Check if the user has the 'subscriber' role and admin approval is enabled
        $admin_approval = sanitize_text_field(get_option('epm_admin_approval', 'no'));
        if (in_array('subscriber', $user->roles, true) && $admin_approval == 'yes') {
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
     * @param array $actions The array of user action links.
     * @param WP_User $user The user object.
     * @return array The updated array of user action links.
     */
    public function add_user_action_links($actions, $user)
    {
        // Get the admin approval setting
        $admin_approval = sanitize_text_field(get_option('epm_admin_approval', 'no'));

        if ($admin_approval === 'yes') {
            // Check if the current user can edit users
            if (current_user_can('edit_users')) {
                // Get the user's approval status
                $approval_status = get_user_meta($user->ID, 'epm_admin_approval', true);

                if ($approval_status === 'unapproved') {
                    // If user is unapproved, show approve and reject links
                    $actions['approved'] = '<a href="' . esc_url(admin_url("admin-post.php?action=approve_user&user_id={$user->ID}")) . '">' . __('Approve', 'eco-profile-master') . '</a>';
                    $actions['reject'] = '<a href="' . esc_url(admin_url("admin-post.php?action=reject_user&user_id={$user->ID}")) . '">' . __('Reject', 'eco-profile-master') . '</a>';
                } elseif ($approval_status === 'approved') {
                    // If user is approved, show unapprove link
                    $actions['unapproved'] = '<a href="' . esc_url(admin_url("admin-post.php?action=unapprove_user&user_id={$user->ID}")) . '">' . __('Unapprove', 'eco-profile-master') . '</a>';
                }
            }
        }

        return $actions;
    }

    // Methods for user approval, rejection, and unapproval actions...
}
