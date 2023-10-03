<?php
// load_user_details.php

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id > 0) {
    // Fetch user details here
    echo "User ID received: " . $user_id;
} else {
    echo "Invalid user ID.";
}











// if (isset($_GET['user_id'])) {
//     $user_id = $_GET['user_id'];

//     // Fetch user details based on $user_id
//     $user = get_user_by('ID', $user_id);

//     // Output the user details
//     echo '<h2>' . esc_html__('User Profile', 'your-text-domain') . '</h2>';
//     echo '<p>' . esc_html__('Username: ', 'your-text-domain') . $user->user_login . '</p>';
//     echo '<p>' . esc_html__('First Name: ', 'your-text-domain') . $user->first_name . '</p>';
//     echo '<p>' . esc_html__('Last Name: ', 'your-text-domain') . $user->last_name . '</p>';
//     // Add more user details as needed
// }
