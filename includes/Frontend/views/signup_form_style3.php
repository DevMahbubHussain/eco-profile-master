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
        <label for="password">Profile Image:</label>
        <input type="file" id="password" name="password">
    <?php else : ?>
        <h2>WHat</h2>
    <?php endif; ?>

    <?php echo $this->display_form_section_heading(); ?>
    <button type="submit">Register</button>
</form>