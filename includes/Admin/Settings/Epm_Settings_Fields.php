<?php

namespace EcoProfile\Master\Admin\Settings;

/**
 * Settings API Field Wrapper class.
 */
class Epm_Settings_Fields
{
    /**
     * Settings api class  variable
     *
     */
    private $settings_api;

    /**
     * Constructor
     */

    function __construct()
    {
        $this->settings_api = new Epm_Settings();
        add_action('admin_init', array($this, 'admin_init'));
    }

    /**
     * Set the settings.
     * 
     * Initialize settings.
     * @return void
     */
    public function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->get_settings_fields());
        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Settings sections.
     *
     * @return array settings sections.
     */
    public function get_settings_sections()
    {
        $sections = array(
            array(
                'id'    => 'epm_basics',
                'title' => __('Basic Settings', 'eco-profile-master')
            ),
            array(
                'id'    => 'epm_advanced',
                'title' => __('Advanced Settings', 'eco-profile-master')
            ),
            array(
                'id'    => 'epm_fields',
                'title' => __('Fields', 'eco-profile-master')
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields()
    {
        $settings_fields = array(
            'epm_basics' => array(
                array(
                    'name'    => 'epm_automatically_login',
                    'label'   => __('Automatically Log In:', 'echo-profile-master'),
                    'desc'    => __('Select "Yes" to automatically log in new users after successful registration.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'epm_email_confirmation_activated',
                    'label'   => __('Email Confirmation Activated:', 'echo-profile-master'),
                    'desc'    => __('This works with front-end forms only.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'epm_roles_editor_activated',
                    'label'   => __('Roles Editor Activated:', 'echo-profile-master'),
                    'desc'    => __('Roles Editor Activated.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'epm_admin_approval_features',
                    'label'   => __('Admin Approval Feature:', 'echo-profile-master'),
                    'desc'    => __('You decide who is a user on your website. Get notified via email or approve multiple users at once from the WordPress UI.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'    => 'epm_loginwith',
                    'label'   => __('Allow Users to Log in With:', 'echo-profile-master'),
                    'desc'    => __('Users can Log In with either their Username or their Email or only username or only email.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'usernameemail',
                    'options' => array(
                        'usernameemail' => 'Username and Email',
                        'username'  => 'Username',
                        'email'  => 'Email'
                    )
                ),
                array(
                    'name'    => 'epm_lost_password_page',
                    'label'   => __('Select Recover Password Page:', 'echo-profile-master'),
                    'desc'    => __('Select the page which contains the [epm-recover-password] shortcode.', 'echo-profile-master'),
                    'type'    => 'select',
                    'default' => 'usernameemail',
                    'options' =>  $this->get_my_pages(),

                ),
            ),
            'epm_advanced' => array(
                array(
                    'name'  => 'epm_email_confirmation',
                    'label' => __('Email confirmation when changing user email address', 'eco-profile-master'),
                    'desc'  => __('If checked, an activation email is sent for the new email address.', 'eco-profile-master'),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'  => 'epm_remember_me',
                    'label' => __('Remember me checked by default', 'eco-profile-master'),
                    'desc'  => __('Check the Remember Me checkbox on Login forms, by default.', 'eco-profile-master'),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'  => 'epm_auto_login_pass_reset',
                    'label' => __('Automatically log in users after password reset', 'eco-profile-master'),
                    'desc'  => __('Automatically log in users after they reset their password using the Recover Password form., by default.', 'eco-profile-master'),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'  => 'epm_auto_generate_pass',
                    'label' => __('Automatically generate password for users', 'eco-profile-master'),
                    'desc'  => __('By checking this option, the password will be automatically generated and emailed to the user.', 'eco-profile-master'),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'  => 'epm_first_lastname_captitilize',
                    'label' => __("Always capitalize 'First Name' and 'Last Name' default fields", 'eco-profile-master'),
                    'desc'  => __('If you have these fields in your forms, they will be always saved with the first letter as uppercase.', 'eco-profile-master'),
                    'type'  => 'checkbox'
                ),

            ),
            'epm_fields' => array(
                array(
                    'name'  => 'epm_profile_image',
                    'label' => __('Profile image', 'eco-profile-master'),
                    'desc'  => __('If checked, image uploader will enable.', 'eco-profile-master'),
                    'type'  => 'checkbox',
                    'default' => 'on',
                ),
                array(
                    'name'  => 'epm_educations',
                    'label' => __('User Education', 'eco-profile-master'),
                    'desc'  => __('<strong>Education from will apear in profile Enable  by upgrading to Basic or PRO versions</strong>', 'eco-profile-master'),
                    'type' => 'html',
                ),
                array(
                    'name'  => 'epm_skills',
                    'label' => __('User Skills Sets', 'eco-profile-master'),
                    'desc'  => __('<strong>Skill Sets from will apear in profile Enable  by upgrading to Basic or PRO versions</strong>', 'eco-profile-master'),
                    'type' => 'html',
                ),
                array(
                    'name'  => 'epm_certificates',
                    'label' => __('User Certificates', 'eco-profile-master'),
                    'desc'  => __('<strong>Certificates from will apear in profile Enable  by upgrading to Basic or PRO versions</strong>', 'eco-profile-master'),
                    'type' => 'html',
                ),
                array(
                    'name'  => 'epm_work_experience',
                    'label' => __('Work Experience', 'eco-profile-master'),
                    'desc'  => __('<strong>Work Experience from will apear in profile Enable  by upgrading to Basic or PRO versions</strong>', 'eco-profile-master'),
                    'type' => 'html',
                ),
                array(
                    'name'  => 'epm_portfolio',
                    'label' => __('Portfolio', 'eco-profile-master'),
                    'desc'  => __('<strong>Portfolio Options will apear in profile Enable  by upgrading to Basic or PRO versions</strong>', 'eco-profile-master'),
                    'type' => 'html',
                ),
            )
        );

        return $settings_fields;
    }

    /**
     * Plugin settings page.
     *
     * @return void
     */
    public function plugin_settings_page()
    {
        $template = __DIR__ . '/views/epm_settings_form.php';
        if (file_exists($template)) {
            include $template;
        }
    }

    public function test()
    {
        echo "Hello World";
    }


    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_my_pages()
    {
        $pages = get_pages();
        $pages_options = array();
        if ($pages) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }
}
