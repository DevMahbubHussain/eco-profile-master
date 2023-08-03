<?php

/**
 * Eco Profile Master All functions
 *
 * @package eco-profile-master-functions
 */

/**
 * Admin general settings form handeler function.
 *
 * @return void
 */
function epm_general_settings_form_submission()
{
    if ($_POST['updated'] === 'true') {
        if (!isset($_POST['epm_general_settings'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['general_settings_nonce'], 'general_settings_action')) {
            wp_die('Not allow');
        }
        if (!current_user_can('manage_options')) {
            wp_die('Not allow');
        }
        $epm_automatically_login = isset($_POST['epm_automatically_login']) ? sanitize_text_field($_POST['epm_automatically_login']) : '';
        $epm_email_confirmation_activated = isset($_POST['epm_email_confirmation_activated']) ? sanitize_text_field($_POST['epm_email_confirmation_activated']) : '';
        $epm_roles_editor_activated = isset($_POST['epm_roles_editor_activated']) ? sanitize_text_field($_POST['epm_roles_editor_activated']) : '';
        $epm_admin_approval = isset($_POST['epm_admin_approval']) ? sanitize_text_field($_POST['epm_admin_approval']) : '';
        $epm_loginwith = isset($_POST['epm_loginwith']) ? sanitize_text_field($_POST['epm_loginwith']) : '';
        $epm_lost_password_page = isset($_POST['epm_lost_password_page']) ? sanitize_text_field($_POST['epm_lost_password_page']) : '';
        update_option('epm_automatically_login', $epm_automatically_login);
        update_option('epm_email_confirmation_activated', $epm_email_confirmation_activated);
        update_option('epm_roles_editor_activated', $epm_roles_editor_activated);
        update_option('epm_admin_approval', $epm_admin_approval);
        update_option('epm_loginwith',  $epm_loginwith);
        update_option('epm_lost_password_page', $epm_lost_password_page);
        epm_success_message();
    }
}

/**
 * Success Message function.
 *
 * @return void
 */
function epm_success_message()
{

    // $redirected_to = admin_url('admin.php?page=eco-profile-master-settings');
    // wp_redirect($redirected_to);
?>
    <div class="updated">
        <p><?php _e('Your fields were saved!', 'eco-profile-master'); ?></p>
    </div>
    <?php
}


/**
 * Get all the pages
 *
 * @return array page names with key value pairs
 */
function epm_get_my_pages()
{
    $pages = get_pages();
    $pages_options = array();
    if ($pages) {
        foreach ($pages as $page) {
            $pages_options[$page->ID] = $page->post_title;
        }
    }

    return $pages_options;
}

function epm_get_general_settings_active_page()
{

    $epm_pages = epm_get_my_pages();

    foreach ($epm_pages as $page) {
    ?>
        <option value="<?php echo esc_attr($page); ?>" <?php
                                                        null == !(get_option('epm_lost_password_page')) ? selected($page, get_option('epm_lost_password_page'), true) : ''
                                                        ?>>
            <?php echo esc_html(ucfirst($page)); ?>
        </option>
<?php
    }
}





?>