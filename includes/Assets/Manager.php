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
        add_action('init', [$this, 'register_all_scripts']);
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
            'ep-master-css' => [
                'src' => EP_MASTER_BUILD . '/index.css',
                'version' => EP_MASTER_VERSION,
                'deps' => []
            ]
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
            'ep-master-js' => [
                'src'       => EP_MASTER_BUILD . '/index.js',
                'version'   => $dependency['version'],
                'deps'      => $dependency['dependencies'],
                'in_footer' => true,
            ],
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
     * Enqueue admin styles and scripts.
     *
     *  Loads the JS and CSS only on the Eco Profile Master admin page.
     *
     * @return void
     */

    public function epm_admin_register_assets()
    {
        // Check if we are on the admin page and page=eco-profile-master.
        if (!is_admin() || !isset($_GET['page']) || sanitize_text_field(wp_unslash($_GET['page'])) !== 'eco-profile-master' &&  sanitize_text_field(wp_unslash($_GET['page'])) !== 'eco-profile-master-settings' &&  sanitize_text_field(wp_unslash($_GET['page'])) !== 'eco-profile-master-user-listing' &&  sanitize_text_field(wp_unslash($_GET['page'])) !== 'eco-profile-master-admin-bar') {
            return;
        }
        wp_enqueue_style('ep-master-css');
        wp_enqueue_script('ep-master-js');
    }

    public function epm_wp_register_assets()
    {
        wp_enqueue_style('ep-master-css');
        // wp_enqueue_script('ep-master-js');
    }
}
