<div class="wrap">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('advanced_settings_nonce', 'advanced_settings_nonce'); ?>
        <table class="form-table epm-th">
            <tbody>
                <tr>
                    <th><label for="epm_email_confirmation"><?php _e('Email confirmation when changing user email', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_email_confirmation" name="epm_email_confirmation" value="1" <?php checked(get_option('epm_email_confirmation'), 1); ?>>
                        <p class="epm-description"><?php _e('If checked, an activation email is sent for the new email address.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_remember_me"><?php _e('Remember me checked by default', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_remember_me" name="epm_remember_me" value="1" <?php checked(get_option('epm_remember_me'), 1); ?>>
                        <p class="epm-description"><?php _e('Check the Remember Me checkbox on Login forms, by default.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_auto_login_pass_reset"><?php _e('Automatically log in users after password reset', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_auto_login_pass_reset" name="epm_auto_login_pass_reset" value="1" <?php checked(get_option('epm_auto_login_pass_reset'), 1); ?>>
                        <p class="epm-description"><?php _e('Automatically log in users after they reset their password using the Recover Password form, by default.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_auto_generate_pass"><?php _e('Automatically generate password for users', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_auto_generate_pass" name="epm_auto_generate_pass" value="1" <?php checked(get_option('epm_auto_generate_pass'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, the password will be automatically generated and emailed to the user.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_first_lastname_captitilize"><?php _e("Always capitalize 'First Name' and 'Last Name' default fields", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_first_lastname_captitilize" name="epm_first_lastname_captitilize" value="1" <?php checked(get_option('epm_first_lastname_captitilize'), 1); ?>>
                        <p class="epm-description"><?php _e('If you have these fields in your forms, they will be always saved with the first letter as uppercase.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_advanced_settings'); ?>
        </p>
    </form>
</div>