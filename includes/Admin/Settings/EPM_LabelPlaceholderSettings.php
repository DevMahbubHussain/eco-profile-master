<?php

namespace EcoProfile\Master\Admin\Settings;

/**
 * Class EPM_LabelPlaceholderSettings
 * Handles the registration of settings and rendering of the label and placeholder settings page.
 * 
 * @since 1.0.0
 */
class EPM_LabelPlaceholderSettings
{
    /**
     * Constructor.
     * Hooks into the 'admin_init' action to register settings and fields.
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'epm_register_settings'));
    }

    /**
     * Callback function to render the plugin settings page.
     */
    public function epm_form_fields_label_plugin_page()
    {
        if (isset($_GET['page']) && sanitize_text_field(wp_unslash($_GET['page'])) == 'eco-profile-master-form-labels') {
            $template = __DIR__ . '/views/form-label-placeholder.php';
            if (file_exists($template)) {
                include $template;
            }
        }
    }

    /**
     * Retrieves the label and placeholder option values.
     *
     * @since 1.0.0
     * @return array Array of label and placeholder values.
     */
    public function get_label_placeholder_option()
    {
        $values = get_option('epm_form_label_placeholder', array());
        return $values;
    }

    /**
     * Registers settings sections and fields for the label and placeholder settings page.
     *
     * @since 1.0.0
     */
    public function epm_register_settings()
    {
        add_settings_section('epm_form_label_placeholder_section', '', null, 'eco-profile-master-form-labels');

        $fields = array(
            'firstname' => array(
                'label' => __('First Name', 'eco-profile-master'),
                'placeholder' => __('Enter your first name', 'eco-profile-master'),
                'type' => 'text', // Field type: text, textarea, file, radio, checkbox, select
            ),
            'lastname' => array(
                'label' => __('Last Name', 'eco-profile-master'),
                'placeholder' => __('Enter your last name', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'phone' => array(
                'label' => __('Phone', 'eco-profile-master'),
                'placeholder' => __('Enter your phone', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'email' => array(
                'label' => __('Email', 'eco-profile-master'),
                'placeholder' => __('Enter your email', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            // Add more fields here
        );

        foreach ($fields as $field => $field_data) {
            add_settings_field(
                $field . '_field',
                $field_data['label'],
                array($this, 'epm_render_field'),
                'eco-profile-master-form-labels', // Page slug
                'epm_form_label_placeholder_section',
                array(
                    'field' => $field,
                    'type' => $field_data['type'],
                    'default_label' => $field_data['label'], // Pass default label value
                    'default_placeholder' => $field_data['placeholder'], // Pass default placeholder value
                    'values' => $this->get_label_placeholder_option() // Retrieve saved label/placeholder values
                )
            );

            register_setting('eco-profile-master-form-labels', 'epm_form_label_placeholder', array($this, 'epm_sanitize_label_placeholder_settings'));
        }
    }
    /**
     * Callback to render the form fields for label and placeholder configuration.
     *
     * @since 1.0.0
     *
     * @param array $args Field arguments.
     */
    public function epm_render_field($args)
    {
        $field = $args['field'];
        $type = $args['type'];
        $values = $this->get_label_placeholder_option(); // Retrieve saved label/placeholder values
        $value = isset($values[$field]['value']) ? $values[$field]['value'] : '';
        $label = isset($values[$field]['label']) ? $values[$field]['label'] : $args['default_label'];
        $placeholder = isset($values[$field]['placeholder']) ? $values[$field]['placeholder'] : $args['default_placeholder'];

        switch ($type) {
            case 'textarea':
                echo '<textarea name="' . $field . '_field" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';
                break;
            case 'file':
                echo '<input type="file" name="' . $field . '_field" />';
                break;
            case 'radio':
                // Implement radio input later
                break;
            case 'checkbox':
                // Implement checkbox input later
                break;
            case 'select':
                // Implement select input later
                break;
            default:
                echo '<label for="' . $field . '_label">' . esc_html__('Label:', 'eco-profile-master') . '</label>';
                echo '<input type="text" id="' . $field . '_label" name="epm_form_label_placeholder[' . $field . '][label]" value="' . esc_attr($label) . '" class="regular-text">';
                echo '<br>';
                echo '<label for="' . $field . '_placeholder">' . esc_html__('Placeholder:', 'eco-profile-master') . '</label>';
                echo '<input type="text" id="' . $field . '_placeholder" name="epm_form_label_placeholder[' . $field . '][placeholder]" value="' . esc_attr($placeholder) . '" class="regular-text">';
        }
    }
}
