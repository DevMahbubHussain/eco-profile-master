<?php

namespace EcoProfile\Master\Frontend;

class Users
{
    /**
     * Users constructor.
     *
     * Initializes the Users class and sets up the 'epm-user-listings' shortcode.
     */
    public function __construct()
    {
        add_shortcode('epm-user-listings', array($this, 'epm_render_users_listing'));
    }

    /**
     * Render Users Listing
     *
     * Outputs the user listings UI, provided the user is logged in. It utilizes the 'users_view.php' template.
     *
     * @return string The HTML content of the user listings.
     */
    public function epm_render_users_listing()
    {
        ob_start();
        $this->epm_render_user_listings_ui();
        return ob_get_clean();
    }

    /**
     * Render User Listings UI
     *
     * Displays the user listings user interface by including the 'users_view.php' template.
     */
    private function epm_render_user_listings_ui()
    {
        if (is_user_logged_in()) {
            require_once __DIR__ . '/views/users/users_view.php';
        } else {
            echo '<p class="text-left">' . sprintf(__('You are currently not logged in. <a href="%s">login »</a>', 'eco-profile-master'), home_url('/login')) . '</p>';
        }
    }
}
