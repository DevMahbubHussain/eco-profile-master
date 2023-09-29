<?php
$labelsPlaceholders = $this->epm_label_placeholder();
$epm_form_heading_name = $this->generate_section_heading('epm_form_heading_name_hide', 'epm_form_heading_name', '1', 'Name');
$epm_form_heading_contact_info =  $this->generate_section_heading('epm_form_heading_contact_info_hide', 'epm_form_heading_contact_info', '1', 'Contact Info');
$epm_form_heading_about_yourself =  $this->generate_section_heading('epm_form_heading_about_yourself_hide', 'epm_form_heading_about_yourself', '1', 'About Yourself');
$epm_form_heading_profile_image =  $this->generate_section_heading('epm_form_heading_profile_image_hide', 'epm_form_heading_profile_image', '1', 'Profile Image');
$epm_form_heading_social_links =  $this->generate_section_heading('epm_form_heading_social_links_hide', 'epm_form_heading_social_links', '1', 'Social Links');
?>
<?php displayConfirmationprofileUpdateMessages(); ?>

<form class="flow py-2 flow py-2-vertical" method="POST" enctype="multipart/form-data" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="epm_user_profile_nonce" value="<?php echo wp_create_nonce('epm_user_profile_action'); ?>">
    <!-- name section -->
    <h4 class="text-xl font-semibold pb-3"><?php echo $epm_form_heading_name; ?></h4>
    <div class="flow py-2">
        <label for="epm_user_username" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['username']['label']); ?></label>
        <input type="text" id="epm_user_username" name="epm_user_username" value="<?php echo isset($current_user) ? esc_attr($current_user->user_login) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_username') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['username']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_username')) : ?>
            <?php foreach ($this->get_error('epm_user_username') as $error_message) : ?>
                <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_firstname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['firstname']['label']); ?></label>
        <input type="text" id="epm_user_firstname" name="epm_user_firstname" value="<?php echo isset($current_user) ? esc_attr($current_user->first_name) : ''; ?>" class=" input input-bordered w-full <?php echo $this->has_error('epm_user_firstname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['firstname']['placeholder']); ?>">

        <?php if ($this->has_error('epm_user_firstname')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_firstname'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_lastname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['lastname']['label']); ?></label>
        <input type="text" id="epm_user_lastname" name="epm_user_lastname" value="<?php echo isset($current_user) ? esc_attr($current_user->last_name) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_lastname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['lastname']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_lastname')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_lastname'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_nickname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['nickname']['label']); ?></label>
        <input type="text" id="epm_user_nickname" name="epm_user_nickname" value="<?php echo isset($current_user) ? esc_attr($current_user->nickname) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('nickname') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['nickname']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_nickname')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_nickname'); ?></span>
        <?php endif; ?>
    </div>

    <div class="flow py-2">
        <label for="epm_user_display_name" class="text-gray-700"><?php echo esc_attr('Display name publicly', 'eco-profile-master'); ?></label>
        <input type="text" id="epm_user_display_name" name="epm_user_display_name" value="<?php echo isset($current_user) ? esc_attr($current_user->display_name) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('display_name') ? 'error-field' : ''; ?>" required>
        <?php if ($this->has_error('display_name')) : ?>
            <span class="error-message"><?php echo $this->get_error('display_name'); ?></span>
        <?php endif; ?>
    </div>
    <!-- end of name -->

    <!-- contact info section -->
    <h2 class="text-xl font-semibold pt-10 pb-3"><?php echo $epm_form_heading_contact_info; ?></h2>
    <div class="flow py-2">
        <label for="epm_user_email" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['email']['label']); ?></label>
        <input type="email" id="epm_user_email" name="epm_user_email" value="<?php echo isset($current_user) ? esc_attr($current_user->user_email) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_email') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['email']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_email')) : ?>
            <?php foreach ($this->get_error('epm_user_email') as $error_message) : ?>
                <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if ($this->epm_allow_user_common_fields('phone')) : ?>
        <div class="flow py-2">
            <label for="epm_user_phone" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['phone']['label']); ?></label>
            <input type="tel" id="epm_user_phone" name="epm_user_phone" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_phone) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_phone') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['phone']['placeholder']); ?>">
            <?php if ($this->has_error('epm_user_phone')) : ?>
                <?php foreach ($this->get_error('epm_user_phone') as $error_message) : ?>
                    <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="flow py-2">
        <label for="epm_user_website" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['website']['label']); ?></label>
        <input type="url" id="epm_user_website" name="epm_user_website" value="<?php echo isset($current_user) ? esc_attr($current_user->user_url) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('user_url') ? 'error-field' : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_website') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['website']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_website')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_website'); ?></span>
        <?php endif; ?>
    </div>
    <!-- end of contact info section -->

    <!-- About yourselft section -->
    <h2 class="text-xl font-semibold pt-10 pb-3"> <?php echo $epm_form_heading_about_yourself; ?></h2>
    <div class="flow py-2">
        <label for="message" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['biographical']['label']); ?></label>
        <textarea id="epm_user_bio" rows="4" name="epm_user_bio" class="input input-bordered w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?php echo esc_attr($labelsPlaceholders['biographical']['placeholder']); ?>"><?php echo isset($current_user) ? esc_attr($current_user->description) : ''; ?></textarea>
    </div>
    <div class="flow py-2">
        <label for="epm_user_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['password']['label']); ?></label>
        <input type="password" id="epm_user_password" name="epm_user_password" class="input input-bordered w-full <?php echo $this->has_error('epm_user_password_length') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['password']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_password_length')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_password_length'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_retype_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['repassword']['label']); ?></label>
        <input type="password" id="epm_user_retype_password" name="epm_user_password" class="input input-bordered w-full <?php echo $this->has_error('epm_user_password_match') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['repassword']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_password_match')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_password_match'); ?></span>
        <?php endif; ?>
    </div>
    <!-- end About yourselft section -->

    <!-- profile image section -->
    <h4 class="text-xl font-semibold pt-10 pb-3"> <?php echo $epm_form_heading_profile_image; ?> </h4>
    <div class="flow py-2">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar"><?php echo esc_attr($labelsPlaceholders['image']['label']); ?></label>
        <input id="epm_user_avatar" type="file" name="epm_user_avatar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 <?php echo $this->has_error('epm_user_avatar') ? 'error-field' : ''; ?>">
        <?php if ($this->has_error('epm_user_avatar')) : ?>
            <?php foreach ($this->get_error('epm_user_avatar') as $error_message) : ?>
                <span class="error-message"><?php echo esc_html($error_message); ?></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="mt-5">
            <?php render_uploaded_image(); ?>
        </div>
        <div class="my-5">
            <?php display_current_user_image(); ?>
        </div>
    </div>
    <!-- profile image section -->
    <!-- Social Media Inputs -->
    <h4 class="text-xl font-semibold"> <?php echo $epm_form_heading_social_links; ?> </h4>
    <div class="flow py-2">
        <label for="epm_user_facebook" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['facebook']['label']); ?></label>
        <input type="text" id="epm_user_facebook" name="epm_user_facebook" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_facebook) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_facebook') ? 'error-field' : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_website') ? 'error-field' : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_facebook') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['facebook']['placeholder']); ?>">

        <?php if ($this->has_error('epm_user_facebook')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_facebook'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_twitter" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['twitter']['label']); ?></label>
        <input type="text" id="epm_user_twitter" name="epm_user_twitter" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_twitter) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_twitter') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['twitter']['placeholder']); ?>">

        <?php if ($this->has_error('epm_user_twitter')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_twitter'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_linkedin" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['linkedin']['label']); ?></label>
        <input type="text" id="epm_user_linkedin" name="epm_user_linkedin" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_linkedin) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_linkedin') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['linkedin']['placeholder']); ?>L">
        <?php if ($this->has_error('epm_user_twitter')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_linkedin'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_youtube" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['youtube']['label']); ?></label>
        <input type="text" id="epm_user_youtube" name="epm_user_youtube" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_youtube) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_youtube') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['youtube']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_twitter')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_youtube'); ?></span>
        <?php endif; ?>
    </div>
    <div class="flow py-2">
        <label for="epm_user_instagram" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['instagram']['label']); ?></label>
        <input type="text" id="epm_user_instagram" name="epm_user_instagram" value="<?php echo isset($current_user) ? esc_attr($current_user->epm_user_instagram) : ''; ?>" class="input input-bordered w-full <?php echo $this->has_error('epm_user_instagram') ? 'error-field' : ''; ?>" placeholder="<?php echo esc_attr($labelsPlaceholders['instagram']['placeholder']); ?>">
        <?php if ($this->has_error('epm_user_instagram')) : ?>
            <span class="error-message"><?php echo $this->get_error('epm_user_instagram'); ?></span>
        <?php endif; ?>
    </div>
    <!-- Social Media Inputs -->
    <div class="flow">
        <button type="submit" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-10" name="user_profile"><?php _e('Update Profile', 'eco-profile-master'); ?></button>
    </div>
</form>
<button data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    <?php _e('View Profile'); ?>
</button>
<?php include_once __DIR__ . '/profile_details.php';  ?>