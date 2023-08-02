<div class="wrap">
    <h2><?php _e('User Listings', 'eco-profile-master'); ?></h2>
    <form method="POST">
        <input type="hidden" name="updated" value="true">
        <?php wp_nonce_field('user_listing_update', 'user_listing_form'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="firstname">FirstName</label></th>
                    <td><input name="firstname" id="firstname" type="text" value="" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="lastname">LastName</label></th>
                    <td><input name="lastname" id="lastname" type="text" value="" class="regular-text" /></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save">
        </p>
    </form>
</div>