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
                    <th><label for="epm_roles_editor_activated"><?php _e('Roles Editor Activated:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_roles_editor_activated" id="epm_roles_editor_activated">
                            <option value="no" <?php selected('no', get_option('epm_roles_editor_activated')); ?>><?php _e('No'); ?></option>
                            <option value="yes" <?php selected('yes', get_option('epm_roles_editor_activated')); ?>><?php _e('Yes'); ?></option>
                        </select>
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
                    <th><label for="epm_loginwith"><?php _e('Allow Users to Log in With:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_loginwith" id="epm_loginwith">
                            <option value="usernameemail" <?php selected('usernameemail', get_option('epm_loginwith')); ?>><?php _e('Username and Email'); ?></option>
                            <option value="username" <?php selected('username', get_option('epm_loginwith')); ?>><?php _e('Username'); ?></option>
                            <option value="email" <?php selected('email', get_option('epm_loginwith')); ?>><?php _e('Email'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Users can Log In with either their Username or their Email or only username or only email.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_image"><?php _e('Allow Users to Upload Profile Image:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_image" id="epm_image">
                            <option value="yes" <?php selected('yes', get_option('epm_image')); ?>><?php _e('Yes'); ?></option>
                            <option value="no" <?php selected('no', get_option('epm_image')); ?>><?php _e('No'); ?></option>
                        </select>
                        <p class="epm-description"><?php _e('Users can Upload their Profile Image.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th><label for="epm_lost_password_page"><?php _e('Select Recover Password Page:', 'eco-profile-master'); ?></label></th>
                    <td>
                        <select class="epm-select" name="epm_lost_password_page" id="epm_lost_password_page"><?php echo esc_attr(epm_get_general_settings_active_page()); ?></select>
                        <p class="epm-description"><?php _e('Select the page which contains the [epm-recover-password] shortcode.', 'echo-profile-master'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <?php submit_button(__('Save Changes', 'eco-profile-master'), 'primary', 'epm_general_settings'); ?>
        </p>
    </form>
</div>