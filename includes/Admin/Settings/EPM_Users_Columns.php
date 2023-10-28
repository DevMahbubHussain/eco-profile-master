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
        $login_url = home_url('/login');
        $username = $user->user_login;

        $subject = __('Account Approved', 'eco-profile-master');
        $message = '<html>
    <body>
        <p>' . __('Your account has been approved. You can now log in using the following credentials:', 'eco-profile-master') . '</p>
        <p><strong>' . __('Site URL:', 'eco-profile-master') . '</strong> ' . esc_html($site_url) . '</p>
        <p><strong>' . __('Username:', 'eco-profile-master') . '</strong> ' . esc_html($username) . '</p>
        <p><strong>' . __('Password:', 'eco-profile-master') . '</strong> ' . esc_html($new_password) . '</p>
        <p><a href="' . esc_url($login_url) . '" style="background-color:#0073aa; color:#fff; text-decoration:none; padding:10px 20px; border-radius:4px; display:inline-block;">' . __('Login Now', 'eco-profile-master') .
        '</a></p>
    </body>
</html>';

        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($user->user_email, $subject, $message, $headers);

        // Redirect back to the users page with the "approved" query parameter
        wp_redirect(admin_url('users.php?approved=1'));
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
        wp_redirect(admin_url('users.php?rejected=1'));
        exit;
    }
}
