<?php
// $confirmation_link = $this->EmailConfirmationHandler();
// var_dump($confirmation_link);
?>
<div class="bg-white p-8 rounded-lg shadow-md w-full">
    <h2 class="text-2xl font-semibold mb-4"><?php _e('Login', 'epm-profile-master') ?></h2>
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
            <a href="<?php echo esc_url(add_query_arg('action', 'custom_lostpassword')); ?>" class="text-blue-500 text-sm hover:underline">Lost your password?</a>
        </div>
    </form>
    <div class="mt-4">
        <p class="text-gray-600 text-sm">Don't have an account? <a href="#" class="text-blue-500 hover:underline">Sign Up</a></p>
    </div>
</div>