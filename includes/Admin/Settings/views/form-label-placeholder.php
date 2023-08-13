<div class="wrap">
    <h2><?php esc_html_e('Label and Placeholder Configuration', 'eco-profile-master'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <div class="two-column">
            <div class="column">
                <?php
                settings_fields('eco-profile-master-form-labels');
                do_settings_sections('eco-profile-master-form-labels');

                // Render the first 10 fields here
                $field_count = 0;
                foreach ($fields as $field => $field_data) {
                    if ($field_count >= 10) {
                        break;
                    }

                    $this->epm_render_field($field, $field_data);
                    $field_count++;
                }
                ?>
            </div>
            <div class="column">
                <?php
                // Render the remaining fields (from 11 to 20) here
                foreach ($fields as $field => $field_data) {
                    if ($field_count >= 20) {
                        $this->epm_render_field($field, $field_data);
                    }
                    $field_count++;
                }
                ?>
            </div>
        </div>
        <?php submit_button(); ?>
    </form>
</div>