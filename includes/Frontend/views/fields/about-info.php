        <!-- About yourselft section -->
        <h2 class="text-xl font-semibold"> <?php echo $epm_form_heading_about_yourself; ?></h2>
        <div class="flow">
            <label for="message" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['biographical']['label']); ?></label>
            <textarea id="epm_user_bio" rows="4" name="epm_user_bio" class="input input-bordered w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?php echo esc_attr($labelsPlaceholders['biographical']['placeholder']); ?>"></textarea>
        </div>
        <div class="flow">
            <label for="epm_user_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['password']['label']); ?></label>
            <input type="password" id="epm_user_password" name="epm_user_password" class="input input-bordered w-full <?php echo $this->has_error('epm_user_password_length') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['password']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_password_length')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_password_length'); ?></span>
            <?php endif; ?>
        </div>
        <div class="flow">
            <label for="epm_user_retype_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['repassword']['label']); ?></label>
            <input type="password" id="epm_user_retype_password" name="epm_user_retype_password" class="input input-bordered w-full <?php echo $this->has_error('epm_user_password_match') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['repassword']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_password_match')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_password_match'); ?></span>
            <?php endif; ?>
        </div>
        <!-- end About yourselft section -->