<?php if ($this->epm_allow_user_common_fields('social_links')) : ?>
    <!-- Social Media Inputs -->
    <h4 class="text-xl font-semibold"> <?php echo $epm_form_heading_social_links; ?> </h4>
    <?php if ($this->getEnabledSocialFields()) : ?>

        <?php if ($enabledSocialFields['facebook']) : ?>
            <div class="flow">
                <label for="epm_user_facebook" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['facebook']['label']); ?></label>
                <input type="text" id="epm_user_facebook" name="epm_user_facebook" class="input input-bordered w-full <?php echo $this->has_error('epm_user_facebook') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['facebook']['placeholder']); ?>">
                <?php if ($this->has_error('epm_user_facebook')) : ?>
                    <span class="error-message"><?php echo $this->get_error('epm_user_facebook'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($enabledSocialFields['twitter']) : ?>
            <div class="flow">
                <label for="epm_user_twitter" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['twitter']['label']); ?></label>
                <input type="text" id="epm_user_twitter" name="epm_user_twitter" class="input input-bordered w-full <?php echo $this->has_error('epm_user_twitter') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['twitter']['placeholder']); ?>">

                <?php if ($this->has_error('epm_user_twitter')) : ?>
                    <span class="error-message"><?php echo $this->get_error('epm_user_twitter'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($enabledSocialFields['linkedin']) : ?>
            <div class="flow">
                <label for="epm_user_linkedin" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['linkedin']['label']); ?></label>
                <input type="text" id="epm_user_linkedin" name="epm_user_linkedin" class="input input-bordered w-full <?php echo $this->has_error('epm_user_linkedin') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['linkedin']['placeholder']); ?>L">
                <?php if ($this->has_error('epm_user_twitter')) : ?>
                    <span class="error-message"><?php echo $this->get_error('epm_user_linkedin'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($enabledSocialFields['youtube']) : ?>
            <div class="flow">
                <label for="epm_user_youtube" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['youtube']['label']); ?></label>
                <input type="text" id="epm_user_youtube" name="epm_user_youtube" class="input input-bordered w-full <?php echo $this->has_error('epm_user_youtube') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['youtube']['placeholder']); ?>">
                <?php if ($this->has_error('epm_user_twitter')) : ?>
                    <span class="error-message"><?php echo $this->get_error('epm_user_youtube'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($enabledSocialFields['instagram']) : ?>
            <div class="flow">
                <label for="epm_user_instagram" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['instagram']['label']); ?></label>
                <input type="text" id="epm_user_instagram" name="epm_user_instagram" class="input input-bordered w-full <?php echo $this->has_error('epm_user_instagram') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['instagram']['placeholder']); ?>">
                <?php if ($this->has_error('epm_user_instagram')) : ?>
                    <span class="error-message"><?php echo $this->get_error('epm_user_instagram'); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <!-- Social Media Inputs -->
    <?php endif; ?>
<?php endif; ?>