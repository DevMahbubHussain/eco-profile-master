        <!-- blood info section -->
        <?php if ($enabledAdvancedField['blood']) : ?>
            <div class="flow">
                <label for="blood" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['blood']['label']); ?></label>
                <select id="blood" name="epm_user_blood_group" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['blood']['placeholder']); ?></option>
                    <option value="<?php esc_attr_e('A+', 'eco-profile-master'); ?>"><?php _e('A+', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('A-', 'eco-profile-master'); ?>"><?php _e('A-', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('B+', 'eco-profile-master'); ?>"><?php _e('B+', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('B-', 'eco-profile-master'); ?>"><?php _e('B-', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('O+', 'eco-profile-master'); ?>"><?php _e('O+', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('O-', 'eco-profile-master'); ?>"><?php _e('O-', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('AB+', 'eco-profile-master'); ?>"><?php _e('AB+', 'eco-profile-master'); ?></option>
                </select>
            </div>
        <?php endif; ?>
        <!-- end blood info section -->