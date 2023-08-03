<div class="wrap">
    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'eco-profile-master-general-settings';
    $admin_url = admin_url('admin.php');
    ?>
    <h2>
        <?php _e('Eco Profile Master Settings', 'eco-profile-master'); ?> <a href="#" target="_blank" data-code="f223" class="epm-docs-link dashicons dashicons-editor-help"></a>
    </h2>
    <?php
    require_once __DIR__ . '/form-navigation.php';
    if ($active_tab == 'eco-profile-master-general-settings') {
        require_once __DIR__ . '/general-settings.php';
    } elseif ($active_tab == 'eco-profile-master-admin-bar-settings') {
        require_once __DIR__ . '/admin-bar-settings.php';
    } elseif ($active_tab == 'eco-profile-master-toolbox-settings') {
        require_once __DIR__ . '/advanced-settings.php';
    } elseif ($active_tab == 'eco-profile-user-email-customizer') {
        require_once __DIR__ . '/user-email-customizer.php';
    }
    ?>
</div>