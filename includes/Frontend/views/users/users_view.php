<div class="max-w-screen-2xl mx-auto px-8 md:px-16 lg:px-24 py-5 my-10 w-100-grid">
    <h3 class="text-white bg-teal-950 background-color: rgb(4 47 46); p-5"><?php _e('Users Listing', 'eco-profile-master'); ?></h3>
    <table id="userslist" class="display py-5" style="width:100%!important">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Biographical</th>
                <th>Profile Image</th>
                <!-- <th>Facebook</th>
                <th>Twitter</th>
                <th>Linkedin</th>
                <th>Youtube</th>
                <th>Instagram </th> -->
                <th>Joining date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            get_epm_user_listings();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Biographical</th>
                <th>Profile Image</th>
                <!-- <th>Facebook</th>
                <th>Twitter</th>
                <th>Linkedin</th>
                <th>Youtube</th>
                <th>Instagram </th> -->
                <th>Joining date</th>
            </tr>
        </tfoot>
    </table>
</div>