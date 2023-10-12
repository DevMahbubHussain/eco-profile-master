        <!-- occupation info section -->
        <?php if ($enabledAdvancedField['occupation']) : ?>
            <div class="flow">
                <label for="occupation" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['occupation']['label']); ?></label>
                <select id="occupation" name="epm_user_occupation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['occupation']['placeholder']); ?></option>
                    <option value="<?php esc_attr_e('Student', 'eco-profile-master'); ?>"><?php _e('Student', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Doctor', 'eco-profile-master'); ?>"><?php _e('Doctor', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Architect', 'eco-profile-master'); ?>"><?php _e('Architect', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Engineer', 'eco-profile-master'); ?>"><?php _e('Engineer', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Teacher', 'eco-profile-master'); ?>"><?php _e('Teacher', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Govt Employee', 'eco-profile-master'); ?>"><?php _e('Govt Employee', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Private Service', 'eco-profile-master'); ?>"><?php _e('Private Service', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Media Professional', 'eco-profile-master'); ?>"><?php _e('Media Professional', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('IT Professional', 'eco-profile-master'); ?>"><?php _e('IT Professional', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Businessman', 'eco-profile-master'); ?>"><?php _e('Businessman', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Lawyer', 'eco-profile-master'); ?>"><?php _e('Lawyer', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Banker', 'eco-profile-master'); ?>"><?php _e('Banker', 'eco-profile-master'); ?></option>
                    <option value="<?php esc_attr_e('Other', 'eco-profile-master'); ?>"><?php _e('Other', 'eco-profile-master'); ?></option>
                </select>
            </div>
        <?php endif; ?>
        <!-- end occupation info section -->