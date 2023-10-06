        <!-- religion info section -->
        <?php if ($enabledAdvancedField['religion']) : ?>
            <div class="flow">
                <label for="religion" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['religion']['label']); ?></label>
                <select id="religion" name="epm_user_religion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['religion']['placeholder']); ?> </option>
                    <option value="<?php esc_attr_e('Islam', 'eco-profile-master'); ?>"><?php _e('Islam', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Christianity', 'eco-profile-master'); ?>"><?php _e('Christianity', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Buddhism', 'eco-profile-master'); ?>"><?php _e('Buddhism', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Hinduism', 'eco-profile-master'); ?>"><?php _e('Hinduism', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Judaism', 'eco-profile-master'); ?>"><?php _e('Judaism', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Jainism', 'eco-profile-master'); ?>"><?php _e('Jainism', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Other', 'eco-profile-master'); ?>"><?php _e('Other', 'eco-profile-master'); ?></option>
                </select>
            </div>
        <?php endif; ?>
        <!-- end religion info section -->