<form method="post" action="">
    <input type="hidden" name="action" value="update_epm_display_admin_settings" />
    <?php wp_nonce_field('update_epm_display_admin_settings_nonce', 'update_epm_display_admin_settings_nonce'); ?>

    <table class="widefat">
        <!-- Add the rows for each user role -->
        <?php
        global $wp_roles;
        $admin_bar_settings = get_option('epm_display_admin_settings');

        foreach ($wp_roles->roles as $role) {
            $key = $role['name'];
            $setting_exists = !empty($admin_bar_settings[$key]);
            $default_value = ($setting_exists) ? $admin_bar_settings[$key] : 'default';

            echo '<tr>
                    <td>' . esc_html(translate_user_role($key)) . '</td>
                    <td>
                        <input type="radio" name="epm_display_admin_settings[' . esc_attr($key) . ']" value="default" ' . checked($default_value, 'default', false) . ' /> Default
                        <input type="radio" name="epm_display_admin_settings[' . esc_attr($key) . ']" value="show" ' . checked($default_value, 'show', false) . ' /> Show
                        <input type="radio" name="epm_display_admin_settings[' . esc_attr($key) . ']" value="hide" ' . checked($default_value, 'hide', false) . ' /> Hide
                    </td>
                </tr>';
        }
        ?>
    </table>

    <input type="submit" class="button-primary" value="Save Changes" />
</form>