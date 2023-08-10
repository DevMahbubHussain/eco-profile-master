<?php

namespace EcoProfile\Master\Frontend;

/**
 * Shortcode Handler class
 */

class Shortcode
{

    /**
     * Initializes the class
     */
    function __construct()
    {
        add_shortcode('eco-profile-master', [$this, 'epm_render_shortcode']);
    }

    /**
     * Shortcode Handler class
     *
     * @param [type] $atts
     * @param string $content
     * @return void
     */
    public function epm_render_shortcode($atts, $content = '')
    {
        wp_enqueue_style('ep-master-css');
        return '<div class="center bg">Hello From Shortcode</div>';
    }


}
