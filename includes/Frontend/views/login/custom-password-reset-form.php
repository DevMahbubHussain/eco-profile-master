<div class="bg-white p-8 rounded-lg shadow-md w-full">
    <h2 class="text-2xl font-semibold mb-4"><?php _e('Pick a New Password', 'epm-profile-master') ?></h2>
    <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="epm_user_new_password_reset_nonce" value="<?php echo esc_attr(wp_create_nonce('epm_user_new_password_reset_action')); ?>">
        <div class="mb-6">
            <label for="password" class="block text-gray-600 text-sm font-medium mb-2"><?php _e('New assword'); ?></label>
            <input type="password" id="epm_user_password" name="epm_user_password" size="20" autocomplete="off" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            <?php if ($this->login_has_error('password_length')) : ?>
                <span class="error-message"><?php echo $this->login_get_error('password_length'); ?></span>
            <?php endif; ?>
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-600 text-sm font-medium mb-2"><?php _e('Repeat new assword'); ?></label>
            <input type="password" id="epm_user_confirm_password" name="epm_user_confirm_password" size="20" autocomplete="off" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            <?php if ($this->login_has_error('password_mismatch')) : ?>
                <span class="error-message"><?php echo $this->login_get_error('password_mismatch'); ?></span>
            <?php endif; ?>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="btn btn-primary mt-2" name="epm_password_reset_form"><?php _e('Get New Password', 'eco-profile-master'); ?></button>
        </div>
    </form>
</div>