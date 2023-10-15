<div class="wrap">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('advanced_settings_nonce', 'advanced_settings_nonce'); ?>
        <table class="form-table epm-th">
            <tbody>
                <tr>
                    <th><label for="epm_user_gender"><?php _e('Enable gender field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_gender" name="epm_user_gender" value="1" <?php checked(get_option('epm_user_gender', '1'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, gender field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_user_birthdate"><?php _e('Enable birthdate field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_birthdate" name="epm_user_birthdate" value="1" <?php checked(get_option('epm_user_birthdate', '0'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, birthdate field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_user_occupation"><?php _e('Enable occupation field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_occupation" name="epm_user_occupation" value="1" <?php checked(get_option('epm_user_occupation', '0'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, occupation field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_user_religion"><?php _e('Enable religion field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_religion" name="epm_user_religion" value="1" <?php checked(get_option('epm_user_religion', '0'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, religion field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_user_skin_color"><?php _e('Enable skin color field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_skin_color" name="epm_user_skin_color" value="1" <?php checked(get_option('epm_user_skin_color', '0'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, skin color field will enable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_user_blood_group"><?php _e('Enable blood group field', 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_user_blood_group" name="epm_user_blood_group" value="1" <?php checked(get_option('epm_user_blood_group', '0'), 1); ?>>
                        <p class="epm-description"><?php _e('By checking this option, blood group field will enable.', 'eco-profile-master'); ?></p>
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