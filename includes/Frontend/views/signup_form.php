<?php
$labelsPlaceholders = $this->epm_label_placeholder();
$epm_form_heading_name = $this->generate_section_heading('epm_form_heading_name_hide', 'epm_form_heading_name', '1', 'Name');
$epm_form_heading_contact_info =  $this->generate_section_heading('epm_form_heading_contact_info_hide', 'epm_form_heading_contact_info', '1', 'Contact Info');
$epm_form_heading_about_yourself =  $this->generate_section_heading('epm_form_heading_about_yourself_hide', 'epm_form_heading_about_yourself', '1', 'About Yourself');
$epm_form_heading_profile_image =  $this->generate_section_heading('epm_form_heading_profile_image_hide', 'epm_form_heading_profile_image', '1', 'Profile Image');
$epm_form_heading_social_links =  $this->generate_section_heading('epm_form_heading_social_links_hide', 'epm_form_heading_social_links', '1', 'Social Links');
$enabledSocialFields = $this->getEnabledSocialFields();
$epm_form_heading_occupation =  $this->generate_section_heading('epm_form_heading_occupation_hide', 'epm_form_heading_occupation', '1', 'Occupation Options');
$epm_form_heading_religion =  $this->generate_section_heading('epm_form_heading_religion_hide', 'epm_form_heading_religion', '1', 'Religion Options');
$epm_form_heading_skin =  $this->generate_section_heading('epm_form_heading_skin_hide', 'epm_form_heading_skin', '1', 'Skin Color Options');
$epm_form_heading_gender =  $this->generate_section_heading('epm_form_heading_gender_hide', 'epm_form_heading_gender', '1', 'Gender Options');
$epm_form_heading_blood =  $this->generate_section_heading('epm_form_heading_blood_hide', 'epm_form_heading_blood', '1', 'Blood Group Options');
?>

<?php if ($this->display_registration_messages()) : ?>
    <p class="success"><?php $this->display_registration_messages(); ?></p>
<?php endif; ?>
<form class="flow flow-vertical" method="post" enctype="multipart/form-data" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="user_registration" value="user_registration" />
    <?php wp_nonce_field('user_registration_nonce', 'user_registration_nonce'); ?>
    <div class="flow space-y-4 bg-white shadow-md rounded-lg px-8 py-6">
        <?php require_once __DIR__ . '/fields/name.php'; ?>
        <?php require_once __DIR__ . '/fields/contact-info.php'; ?>
        <?php require_once __DIR__ . '/fields/about-info.php'; ?>
        <?php require_once __DIR__ . '/fields/occupation-info.php'; ?>
        <?php require_once __DIR__ . '/fields/religion-info.php'; ?>
        <?php require_once __DIR__ . '/fields/skin-color-info.php'; ?>
        <?php require_once __DIR__ . '/fields/gender-info.php'; ?>
        <?php require_once __DIR__ . '/fields/blood-group-info.php'; ?>
        <?php require_once __DIR__ . '/fields/profileimage.php'; ?>
        <?php require_once __DIR__ . '/fields/social-fields.php'; ?>
        <div class="flow">
            <button type="submit" class="btn btn-primary mt-10" name="user_register"><?php _e('Submit', 'eco-profile-master'); ?></button>
        </div>
        <div class="mt-4">
            <p class="text-gray-600 text-sm"><?php _e("Already have an account?", 'echo-profile-master') ?><a href="?action=login_page" class="text-blue-500 hover:underline"> <?php _e('Log In'); ?></a></p>
        </div>
    </div>
</form>