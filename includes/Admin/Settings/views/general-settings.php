<div class="wrap">
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('general_settings_nonce', 'general_settings_nonce'); ?>
        <table class="form-table epm-th">
            <tbody>
                <tr>
                    <th><label for="epm_form_style"><?php _e('Form Styles:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_form_style" id="epm_form_style">
                            <option value="style1" <?php selected('style1', get_option('epm_form_style')); ?>><?php _e('Style 1'); ?></option>
                            <option value="style2" <?php selected('style2', get_option('epm_form_style')); ?>><?php _e('Style 2'); ?></option>
                            <option value="style3" <?php selected('style3', get_option('epm_form_style')); ?>><?php _e('Style 3'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select form style.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_automatically_login"><?php _e('Automatically Log In:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_automatically_login" id="epm_automatically_login">
                            <option value="no" <?php selected('no', get_option('epm_automatically_login')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_automatically_login')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select "Yes" to automatically log in new users after successful registration.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_email_confirmation_activated"><?php _e('Email Confirmation Activated:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_email_confirmation_activated" id="epm_email_confirmation_activated">
                            <option value="no" <?php selected('no', get_option('epm_email_confirmation_activated')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_email_confirmation_activated')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('This works with front-end forms only.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_admin_approval"><?php _e('Admin Approval:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_admin_approval" id="epm_admin_approval">
                            <option value="no" <?php selected('no', get_option('epm_admin_approval')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_admin_approval')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('You decide who is a user on your website. Get notified via email or approve multiple users at once from the WordPress UI.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_display_email"><?php _e('Display Email Address to Users:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_display_email" id="epm_display_email">
                            <option value="yes" <?php selected('yes', get_option('epm_display_email')); ?>><?php _e('Yes'); ?></option>
                            <option value="no" <?php selected('no', get_option('epm_display_email')); ?>><?php _e('No'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select "Yes" email address field will be avilable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_display_phone_number"><?php _e('Display Phone Number to Users:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_display_phone_number" id="epm_display_phone_number">
                            <option value="no" <?php selected('no', get_option('epm_display_phone_number')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_display_phone_number')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select "Yes" phone number field will be avilable.', 'eco-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_image"><?php _e('Allow Users to Upload Profile Image:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_image" id="epm_image">
                            <option value="no" <?php selected('no', get_option('epm_image')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_image')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Users can Upload their Profile Image.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_mailing_address"><?php _e('Display Mailing Address to Users:.', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_mailing_address" id="epm_mailing_address">
                            <option value="no" <?php selected('no', get_option('epm_mailing_address')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_mailing_address')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select "Yes" mailing address fields will be avilable.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_display_social_kinks"><?php _e('Display Social Links to Users:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_display_social_links" id="epm_display_social_links">
                            <option value="no" <?php selected('no', get_option('epm_display_social_links')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_display_social_links')); ?>><?php _e('Yes'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Select "Yes" social links fields will be avilable.', 'eco-profile-master'); ?></p>

                    </td>
                </tr>
                <tr>
                    <th><label for="epm_lost_password_page"><?php _e('Select Recover Password Page:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_lost_password_page" id="epm_lost_password_page"><?php echo esc_attr(epm_lost_password_page()); ?></select>
                        <p class="epm-description"><?php _e('Select the page which contains the [epm-recover-password] shortcode.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_login_page"><?php _e('Registration Redirect Page:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_login_page" id="epm_login_page"><?php echo esc_attr(epm_login_page()); ?></select>
                        <p class="epm-description"><?php _e('Select the page which contains the [epm-login] shortcode.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_profile_page"><?php _e('Login Redirect Page:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_profile_page" id="epm_profile_page"><?php echo esc_attr(epm_profile_page()); ?></select>
                        <p class="epm-description"><?php _e('Select the page which contains the [epm-profile-edit] shortcode.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_profile_page"><?php _e('Password Reset Page:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_pass_reset_page" id="epm_pass_reset_page"><?php echo esc_attr(epm_password_reset_form()); ?></select>
                        <p class="epm-description"><?php _e('Select the page which contains the [epm-password-reset-form] shortcode.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_general_settings'); ?>
        </p>
    </form>
</div>