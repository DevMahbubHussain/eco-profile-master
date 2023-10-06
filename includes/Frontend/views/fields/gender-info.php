        <!-- gender info section -->
        <?php if ($enabledAdvancedField['gender']) : ?>
            <div class="flow">
                <label for="gender" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['gender']['label']); ?></label>
                <select id="gender" name="epm_user_gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['gender']['placeholder']); ?></option>
                    <option value="<?php esc_attr_e('Male', 'eco-profile-master'); ?>"><?php _e('Male', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Female', 'eco-profile-master'); ?>"><?php _e('Female', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Other', 'eco-profile-master'); ?>"><?php _e('Other', 'eco-profile-master'); ?></option>
                </select>
            </div>
        <?php endif; ?>
        <!-- end gender info section -->