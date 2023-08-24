        <!-- profile image section -->
        <?php if ($this->epm_allow_user_common_fields('image')) : ?>
            <h4 class="text-xl font-semibold"> <?php echo $epm_form_heading_profile_image; ?> </h4>
            <div class="flow">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar"><?php echo esc_attr($labelsPlaceholders['image']['label']); ?></label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 <?php echo $this->has_error('epm_user_avatar') ? 'error-field' : ''; ?>" id="epm_user_avatar" type="file" id="epm_user_avatar" name="epm_user_avatar">
                <?php if ($this->has_error('epm_user_avatar')) : ?>
                    <?php foreach ($this->get_error('epm_user_avatar') as $error_message) : ?>
                        <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="mt-5">
                    <?php render_uploaded_image(); ?>
                </div>
            </div>
        <?php endif; ?>
        <!-- profile image section -->