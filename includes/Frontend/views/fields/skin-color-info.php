        <!-- skin info section -->
        <?php if ($enabledAdvancedField['skin']) : ?>
            <div class="flow">
                <label for="skin" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['skin']['label']); ?></label>
                <select id="skin" name="epm_user_skin_color" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['skin']['placeholder']); ?></option>
                    <option value="<?php esc_attr_e('Fair', 'eco-profile-master'); ?>"><?php _e('Fair', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Brown', 'eco-profile-master'); ?>"><?php _e('Brown', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Dark', 'eco-profile-master'); ?>"><?php _e('Dark', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Black', 'eco-profile-master'); ?>"><?php _e('Black', 'eco-profile-master'); ?></option>
                </select>
            </div>
        <?php endif; ?>
        <!-- end skin info section -->