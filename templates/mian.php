<div class="wrap">
    <h2>My Awesome Settings Page</h2>
    <form method="POST">
        <input type="hidden" name="updated" value="true" />
        <?php wp_nonce_field('awesome_update', 'awesome_form'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="username">Username</label></th>
                    <td><input name="username" id="username" type="text" value="<?php echo get_option('awesome_username'); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="email">Email Address</label></th>
                    <td><input name="email" id="email" type="text" value="<?php echo get_option('awesome_email'); ?>" class="regular-text" /></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Send my Info!">
        </p>
    </form>
</div>