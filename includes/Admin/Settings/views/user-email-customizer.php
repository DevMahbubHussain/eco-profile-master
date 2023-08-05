<div class="flex flex-col lg:flex-row h-screen">
    <!-- Left Side (70% on larger screens, full width on smaller screens) -->
    <div class="lg:w-7/12 bg-gray-200">
        <form method="POST" action="">
            <input type="hidden" name="updated" value="true">
            <?php wp_nonce_field('advanced_settings_action', 'advanced_settings_nonce'); ?>
            <div class="bg-white w-full p-6">
                <div class="font-bold text-xl mb-4">
                    <h3 class="p-1 font-medium text-base border"><?php _e('Common Settings', 'eco-profile-master') ?></h3>
                </div>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label class="epm_label" for="epm_for_name"><?php _e('From (name)', 'eco-profile-master'); ?></label></th>
                            <td>
                                <input class="regular-text" type="text" id="epm_for_name" name="epm_for_name" value="{{site_name}}">
                            </td>
                        </tr>
                        <tr>
                            <th><label class="epm_label" for="epm_from_reply_to_email"><?php _e('From (reply-to email)', 'eco-profile-master'); ?></label></th>
                            <td>
                                <input class="regular-text" type="text" id="epm_from_reply_to_email" name="epm_from_reply_to_email" value="{{reply_to}}">
                                <p class="epm-description"><?php _e('Must be a valid email address or the tag {{reply_to}} which defaults to the administrator email', 'eco-profile-master'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white w-full p-6">
                <div class="font-bold text-xl mb-4">
                    <h3 class="p-1 font-medium text-base border"><?php _e('Default Registration', 'eco-profile-master') ?></h3>
                </div>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label class="epm_label" for="epm_user_emailc_default_registration_email_enabled"><?php _e('Enable email', 'eco-profile-master'); ?></label></th>
                            <td>
                                <input type="checkbox" id="epm_user_emailc_default_registration_email_enabled" name="epm_user_emailc_default_registration_email_enabled" value="1" checked>
                            </td>
                        </tr>
                        <tr>
                            <th><label class="epm_label" for="epm_user_emailc_default_registration_email_subject"><?php _e('Email Subject', 'eco-profile-master'); ?></label></th>
                            <td>
                                <input class="regular-text" type="text" id="epm_user_emailc_default_registration_email_subject" name="epm_user_emailc_default_registration_email_subject" value="A new account has been created for you on {{site_name}}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>


    </div>

    <!-- Right Side (30% on larger screens, full width on smaller screens) -->
    <div class="lg:w-5/12 bg-gray-300">
        <!-- Content for the right side goes here -->
        <div class="collapsible-panels">
            <div class="panel">
                <div class="panel-header">Panel 1</div>
                <div class="panel-content">
                    <p>Content for Panel 1 goes here.</p>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">Panel 2</div>
                <div class="panel-content">
                    <p>Content for Panel 2 goes here.</p>
                </div>
            </div>
            <!-- Add more panels as needed -->
        </div>
    </div>
</div>