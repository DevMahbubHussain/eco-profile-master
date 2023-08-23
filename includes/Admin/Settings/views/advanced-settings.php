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
                    <th><label for="epm_send_credentials"><?php _e('Send Credentials after registration', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_send_credentials" name="epm_send_credentials" value="1" <?php checked(get_option('epm_send_credentials'), 1); ?>>
                        <p class="epm-description"><?php _e('If checked users will get credentilas after registration via email.', 'eco-profile-master'); ?></p>
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

                <tr>
                    <th><label for="epm_facebook_url"><?php _e('Enable facebook field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_facebook_url" name="epm_facebook_url" value="1" <?php checked(get_option('epm_facebook_url', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, facebook field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_twitter_url"><?php _e('Enable twitter field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_twitter_url" name="epm_twitter_url" value="1" <?php checked(get_option('epm_twitter_url', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, twitter field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_linkedin_url"><?php _e('Enable linkedin field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_linkedin_url" name="epm_linkedin_url" value="1" <?php checked(get_option('epm_linkedin_url', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, linkedin field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_youtube_url"><?php _e('Enable youtube field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_youtube_url" name="epm_youtube_url" value="1" <?php checked(get_option('epm_youtube_url', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, youtube field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_instagram_url"><?php _e('Enable instagram field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_instagram_url" name="epm_instagram_url" value="1" <?php checked(get_option('epm_instagram_url', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, instagram field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_advanced_settings'); ?>
        </p>
    </form>
</div>