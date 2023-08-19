<?php
    // $heading_hide = $this->display_form_section_heading('epm_form_heading_name_hide', '1');
    // $heading = sanitize_text_field(get_option('epm_form_heading_name', 'Name'));
    // $heading_contact_info_hide = $this->display_form_section_heading('epm_form_heading_contact_info_hide', '1');
    // $heading_contact_info = sanitize_text_field(get_option('epm_form_heading_contact_info', 'Contact Info'));

    $epm_form_heading_name = $this->generate_section_heading('epm_form_heading_name_hide', 'epm_form_heading_name', '1', 'Name');
    $epm_form_heading_contact_info =  $this->generate_section_heading('epm_form_heading_contact_info_hide', 'epm_form_heading_contact_info', '1', 'Contact Info');
    $epm_form_heading_about_yourself =  $this->generate_section_heading('epm_form_heading_about_yourself_hide', 'epm_form_heading_about_yourself', '1', 'About Yourself');
    $epm_form_heading_profile_image =  $this->generate_section_heading('epm_form_heading_profile_image_hide', 'epm_form_heading_profile_image', '1', 'Profile Image');
    $epm_form_heading_social_links =  $this->generate_section_heading('epm_form_heading_social_links_hide', 'epm_form_heading_social_links', '1', 'Social Links');

?>
<form action="registration-process.php" method="post">
    <!-- Other registration fields -->
    <?php if ($this->epm_should_generate_password()) : ?>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
    <?php else : ?>
        <label for="auto_generate_password">
            <input type="checkbox" id="auto_generate_password" name="auto_generate_password" value="1">
            Automatically generate password
        </label>
    <?php endif; ?>

    <?php if ($this->epm_allow_user_profile_image_upload()) : ?>
        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image">
    <?php else : ?>
        <h2>What</h2>
    <?php endif; ?>

    <?php echo $heading_name_section; ?>
    <?php echo $heading_contact_info_section; ?>

    <button type="submit">Register</button>
</form>