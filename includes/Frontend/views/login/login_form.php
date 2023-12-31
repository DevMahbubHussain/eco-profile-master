<div class="container mx-auto">
    <div class="bg-white p-8 rounded-lg shadow-md w-full">
        <?php display_transient_error('email_verification_error'); ?>
        <h2 class="text-2xl font-semibold mb-4"><?php _e('Login', 'eco-profile-master') ?></h2>
        <?php
        $send_confirmation = sanitize_text_field(get_option('epm_email_confirmation_activated', 'no'));
        if ($this->login_has_error('username_or_email_confirmed') && $send_confirmation === 'yes') : ?>
            <span class="error-message"><?php echo $this->login_get_error('username_or_email_confirmed'); ?></span>
        <?php endif; ?>
        <?php
        $admin_confirmation = sanitize_text_field(get_option('epm_admin_approval', 'no'));
        if ($this->login_has_error('admin_approval_error') && $admin_confirmation == 'yes') : ?>
            <span class="error-message"><?php echo $this->login_get_error('admin_approval_error'); ?></span>
        <?php endif; ?>
        <?php display_password_reset_confirmation_message(); ?>
        <?php displayConfirmationMessages(); ?>
        <?php if ($this->login_has_error('approval_status')) : ?>
            <span class="error-message"><?php echo $this->login_get_error('approval_status'); ?></span>
        <?php endif; ?>
        <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="epm_user_login_nonce" value="<?php echo wp_create_nonce('epm_user_login_nonce'); ?>">
            <div class="mb-6">
                <label for="email" class="block text-gray-600 text-sm font-medium mb-2"><?php _e('Username or Email Address'); ?></label>
                <input type="text" id="username_or_email" name="username_or_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                <?php if ($this->login_has_error('username_or_email')) : ?>
                    <span class="error-message"><?php echo $this->login_get_error('username_or_email'); ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-600 text-sm font-medium mb-2"><?php _e('Password'); ?></label>
                <input type="password" id="epm_user_password" name="epm_user_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                <?php if ($this->login_has_error('password')) : ?>
                    <span class="error-message"><?php echo $this->login_get_error('password'); ?></span>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="btn btn-primary mt-10" name="epm_login"><?php _e('Login', 'eco-profile-master'); ?></button>
                <a href="?action=lost_password" class="text-blue-500 text-sm hover:underline"><?php _e('Lost your password?', 'eco-profile-master'); ?></a>
            </div>
        </form>
        <div class="mt-4">
            <p class="text-gray-600 text-sm"><?php _e("Don't have an account?", 'echo-profile-master') ?><a href="?action=sign_up" class="text-blue-500 hover:underline"><?php _e('Sign Up', 'eco-profile-master'); ?></a></p>
        </div>
    </div>