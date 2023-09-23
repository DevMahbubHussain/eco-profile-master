<div class="bg-white p-8 rounded-lg shadow-md w-full">
    <h2 class="text-2xl font-semibold mb-4"><?php _e('Password Reset', 'epm-profile-master') ?></h2>
    <?php display_confirmation_message(); ?>
    <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="epm_user_password_reset_nonce" value="<?php echo esc_attr(wp_create_nonce('epm_user_password_reset_action')); ?>">
        <div class="mb-6">
            <label for="email" class="block text-gray-600 text-sm font-medium mb-2"><?php _e('Email Address'); ?></label>
            <input type="email" id="epm_user_email" name="epm_user_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="btn btn-primary mt-2" name="epm_password_reset"><?php _e('Reset Password', 'eco-profile-master'); ?></button>
        </div>
    </form>
</div>