        <!-- name section -->
        <h4 class="text-xl font-semibold mb-2"><?php echo $epm_form_heading_name; ?></h4>
        <div class="flow">
            <label for="epm_user_username" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['username']['label']); ?></label>
            <input type="text" id="epm_user_username" name="epm_user_username" class="input input-bordered w-full <?php echo $this->has_error('epm_user_username') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['username']['placeholder']); ?>">

            <?php if ($this->has_error('epm_user_username')) : ?>
                <?php foreach ($this->get_error('epm_user_username') as $error_message) : ?>
                    <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <div class="flow">
            <label for="epm_user_firstname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['firstname']['label']); ?></label>
            <input type="text" id="epm_user_firstname" name="epm_user_firstname" class="input input-bordered w-full <?php echo $this->has_error('epm_user_firstname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['firstname']['placeholder']); ?>">

            <?php if ($this->has_error('epm_user_firstname')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_firstname'); ?></span>
            <?php endif; ?>
        </div>
        <div class="flow">
            <label for="epm_user_lastname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['lastname']['label']); ?></label>
            <input type="text" id="epm_user_lastname" name="epm_user_lastname" class="input input-bordered w-full <?php echo $this->has_error('epm_user_lastname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['lastname']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_lastname')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_lastname'); ?></span>
            <?php endif; ?>

        </div>
        <div class="flow">
            <label for="epm_user_nickname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['nickname']['label']); ?></label>
            <input type="text" id="epm_user_nickname" name="epm_user_nickname" class="input input-bordered w-full <?php echo $this->has_error('nickname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['nickname']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_nickname')) : ?>
                <span class="error-message"><?php echo $this->get_error('epm_user_nickname'); ?></span>
            <?php endif; ?>
        </div>
        <!-- end of name -->