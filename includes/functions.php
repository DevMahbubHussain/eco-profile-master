<?php

/**
 * All functions
 *
 * @package eco-profile-master-functions
 */


/**
 * Insert a new address
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function wd_ac_insert_address($args = [])
{
    global $wpdb;

    if (empty($args['name'])) {
        return new \WP_Error('no-name', __('You must provide a name.', 'wedevs-academy'));
    }

    $defaults = [
        'name'       => '',
        'address'    => '',
        'phone'      => '',
        'created_by' => get_current_user_id(),
        'created_at' => current_time('mysql'),
    ];

    $data = wp_parse_args($args, $defaults);

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'ac_addresses',
        $data,
        [
            '%s',
            '%s',
            '%s',
            '%d',
            '%s'
        ]
    );

    if (!$inserted) {
        return new \WP_Error('failed-to-insert', __('Failed to insert data', 'wedevs-academy'));
    }

    return $wpdb->insert_id;
}




function user_listing($name, $lastname, $vechile, $dropdown)
{
    update_option('awesome_firstname', $name);
    update_option('awesome_lastname', $lastname);
    update_option('vehicle2', $vechile);
    update_option('sandbox_dropdown', $dropdown);
?>
    <div class="updated">
        <p>Your fields were saved!</p>
    </div>
<?php
}



/**
 * Settings API utility functions
 */


/**
 * Get the value of a settings field
 *
 * @param [type] $option
 * @param [type] $section
 * @param string $default
 * @return void
 */
function get_options_data($option, $section, $default = '')
{

    $options = get_option($section);

    if (isset($options[$option])) {
        return $options[$option];
    }

    return $default;
}
