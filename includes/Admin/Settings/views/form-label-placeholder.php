<div class="wrap epm-label-placeholder-settings">
    <h2><?php esc_html_e('Label and Placeholder Configuration', 'eco-profile-master'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php settings_fields('eco-profile-master-form-labels'); ?>
        <?php do_settings_sections('eco-profile-master-form-labels'); ?>
        <?php submit_button(); ?>
    </form>
</div>