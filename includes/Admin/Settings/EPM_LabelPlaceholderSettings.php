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
    private $fields; // Declare the class property
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
        //$fields =  $this->fields;
        $this->fields = array(
            'username' => array(
                'label' => __('Username', 'eco-profile-master'),
                'placeholder' => __('Enter your username', 'eco-profile-master'),
                'type' => 'text', // Field type: text, textarea, file, radio, checkbox, select
            ),
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
            'nickname' => array(
                'label' => __('Nickname', 'eco-profile-master'),
                'placeholder' => __('Enter your Nickname', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'email' => array(
                'label' => __('Email', 'eco-profile-master'),
                'placeholder' => __('Enter your email', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'phone' => array(
                'label' => __('Phone', 'eco-profile-master'),
                'placeholder' => __('Enter your phone', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'website' => array(
                'label' => __('Website', 'eco-profile-master'),
                'placeholder' => __('Enter your website url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'biographical' => array(
                'label' => __('Biographical Info', 'eco-profile-master'),
                'placeholder' => __('Enter your biographical info', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'password' => array(
                'label' => __('Password', 'eco-profile-master'),
                'placeholder' => __('Enter your password', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'repassword' => array(
                'label' => __('Repeat Password', 'eco-profile-master'),
                'placeholder' => __('Repeat Password', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'occupation' => array(
                'label' => __('Occupation', 'eco-profile-master'),
                'placeholder' => __('Select your Occupation', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'religion' => array(
                'label' => __('Religion', 'eco-profile-master'),
                'placeholder' => __('Select your Religion', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'skin' => array(
                'label' => __('Skin Color', 'eco-profile-master'),
                'placeholder' => __('Select your Skin Color', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'gender' => array(
                'label' => __('Gender', 'eco-profile-master'),
                'placeholder' => __('Select your Gender', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'blood' => array(
                'label' => __('Blood Group', 'eco-profile-master'),
                'placeholder' => __('Select your Blood Group', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'facebook' => array(
                'label' => __('Facebook Url', 'eco-profile-master'),
                'placeholder' => __('Enter your facebook url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'twitter' => array(
                'label' => __('Twitter Url', 'eco-profile-master'),
                'placeholder' => __('Enter your twitter url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'linkedin' => array(
                'label' => __('LinkedIn Url', 'eco-profile-master'),
                'placeholder' => __('Enter your linkedin url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'youtube' => array(
                'label' => __('Youtube Url', 'eco-profile-master'),
                'placeholder' => __('Enter your youtube url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            'instagram' => array(
                'label' => __('Instagram Url', 'eco-profile-master'),
                'placeholder' => __('Enter your youtube url', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),

            'image' => array(
                'label' => __('Profile Image', 'eco-profile-master'),
                'type' => 'text', // Field type
            ),
            // Add more fields here
        );

        foreach ($this->fields as $field => $field_data) {
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
                    'default_placeholder' => isset($field_data['placeholder']) ? $field_data['placeholder'] : '', // Pass default placeholder value
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
        $values = $this->get_label_placeholder_option(); // Retrieve saved label/placeholder values
        $label = isset($values[$field]['label']) ? $values[$field]['label'] : $args['default_label'];
        $placeholder = isset($values[$field]['placeholder']) ? $values[$field]['placeholder'] : $args['default_placeholder'];

        foreach (array('label', 'placeholder') as $type) {
            if ($field === 'image' && $type === 'placeholder') {
                // No need to render a placeholder input for file type
            } else {
                echo '<label for="' . $field . '_' . $type . '">' . esc_html__(ucfirst($type) . ':', 'eco-profile-master') . '</label>';
                echo '<input type="text" id="' . $field . '_' . $type . '" name="epm_form_label_placeholder[' . $field . '][' . $type . ']" value="' . esc_attr($type === 'label' ? $label : $placeholder) . '" class="regular-text" maxlength="50">';
                echo '<br>';
            }
        }
    }

    /**
     * Sanitize the label and placeholder settings input.
     *
     * @param array $input The input values to be sanitized.
     *
     * @return array The sanitized label and placeholder settings.
     *
     * @since 1.0.0
     */

    public function epm_sanitize_label_placeholder_settings($input)
    {
        // Initialize an empty array to store the sanitized values
        $sanitized_values = array();

        // Loop through each input field
        foreach ($input as $field => $field_data) {
            // Sanitize label and placeholder values
            $sanitized_label = sanitize_text_field($field_data['label']);
            $sanitized_placeholder = sanitize_text_field($field_data['placeholder']);

            // Add sanitized values to the array
            $sanitized_values[$field]['label'] = $sanitized_label;
            $sanitized_values[$field]['placeholder'] = $sanitized_placeholder;
        }

        // Return the sanitized values
        return $sanitized_values;
    }
}
