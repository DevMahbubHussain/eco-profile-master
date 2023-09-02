<div class="wrap epm-wrap epm-admin-bar">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="update_epm_display_admin_settings" />
        <?php wp_nonce_field('update_epm_display_admin_settings_nonce', 'update_epm_display_admin_settings_nonce'); ?>
        <p class="description"><?php esc_html_e('Choose which user roles view the admin bar in the front-end of the website.', 'eco-profile-master'); ?>
        <table class="widefat epm-label">
            <thead>
                <tr>
                    <th class="row-title" scope="col"><?php esc_html_e('User-Role', 'eco-profile-master'); ?></th>
                    <th scope="col"><?php esc_html_e('Visibility', 'eco-profile-master'); ?></th>
                </tr>
            </thead>
            <?php
            global $wp_roles;
            $admin_bar_settings = get_option('epm_display_admin_settings');

            foreach ($wp_roles->roles as $role) {
                $key =  strtolower($role['name']);
                $setting_exists = !empty($admin_bar_settings[$key]);
                $default_value = ($setting_exists) ? $admin_bar_settings[$key] : 'default';

                echo '<tr>
                    <td>' . esc_html(translate_user_role($key)) . '</td>
                    <td>';

                // Translatable labels
                $labels = array(
                    'default' => esc_html__('Default', 'eco-profile-master'),
                    'show' => esc_html__('Show', 'eco-profile-master'),
                    'hide' => esc_html__('Hide', 'eco-profile-master'),
                );

                foreach ($labels as $value => $label) {
                    echo '<label>
                        <input type="radio" name="epm_display_admin_settings[' . esc_attr($key) . ']" value="' . esc_attr($value) . '" ' . checked($default_value, $value, false) . ' /> ' . $label . '
                      </label> ';
                }

                echo '</td>
                </tr>';
            }
            ?>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_admin_bar'); ?>
        </p>
    </form>
</div>