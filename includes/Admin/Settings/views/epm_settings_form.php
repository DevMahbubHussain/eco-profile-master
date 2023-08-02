<?php
echo '<div class="wrap">';
settings_errors();

$this->settings_api->show_navigation();
$this->settings_api->show_forms();
echo '</div>';
