<div class="wrap">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('form_fields_settings_nonce', 'form_fields_settings_nonce'); ?>
        <table class="form-table epm-th">
            <tbody>
                <?php
                $sections = array(
                    'name' => __('Name', 'eco-profile-master'),
                    'contact_info' => __('Contact Info', 'eco-profile-master'),
                    'about_yourself' => __('About Yourself', 'eco-profile-master'),
                    'profile_image' => __('Profile Image', 'eco-profile-master'),
                    'social_links' => __('Social Links', 'eco-profile-master'),
                );

                foreach ($sections as $section_key => $section_label) :
                    $option_name = "epm_form_heading_$section_key";
                    $hide_option_name = "epm_form_heading_{$section_key}_hide";
                ?>
                    <tr>
                        <th><label for="<?php echo esc_attr($option_name); ?>"><?php printf(__('Modify Form Heading \'%s\'', 'eco-profile-master'), esc_html($section_label)); ?></label></th>
                        <td><input type="text" class="regular-text" id="<?php echo esc_attr($option_name); ?>" name="<?php echo esc_attr($option_name); ?>" value="<?php echo esc_attr(sanitize_text_field(get_option($option_name, $section_label) ?? '')); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="<?php echo esc_attr($hide_option_name); ?>"><?php printf(__('Checked Form Heading \'%s\'', 'eco-profile-master'), esc_html($section_label)); ?></label></th>
                        <td>
                            <input type="checkbox" id="<?php echo esc_attr($hide_option_name); ?>" name="<?php echo esc_attr($hide_option_name); ?>" value="1" <?php checked(get_option($hide_option_name, '1'), 1); ?>><?php esc_html_e('Show or Hide', 'eco-profile-master'); ?>
                            <p class="epm-description"><?php printf(__('By checking the heading won\'t be shown, Default is Show.', 'eco-profile-master')); ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_form_settings'); ?>
        </p>
    </form>
</div>