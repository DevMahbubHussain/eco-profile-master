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
    <button type="submit">Register</button>
</form>