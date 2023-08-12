<div class="wrap">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('form_fields_settings_nonce', 'form_fields_settings_nonce'); ?>
        <table class="form-table epm-th">
            <tbody>
                <tr>
                    <th><label for="epm_form_heading_name"><?php _e("Modify Form Heading 'Name'", 'eco-profile-master'); ?></label></th>
                    <td><input type="text" class="regular-text" id="epm_form_heading_name" name="epm_form_heading_name" value="<?php echo esc_attr(sanitize_text_field(get_option('epm_form_heading_name', 'Name')) ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_name_hide"><?php _e("Checked Form Heading 'Name' ", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_form_heading_name_hide" name="epm_form_heading_name_hide" value="1" <?php checked(get_option('epm_form_heading_name_hide', '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                        <p class="epm-description"><?php _e('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th><label for="epm_form_heading_contact_info"><?php _e("Modify Form Heading 'Contact Info'", 'eco-profile-master'); ?></label></th>
                    <td><input type="text" class="regular-text" id="epm_form_heading_contact_info" name="epm_form_heading_contact_info" value="<?php echo esc_attr(sanitize_text_field(get_option('epm_form_heading_contact_info', 'Contact Info')) ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_contact_info_hide"><?php _e("Checked Form Heading 'Contact Info' ", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_form_heading_contact_info_hide" name="epm_form_heading_contact_info_hide" value="1" <?php checked(get_option('epm_form_heading_contact_info_hide', '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                        <p class="epm-description"><?php _e('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th><label for="epm_form_heading_about_yourself"><?php _e("Modify Form Heading 'About Yourself'", 'eco-profile-master'); ?></label></th>
                    <td><input type="text" class="regular-text" id="epm_form_heading_about_yourself" name="epm_form_heading_about_yourself" value="<?php echo esc_attr(sanitize_text_field(get_option('epm_form_heading_about_yourself', 'About Yourself')) ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_about_yourself_hide"><?php _e("Checked Form Heading 'About Yourself' ", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_form_heading_about_yourself_hide" name="epm_form_heading_about_yourself_hide" value="1" <?php checked(get_option('epm_form_heading_about_yourself_hide', '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                        <p class="epm-description"><?php _e('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_profile_image"><?php _e("Modify Form Heading 'Profile Image'", 'eco-profile-master'); ?></label></th>
                    <td><input type="text" class="regular-text" id="epm_form_heading_profile_image" name="epm_form_heading_profile_image" value="<?php echo esc_attr(sanitize_text_field(get_option('epm_form_heading_profile_image', 'Profile Image')) ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_profile_image_hide"><?php _e("Checked Form Heading 'Profile Image' ", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_form_heading_profile_image_hide" name="epm_form_heading_profile_image_hide" value="1" <?php checked(get_option('epm_form_heading_profile_image_hide', '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                        <p class="epm-description"><?php _e('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_social_links"><?php _e("Modify Form Heading 'Social Links'", 'eco-profile-master'); ?></label></th>
                    <td><input type="text" class="regular-text" id="epm_form_heading_social_links" name="epm_form_heading_social_links" value="<?php echo esc_attr(sanitize_text_field(get_option('epm_form_heading_social_links', 'Social Links')) ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th><label for="epm_form_heading_social_links"><?php _e("Checked Form Heading 'Social Links' ", 'eco-profile-master'); ?></label></th>
                    <td>
                        <input type="checkbox" id="epm_form_heading_social_links_hide" name="epm_form_heading_social_links_hide" value="1" <?php checked(get_option('epm_form_heading_social_links_hide', '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                        <p class="epm-description"><?php _e('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_form_settings'); ?>
        </p>
    </form>
</div>