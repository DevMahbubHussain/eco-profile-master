        <!-- contact info section -->
        <h2 class="text-xl font-semibold"><?php echo $epm_form_heading_contact_info; ?></h2>
        <?php if ($this->epm_allow_user_common_fields('email')) : ?>
            <div class="flow">
                <label for="epm_user_email" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['email']['label']); ?></label>
                <input type="email" id="epm_user_email" name="epm_user_email" class="input input-bordered w-full <?php echo $this->has_error('epm_user_email') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['email']['placeholder']); ?>">
                <?php if ($this->has_error('epm_user_email')) : ?>
                    <?php foreach ($this->get_error('epm_user_email') as $error_message) : ?>
                        <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($this->epm_allow_user_common_fields('phone')) : ?>
            <div class="flow">
                <label for="epm_user_phone" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['phone']['label']); ?></label>
                <input type="tel" id="epm_user_phone" name="epm_user_phone" class="input input-bordered w-full <?php echo $this->has_error('epm_user_phone') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['phone']['placeholder']); ?>">
                <?php if ($this->has_error('epm_user_phone')) : ?>
                    <?php foreach ($this->get_error('epm_user_phone') as $error_message) : ?>
                        <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="flow">
            <label for="epm_user_website" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['website']['label']); ?></label>
            <input type="url" id="epm_user_website" name="epm_user_website" class="input input-bordered w-full <?php echo $this->has_error('epm_user_website') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['website']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_website')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_website'); ?></span>
            <?php endif; ?>
        </div>
        <!-- end of contact info section -->