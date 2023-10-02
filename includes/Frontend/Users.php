<?php

namespace EcoProfile\Master\Frontend;

class Users
{

    public function __construct()
    {
        add_shortcode('epm-user-listings', array($this, 'epm_render_users_listing'));
    }

    public function epm_render_users_listing()
    {
        ob_start();
        $this->epm_render_user_listings_ui();
        return ob_get_clean();
    }

    private function epm_render_user_listings_ui()
    {
        if (is_user_logged_in()) {
            require_once  __DIR__ . '/views/users/users_view.php';
        } else {
            echo '<p class="text-left">' . sprintf(__('You are currently not logged in. <a href="%s">login »</a>', 'eco-profile-master'), home_url('/login')) . '</p>';
        }
    }
}
