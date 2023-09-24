<?php

namespace EcoProfile\Master\Assets;

/**
 * Asset Manager class.
 *
 * Responsible for managing all of the assets (CSS, JS, Images, Locales).
 */

class Manager
{
    /**
     * Class Constructor
     */
    public function __construct()
    {
        add_action('init', array($this, 'register_all_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'epm_wp_register_assets'));
        add_action('admin_enqueue_scripts', array($this, 'epm_admin_register_assets'));
    }

    /**
     * Register all scripts and styles.
     *
     * @return void
     */
    public function register_all_scripts()
    {
        $this->register_styles($this->get_styles());
        $this->register_scripts($this->get_scripts());
    }

    /**
     * Get all styles.
     *
     * @return array
     */

    public function get_styles(): array
    {
        return [
            'epm-master-css' => [
                'src' => EP_MASTER_BUILD . '/index.css',
                'version' => EP_MASTER_VERSION,
                'deps' => []
            ],
            'epm-toaster-css' => [
                'src'       => EP_MASTER_ASSETS . '/css/toastr.min.css',
                'version' => EP_MASTER_VERSION,
                'deps'      => [],
            ],
        ];
    }

    /**
     * Get all scripts.
     *
     * @return array
     */

    public function get_scripts(): array
    {
        $dependency = require_once EP_MASTER_DIR . '/build/index.asset.php';
        return [
            'epm-master-js' => [
                'src'       => EP_MASTER_BUILD . '/index.js',
                'version'   => 1,
                'deps'      => 1,
                // 'version'   => $dependency[1],
                // 'deps'      => $dependency[1],
                // 'version' => 1,
                // 'deps' => 1,
                'in_footer' => true,
            ],
            // 'epm-front-end-js' => [
            //     'src'       => EP_MASTER_ASSETS . '/js/front-end.js',
            //     'version'   => $dependency['version'],
            //     'deps'      => ['jquery'],
            //     'in_footer' => true,
            // ],
            // 'epm-toaster-js' => [
            //     'src'       => EP_MASTER_ASSETS . '/js/toastr.min.js',
            //     'version'   => $dependency['version'],
            //     'deps'      => ['jquery'],
            //     'in_footer' => true,
            // ],
            // 'epm-ace-js-rules' => [
            //     'src'       => EP_MASTER_ASSETS . '/js/ace-rules.js',
            //     'version' => filemtime(EP_MASTER_PATH . '/js/ace-rules.js'),
            //     'deps'      => ['epm-ace-js'],
            //     'in_footer' => true,
            // ],
        ];
    }

    /**
     * Register styles.
     *
     * @return void
     */
    public function register_styles(array $styles)
    {
        foreach ($styles as $handle => $style) {
            wp_register_style($handle, $style['src'], $style['deps'], $style['version']);
        }
    }

    /**
     * Register scripts.
     *
     * @return void
     */
    public function register_scripts(array $scripts)
    {
        foreach ($scripts as $handle => $script) {
            wp_register_script($handle, $script['src'], $script['deps'], $script['version'], $script['in_footer']);
        }
    }

    /**
     * Enqueue admin styles and scripts for Eco Profile Master.
     */
    public function epm_admin_register_assets()
    {
        if ($this->epm_is_valid_admin_page()) {
            $this->epm_enqueue_admin_styles();
            $this->epm_enqueue_admin_scripts();
        }
    }

    /**
     * Check if the current page is a valid Eco Profile Master admin page.
     *
     * @return bool True if it's a valid admin page, false otherwise.
     */
    private function epm_is_valid_admin_page()
    {
        $valid_pages = [
            'eco-profile-master',
            'eco-profile-master-settings',
            'eco-profile-master-user-listing',
            'eco-profile-master-admin-bar',
            'eco-profile-master-form-labels'
        ];

        return is_admin() && isset($_GET['page']) && in_array(sanitize_text_field(wp_unslash($_GET['page'])), $valid_pages);
    }

    /**
     * Enqueue admin-specific styles for Eco Profile Master.
     */
    private function epm_enqueue_admin_styles()
    {
        // Enqueue necessary admin styles
        wp_enqueue_style('epm-master-css');
    }

    /**
     * Enqueue admin-specific scripts for Eco Profile Master.
     */
    private function epm_enqueue_admin_scripts()
    {
        // Enqueue necessary admin scripts
        wp_enqueue_script('epm-master-js');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-tabs');
    }

    /**
     * Enqueues styles and scripts if the current post contains the [epm-register] shortcode.
     *
     * @since 1.0.0
     *
     * @global WP_Post $post The current post object.
     */
    public function epm_wp_register_assets()
    {
        global $post;

        // Check if the current post content contains the specific shortcode
        if (is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'epm-login') || has_shortcode($post->post_content, 'epm-register') || has_shortcode($post->post_content, 'epm-pass-recover') || has_shortcode($post->post_content, 'epm-password-reset-form'))) {
            wp_enqueue_style('epm-master-css');
            wp_enqueue_style('epm-toaster-css');
            wp_enqueue_script('epm-toaster-js');
            wp_enqueue_script('epm-master-js');
            wp_enqueue_script('epm-front-end-js');
            
        }
    }
}
