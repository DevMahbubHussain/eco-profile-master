<div class="max-w-screen-2xl mx-auto px-8 md:px-16 lg:px-24 py-5 my-10 w-100-grid">
    <h3 class="text-white bg-teal-950 background-color: rgb(4 47 46); p-5"><?php _e('Users Listing', 'eco-profile-master'); ?></h3>
    <table id="userslist" class="display py-5" style="width:100%!important">
        <thead>
            <tr>
                <th><?php _e('Profile Image', 'eco-profile-master'); ?></th>
                <th><?php _e('Name', 'eco-profile-master'); ?></th>
                <th><?php _e('Email', 'eco-profile-master'); ?></th>
                <th><?php _e('Joining Date', 'eco-profile-master'); ?></th>
                <th><?php _e('View User Data', 'eco-profile-master'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (function_exists('get_epm_user_listings')) get_epm_user_listings(); ?>
        </tbody>
        <tfoot>
            <tr>
                <th><?php _e('Profile Image', 'eco-profile-master'); ?></th>
                <th><?php _e('Name', 'eco-profile-master'); ?></th>
                <th><?php _e('Email', 'eco-profile-master'); ?></th>
                <th><?php _e('Joining Date', 'eco-profile-master'); ?></th>
            </tr>
        </tfoot>
    </table>
</div>