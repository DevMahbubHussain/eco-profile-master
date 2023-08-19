<?php
$labelsPlaceholders = $this->epm_label_placeholder();
// echo "<pre>";
// print_r($labelsPlaceholders);
// echo "<pre>";


$epm_form_heading_name = $this->generate_section_heading('epm_form_heading_name_hide', 'epm_form_heading_name', '1', 'Name');
$epm_form_heading_contact_info =  $this->generate_section_heading('epm_form_heading_contact_info_hide', 'epm_form_heading_contact_info', '1', 'Contact Info');
$epm_form_heading_about_yourself =  $this->generate_section_heading('epm_form_heading_about_yourself_hide', 'epm_form_heading_about_yourself', '1', 'About Yourself');
$epm_form_heading_profile_image =  $this->generate_section_heading('epm_form_heading_profile_image_hide', 'epm_form_heading_profile_image', '1', 'Profile Image');
$epm_form_heading_social_links =  $this->generate_section_heading('epm_form_heading_social_links_hide', 'epm_form_heading_social_links', '1', 'Social Links');

?>



<form class="flow flow-vertical">
    <div class="flow space-y-4 bg-white shadow-md rounded-lg px-8 py-6">

        <!-- name section -->
        <h4 class="text-xl font-semibold mb-2"><?php echo $epm_form_heading_name; ?></h4>
        <div class="flow">
            <label for="epm_user_username" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['username']['label']); ?></label>
            <input type="text" id="epm_user_username" name="epm_user_username" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['username']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_firstname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['firstname']['label']); ?></label>
            <input type="text" id="epm_user_firstname" name="epm_user_firstname" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['firstname']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_lastname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['lastname']['label']); ?></label>
            <input type="text" id="epm_user_lastname" name="epm_user_lastname" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['lastname']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_nickname" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['nicknmae']['label']); ?></label>
            <input type="text" id="epm_user_nickname" name="epm_user_nickname" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['nickname']['placeholder']); ?>">
        </div>
        <!-- end of name -->
        <!-- contact info section -->
        <h2 class="text-xl font-semibold"><?php echo $epm_form_heading_contact_info; ?></h2>
        <div class="flow">
            <label for="epm_user_email" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['email']['label']); ?></label>
            <input type="email" id="epm_user_email" name="epm_user_email" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['email']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_phone" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['phone']['label']); ?></label>
            <input type="tel" id="epm_user_phone" name="epm_user_phone" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['phone']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_website" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['website']['label']); ?></label>
            <input type="url" id="epm_user_website" name="epm_user_website" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['website']['placeholder']); ?>">
        </div>
        <!-- end of contact info section -->

        <!-- About yourselft section -->
        <h2 class="text-xl font-semibold"> <?php echo $epm_form_heading_about_yourself; ?></h2>
        <div class="flow">
            <label for="message" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['biographical']['label']); ?></label>
            <textarea id="epm_user_bio" rows="4" name="epm_user_bio" class="input input-bordered w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<?php echo esc_attr($labelsPlaceholders['biographical']['placeholder']); ?>"></textarea>
        </div>
        <div class="flow">
            <label for="epm_user_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['password']['label']); ?></label>
            <input type="password" id="epm_user_password" name="epm_user_password" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['password']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_retype_password" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['repassword']['label']); ?></label>
            <input type="password" id="epm_user_retype_password" name="epm_user_password" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['repassword']['placeholder']); ?>">
        </div>
        <!-- end About yourselft section -->
        <!-- profile image section -->
        <h4 class="text-xl font-semibold"> <?php echo $epm_form_heading_profile_image; ?> </h4>
        <div class="flow">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar"><?php echo esc_attr($labelsPlaceholders['image']['label']); ?></label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="epm_user_avatar" type="file" name="epm_user_avatar">
        </div>
        <!-- profile image section -->
        <!-- Social Media Inputs -->
        <h4 class="text-xl font-semibold"> <?php echo $epm_form_heading_social_links; ?> </h4>
        <div class="flow">
            <label for="epm_user_facebook" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['facebook']['label']); ?></label>
            <input type="text" id="epm_user_facebook" name="epm_user_facebook" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['facebook']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_twitter" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['twitter']['label']); ?></label>
            <input type="text" id="epm_user_twitter" name="epm_user_twitter" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['twitter']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_linkedin" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['linkedin']['label']); ?></label>
            <input type="text" id="epm_user_linkedin" name="epm_user_linkedin" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['linkedin']['placeholder']); ?>L">
        </div>
        <div class="flow">
            <label for="epm_user_youtube" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['youtube']['label']); ?></label>
            <input type="text" id="epm_user_youtube" name="epm_user_youtube" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['youtube']['placeholder']); ?>">
        </div>
        <div class="flow">
            <label for="epm_user_instagram" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['youtube']['instagram']); ?></label>
            <input type="text" id="epm_user_instagram" name="epm_user_instagram" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['youtube']['placeholder']); ?>">
        </div>
        <!-- Social Media Inputs -->
        <div class="flow">
            <button type="submit" class="btn btn-primary mt-10">Submit</button>
        </div>
    </div>
</form>