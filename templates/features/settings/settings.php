<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general_settings';
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=eco-profile-master-settings&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>">General Settings</a>
        <a href="?page=eco-profile-master-settings&tab=advanced_settings" class="nav-tab <?php echo $active_tab == 'advanced_settings' ? 'nav-tab-active' : ''; ?>">Advanced Settings</a>
        <a href="?page=eco-profile-master-settings&tab=email_settings" class="nav-tab <?php echo $active_tab == 'email_settings' ? 'nav-tab-active' : ''; ?>">Email Settings</a>
    </h2>
    <form action="options.php" method="post">
        <?php
        if ($active_tab == 'general_settings') {
            settings_fields('epm_general_settings_group'); //epm_general_settings_group
            do_settings_sections('eco_profile_master_settings_page'); //general_settings_page
        } elseif ($active_tab == 'advanced_settings') {
            settings_fields('mv_slider_groupk');
            do_settings_sections('mv_slider_page2');
        } elseif ($active_tab == 'email_settings') {
            echo "Extar Content shows here";
        }
        submit_button('Save Settings');
        ?>
    </form>
</div>