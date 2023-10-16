<?php

/**
 * users profile details.
 */

if (!defined('ABSPATH')) {
    exit;
}
if (isset($_GET['view_profile'])) {
    $viewed_user_id =  isset($_GET['view_profile']) ? intval($_GET['view_profile']) : 0;
    $current_user_id = get_current_user_id();
    if ($viewed_user_id === $current_user_id) {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            if ($current_user && $current_user->ID) {
?>
                <div class="container mx-auto bg-orange-100 sm:p-16 override-max-width">
                    <div class="profile-head relative bg-teal-500 p-4 rounded-t-3xl">
                        <?php if (!empty($current_user->epm_user_avatar)) : ?>
                            <div class="profile-picture overflow-hidden absolute left-9 -bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                                <img class="overflow-hidden object-cover" src="<?php echo esc_url($current_user->epm_user_avatar); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                        <?php else : ?>
                            <div class="profile-picture overflow-hidden absolute left-9 -bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                                <img class="overflow-hidden object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhp.png'; ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($current_user->epm_user_cover_image)) : ?>
                            <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                                <img class="w-full h-full object-cover" src="<?php echo esc_url($current_user->epm_user_cover_image); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                        <?php else : ?>
                            <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                                <img class="w-full h-full object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhc.png'; ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="basic-info absolute left-48 bottom-6">
                            <?php
                            if (!empty($current_user->first_name) && !empty($current_user->last_name)) {
                                $full_name = trim($current_user->first_name . ' ' . $current_user->last_name);
                            ?>
                                <h2 class="fullname text-white text-3xl font-semibold"><?php echo esc_html($full_name); ?></h2>
                            <?php } ?>

                            <h3 class="identity bg-orange-400 px-3 py-[4px] mt-1 rounded-lg space-x-3 text-xl"><span class="age block sm:inline">
                                    <?php
                                    $date_of_birth = $current_user->epm_user_birthdate;
                                    if (!empty($date_of_birth)) {
                                        $birth_date = new DateTime($date_of_birth);
                                        $current_date = new DateTime();
                                        $age = $current_date->diff($birth_date)->y;
                                    ?>
                                        <strong><?php echo esc_html($age); ?></strong> <?php _e('Years Old', 'eco-pprofile-master'); ?>
                                    <?php } ?>
                                    <?php if (!empty($current_user->epm_user_gender)) : ?>
                                        <span class="gender mr-1"><strong><?php echo esc_html($current_user->epm_user_gender); ?></strong></span>
                                    <?php endif; ?>

                                    <?php if (!empty($current_user->epm_user_occupation)) : ?>
                                        <span class="gender"><strong><?php echo esc_html($current_user->epm_user_occupation); ?></strong></span>
                                    <?php endif; ?>
                            </h3>
                        </div>
                        <div class="additional-info absolute right-4 top-4 bg-teal-500 bg-opacity-60 shadow-xl border-b-[6px] border-l-4 border-white rounded-bl-[60px] rounded-tl-[100px] p-3 flex flex-col items-end">
                            <?php if (!empty($current_user->epm_user_phone)) : ?>
                                <h4 class="contact-no text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                    <i class="fa-solid fa-phone text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                                    <strong class="font-bold text-slate-900"><?php _e('Call', 'eco-profile-master'); ?>:</strong>
                                    <a href="tel:<?php echo esc_attr($current_user->epm_user_phone); ?>" class="text-slate-900">
                                        <?php echo esc_html($current_user->epm_user_phone); ?>
                                    </a>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($current_user->user_email)) : ?>
                                <h4 class="email-address text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                    <i class="fa-solid fa-envelope text-white bg-orange-600 px-2 py-[6px] text-xs rounded-full ml-2"></i>
                                    <strong class="font-bold text-slate-900"><?php _e('E-mail', 'eco-profile-master'); ?>:</strong>
                                    <a href="mailto:<?php echo esc_attr($current_user->user_email); ?>" class="text-slate-900">
                                        <?php echo esc_html($current_user->user_email); ?>
                                    </a>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($current_user->user_url)) : ?>
                                <h4 class="website text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                    <i class="fa-solid fa-globe text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                                    <strong class="font-bold text-slate-900"><?php _e('Visit', 'eco-profile-master'); ?>:</strong>
                                    <a href="<?php echo esc_url($current_user->user_url); ?>" class="text-slate-900" target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_url($current_user->user_url); ?>
                                    </a>
                                </h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="profile-body py-4 flex flex-col space-y-3 md:flex md:flex-row md:space-x-6">
                        <div class="left-sec my-6 md:w-1/4">
                            <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                                <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Biological Info', 'eco-profile-master'); ?></h4>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Skin:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_skin); ?></strong></h5>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Blood Group:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_blood); ?></strong></h5>
                            </div>
                            <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                                <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Mailing Address', 'eco-profile-master') ?></h4>
                                <?php if (!empty($current_user->epm_user_house)) : ?>
                                    <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('House:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_house); ?></strong></h5>
                                <?php endif; ?>
                                <?php if (!empty($current_user->epm_user_road)) : ?>
                                    <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Road:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_road); ?></strong></h5>
                                <?php endif; ?>
                                <?php if (!empty($current_user->epm_user_location)) : ?>
                                    <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Location:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_location); ?></strong></h5>
                                <?php endif; ?>
                            </div>
                            <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                                <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Other Info', 'eco-profile-master'); ?></h4>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('First Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->first_name); ?></strong></h5>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Last Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->last_name); ?></strong></h5>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Religion:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_religion); ?></strong></h5>
                            </div>
                        </div>
                        <?php if (!empty($current_user->description)) : ?>
                            <div class="right-sec my-6 md:w-3/4 space-y-3">
                                <div class="personal-description space-y-3">
                                    <h3 class="text-3xl text-white font-medium bg-orange-300 rounded-full px-6 py-[8px] md:inline-block mt-6 text-center md:text-start mx-3"><?php _e('A Few Words About Myself', 'eco-profile-master'); ?></h3>
                                    <p class="font-medium text-xl px-4 md:px-0 text-justify md:text-start"><?php echo esc_html($current_user->description); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="profile-foot">
                        <?php
                        if (!empty($current_user->first_name) && !empty($current_user->last_name)) {
                            $full_name = trim($current_user->first_name . ' ' . $current_user->last_name);
                        ?>
                            <h4 class="text-center text-xl"><?php _e('Get Connected with', 'eco-profile-master') ?> <strong><?php echo esc_html($full_name); ?></strong></h4>
                        <?php } ?>

                        <ul class="social-links flex item-center justify-center text-white space-x-2 mx-auto w-2/3 my-5">
                            <?php if (!empty($current_user->epm_user_facebook)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($current_user->epm_user_facebook); ?>" class="bg-orange-600 px-4 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_twitter)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($current_user->epm_user_twitter); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_linkedin)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($current_user->epm_user_linkedin); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_youtube)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($current_user->epm_user_youtube); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_instagram)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($current_user->epm_user_instagram); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
        <?php
            }
        }
    }
} elseif (isset($_GET['user_id']) && isset($_GET['username'])) {
    $user_id = $_GET['user_id'];
    $username = $_GET['username'];
    if ($user_id && !empty($username)) {
        // render all html based data here for profile details
        $user_id = $_GET['user_id'];
        $user = get_user_by('ID', $user_id);
        ?>
        <div class="container mx-auto bg-orange-100 sm:p-16 override-max-width">
            <div class="profile-head relative bg-teal-500 p-4 rounded-t-3xl">
                <?php if (!empty($user->epm_user_avatar)) : ?>
                    <div class="profile-picture overflow-hidden absolute left-9 bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                        <img class="overflow-hidden object-cover" src="<?php echo esc_url($user->epm_user_avatar); ?>" alt="<?php echo esc_attr($user->display_name); ?>">
                    </div>
                <?php else : ?>
                    <div class="profile-picture overflow-hidden absolute left-9 -bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                        <img class="overflow-hidden object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhp.png'; ?>" alt="<?php echo esc_attr($user->display_name); ?>">
                    </div>
                <?php endif; ?>
                <?php if (!empty($user->epm_user_cover_image)) : ?>
                    <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                        <img class="w-full h-full object-cover" src="<?php echo esc_url($user->epm_user_cover_image); ?>" alt="<?php echo esc_attr($user->display_name); ?>">
                    </div>
                <?php else : ?>
                    <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                        <img class="w-full h-full object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhc.png'; ?>" alt="<?php echo esc_attr($user->display_name); ?>">
                    </div>
                <?php endif; ?>
                <div class="basic-info absolute left-48 bottom-6">
                    <?php
                    if (!empty($user->first_name) && !empty($user->last_name)) {
                        $full_name = trim($user->first_name . ' ' . $user->last_name);
                    ?>
                        <h2 class="fullname text-white text-3xl font-semibold"><?php echo esc_html($full_name); ?></h2>
                    <?php } ?>

                    <h3 class="identity bg-orange-400 px-3 py-[4px] mt-1 rounded-lg space-x-3 text-xl"><span class="age block sm:inline">
                            <?php
                            $date_of_birth = $user->epm_user_birthdate;
                            if (!empty($date_of_birth)) {
                                $birth_date = new DateTime($date_of_birth);
                                $current_date = new DateTime();
                                $age = $current_date->diff($birth_date)->y;
                            ?>
                                <strong><?php echo esc_html($age); ?></strong> <?php _e('Years Old', 'eco-pprofile-master'); ?>
                            <?php } ?>
                            <?php if (!empty($user->epm_user_gender)) : ?>
                                <span class="gender mr-1"><strong><?php echo esc_html($user->epm_user_gender); ?></strong></span>
                            <?php endif; ?>

                            <?php if (!empty($user->epm_user_occupation)) : ?>
                                <span class="gender"><strong><?php echo esc_html($user->epm_user_occupation); ?></strong></span>
                            <?php endif; ?>
                    </h3>
                </div>
                <div class="additional-info absolute right-4 top-4 bg-teal-500 bg-opacity-60 shadow-xl border-b-[6px] border-l-4 border-white rounded-bl-[60px] rounded-tl-[100px] p-3 flex flex-col items-end">
                    <?php if (!empty($user->epm_user_phone)) : ?>
                        <h4 class="contact-no text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                            <i class="fa-solid fa-phone text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                            <strong class="font-bold text-slate-900"><?php _e('Call', 'eco-profile-master'); ?>:</strong>
                            <a href="tel:<?php echo esc_attr($user->epm_user_phone); ?>" class="text-slate-900">
                                <?php echo esc_html($user->epm_user_phone); ?>
                            </a>
                        </h4>
                    <?php endif; ?>
                    <?php if (!empty($user->user_email)) : ?>
                        <h4 class="email-address text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                            <i class="fa-solid fa-envelope text-white bg-orange-600 px-2 py-[6px] text-xs rounded-full ml-2"></i>
                            <strong class="font-bold text-slate-900"><?php _e('E-mail', 'eco-profile-master'); ?>:</strong>
                            <a href="mailto:<?php echo esc_attr($user->user_email); ?>" class="text-slate-900">
                                <?php echo esc_html($user->user_email); ?>
                            </a>
                        </h4>
                    <?php endif; ?>
                    <?php if (!empty($user->user_url)) : ?>
                        <h4 class="website text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                            <i class="fa-solid fa-globe text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                            <strong class="font-bold text-slate-900"><?php _e('Visit', 'eco-profile-master'); ?>:</strong>
                            <a href="<?php echo esc_url($user->user_url); ?>" class="text-slate-900" target="_blank" rel="noopener noreferrer">
                                <?php echo esc_url($user->user_url); ?>
                            </a>
                        </h4>
                    <?php endif; ?>
                </div>
            </div>
            <div class="profile-body py-4 flex flex-col space-y-3 md:flex md:flex-row md:space-x-6">
                <div class="left-sec my-6 md:w-1/4">
                    <?php if (isset($user->epm_user_skin) || isset($user->epm_user_blood)) : ?>
                        <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Biological Info', 'eco-profile-master'); ?></h4>
                            <?php if (isset($user->epm_user_skin) && !empty($user->epm_user_skin)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Skin:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($user->epm_user_skin); ?></strong></h5>
                            <?php endif; ?>

                            <?php if (isset($user->epm_user_blood) && !empty($user->epm_user_blood)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Blood Group:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($user->epm_user_blood); ?></strong></h5>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <?php if (isset($user->epm_user_house) || isset($user->epm_user_road) || isset($user->epm_user_location)) : ?>
                        <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Mailing Address', 'eco-profile-master') ?></h4>
                            <?php if (!empty($user->epm_user_house)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('House:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($user->epm_user_house); ?></strong></h5>
                            <?php endif; ?>
                            <?php if (!empty($user->epm_user_road)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Road:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($user->epm_user_road); ?></strong></h5>
                            <?php endif; ?>
                            <?php if (!empty($user->epm_user_location)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Location:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($user->epm_user_location); ?></strong></h5>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                        <?php
                        if (!empty($user->first_name) || !empty($user->last_name) || !isset($user->epm_user_religion)) :
                        ?>
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Other Info', 'eco-profile-master'); ?></h4>

                            <?php if (!empty($user->first_name)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('First Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($user->first_name); ?></strong></h5>
                            <?php endif; ?>

                            <?php if (!empty($user->last_name)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Last Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($user->last_name); ?></strong></h5>
                            <?php endif; ?>

                            <?php if (isset($user->epm_user_religion)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Religion:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($user->epm_user_religion); ?></strong></h5>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>
                </div>
                <?php if (!empty($user->description)) : ?>
                    <div class="right-sec my-6 md:w-3/4 space-y-3">
                        <div class="personal-description space-y-3">
                            <h3 class="text-3xl text-white font-medium bg-orange-300 rounded-full px-6 py-[8px] md:inline-block mt-6 text-center md:text-start mx-3"><?php _e('A Few Words About Myself', 'eco-profile-master'); ?></h3>
                            <p class="font-medium text-xl px-4 md:px-0 text-justify md:text-start"><?php echo esc_html($user->description); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="profile-foot">
                <?php
                if (!empty($user->first_name) && !empty($user->last_name)) {
                    $full_name = trim($user->first_name . ' ' . $user->last_name);
                ?>
                    <h4 class="text-center text-xl"><?php _e('Get Connected with', 'eco-profile-master') ?> <strong><?php echo esc_html($full_name); ?></strong></h4>
                <?php } ?>

                <ul class="social-links flex item-center justify-center text-white space-x-2 mx-auto w-2/3 my-5">
                    <?php if (!empty($user->epm_user_facebook)) : ?>
                        <li>
                            <a href="<?php echo esc_url($user->epm_user_facebook); ?>" class="bg-orange-600 px-4 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($user->epm_user_twitter)) : ?>
                        <li>
                            <a href="<?php echo esc_url($user->epm_user_twitter); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($user->epm_user_linkedin)) : ?>
                        <li>
                            <a href="<?php echo esc_url($user->epm_user_linkedin); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($user->epm_user_youtube)) : ?>
                        <li>
                            <a href="<?php echo esc_url($user->epm_user_youtube); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($user->epm_user_instagram)) : ?>
                        <li>
                            <a href="<?php echo esc_url($user->epm_user_instagram); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php
    }
} else {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        if ($current_user && $current_user->ID) {
        ?>
            <div class="container mx-auto bg-orange-100 sm:p-16 override-max-width">
                <div class="profile-head relative bg-teal-500 p-4 rounded-t-3xl">
                    <?php if (!empty($current_user->epm_user_avatar)) : ?>
                        <div class="profile-picture overflow-hidden absolute left-9 -bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                            <img class="overflow-hidden object-cover" src="<?php echo esc_url($current_user->epm_user_avatar); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                        </div>
                    <?php else : ?>
                        <div class="profile-picture overflow-hidden absolute left-9 -bottom-6 w-36 h-36 p-2 bg-orange-300 border-8 border-white rounded-full">
                            <img class="overflow-hidden object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhp.png'; ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($current_user->epm_user_cover_image)) : ?>
                        <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                            <img class="w-full h-full object-cover" src="<?php echo esc_url($current_user->epm_user_cover_image); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                        </div>
                    <?php else : ?>
                        <div class="cover-photo h-64 w-full overflow-hidden rounded-t-3xl">
                            <img class="w-full h-full object-cover" src="<?php echo EP_MASTER_ASSETS . '/images/dhc.png'; ?>" alt="<?php echo esc_attr($current_user->display_name); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="basic-info absolute left-48 bottom-6">
                        <?php
                        if (!empty($current_user->first_name) && !empty($current_user->last_name)) {
                            $full_name = trim($current_user->first_name . ' ' . $current_user->last_name);
                        ?>
                            <h2 class="fullname text-white text-3xl font-semibold"><?php echo esc_html($full_name); ?></h2>
                        <?php } ?>

                        <h3 class="identity bg-orange-400 px-3 py-[4px] mt-1 rounded-lg space-x-3 text-xl"><span class="age block sm:inline">
                                <?php
                                $date_of_birth = $current_user->epm_user_birthdate;
                                if (!empty($date_of_birth)) {
                                    $birth_date = new DateTime($date_of_birth);
                                    $current_date = new DateTime();
                                    $age = $current_date->diff($birth_date)->y;
                                ?>
                                    <strong><?php echo esc_html($age); ?></strong> <?php _e('Years Old', 'eco-pprofile-master'); ?>
                                <?php } ?>
                                <?php if (!empty($current_user->epm_user_gender)) : ?>
                                    <span class="gender mr-1"><strong><?php echo esc_html($current_user->epm_user_gender); ?></strong></span>
                                <?php endif; ?>

                                <?php if (!empty($current_user->epm_user_occupation)) : ?>
                                    <span class="gender"><strong><?php echo esc_html($current_user->epm_user_occupation); ?></strong></span>
                                <?php endif; ?>
                        </h3>
                    </div>
                    <div class="additional-info absolute right-4 top-4 bg-teal-500 bg-opacity-60 shadow-xl border-b-[6px] border-l-4 border-white rounded-bl-[60px] rounded-tl-[100px] p-3 flex flex-col items-end">
                        <?php if (!empty($current_user->epm_user_phone)) : ?>
                            <h4 class="contact-no text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                <i class="fa-solid fa-phone text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                                <strong class="font-bold text-slate-900"><?php _e('Call', 'eco-profile-master'); ?>:</strong>
                                <a href="tel:<?php echo esc_attr($current_user->epm_user_phone); ?>" class="text-slate-900">
                                    <?php echo esc_html($current_user->epm_user_phone); ?>
                                </a>
                            </h4>
                        <?php endif; ?>
                        <?php if (!empty($current_user->user_email)) : ?>
                            <h4 class="email-address text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                <i class="fa-solid fa-envelope text-white bg-orange-600 px-2 py-[6px] text-xs rounded-full ml-2"></i>
                                <strong class="font-bold text-slate-900"><?php _e('E-mail', 'eco-profile-master'); ?>:</strong>
                                <a href="mailto:<?php echo esc_attr($current_user->user_email); ?>" class="text-slate-900">
                                    <?php echo esc_html($current_user->user_email); ?>
                                </a>
                            </h4>
                        <?php endif; ?>
                        <?php if (!empty($current_user->user_url)) : ?>
                            <h4 class="website text-white text-sm sm:text-lg font-bold p-1 flex items-center space-x-2">
                                <i class="fa-solid fa-globe text-white bg-orange-600 px-2 py-2 text-[10px] rounded-full ml-2"></i>
                                <strong class="font-bold text-slate-900"><?php _e('Visit', 'eco-profile-master'); ?>:</strong>
                                <a href="<?php echo esc_url($current_user->user_url); ?>" class="text-slate-900" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_url($current_user->user_url); ?>
                                </a>
                            </h4>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="profile-body py-4 flex flex-col space-y-3 md:flex md:flex-row md:space-x-6">
                    <div class="left-sec my-6 md:w-1/4">
                        <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Biological Info', 'eco-profile-master'); ?></h4>
                            <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Skin:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_skin); ?></strong></h5>
                            <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Blood Group:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_blood); ?></strong></h5>
                        </div>
                        <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Mailing Address', 'eco-profile-master') ?></h4>
                            <?php if (!empty($current_user->epm_user_house)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('House:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_house); ?></strong></h5>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_road)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Road:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_road); ?></strong></h5>
                            <?php endif; ?>
                            <?php if (!empty($current_user->epm_user_location)) : ?>
                                <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Location:', 'eco-profile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_attr($current_user->epm_user_location); ?></strong></h5>
                            <?php endif; ?>
                        </div>
                        <div class="info-card bg-teal-300 rounded-xl border-l-8 border-white my-3 p-6 space-y-3">
                            <h4 class="text-xl lg:text-2xl text-white font-medium bg-orange-300 rounded-full px-4 py-[4px] inline-block"><?php _e('Other Info', 'eco-profile-master'); ?></h4>
                            <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('First Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->first_name); ?></strong></h5>
                            <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Last Name:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->last_name); ?></strong></h5>
                            <h5 class="text-md text-orange-500 font-bold ml-6"><?php _e('Religion:', 'eco-pprofile-master'); ?> <strong class="text-slate-900 font-semibold"><?php echo esc_html($current_user->epm_user_religion); ?></strong></h5>
                        </div>
                    </div>
                    <?php if (!empty($current_user->description)) : ?>
                        <div class="right-sec my-6 md:w-3/4 space-y-3">
                            <div class="personal-description space-y-3">
                                <h3 class="text-3xl text-white font-medium bg-orange-300 rounded-full px-6 py-[8px] md:inline-block mt-6 text-center md:text-start mx-3"><?php _e('A Few Words About Myself', 'eco-profile-master'); ?></h3>
                                <p class="font-medium text-xl px-4 md:px-0 text-justify md:text-start"><?php echo esc_html($current_user->description); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="profile-foot">
                    <?php
                    if (!empty($current_user->first_name) && !empty($current_user->last_name)) {
                        $full_name = trim($current_user->first_name . ' ' . $current_user->last_name);
                    ?>
                        <h4 class="text-center text-xl"><?php _e('Get Connected with', 'eco-profile-master') ?> <strong><?php echo esc_html($full_name); ?></strong></h4>
                    <?php } ?>

                    <ul class="social-links flex item-center justify-center text-white space-x-2 mx-auto w-2/3 my-5">
                        <?php if (!empty($current_user->epm_user_facebook)) : ?>
                            <li>
                                <a href="<?php echo esc_url($current_user->epm_user_facebook); ?>" class="bg-orange-600 px-4 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($current_user->epm_user_twitter)) : ?>
                            <li>
                                <a href="<?php echo esc_url($current_user->epm_user_twitter); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($current_user->epm_user_linkedin)) : ?>
                            <li>
                                <a href="<?php echo esc_url($current_user->epm_user_linkedin); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($current_user->epm_user_youtube)) : ?>
                            <li>
                                <a href="<?php echo esc_url($current_user->epm_user_youtube); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($current_user->epm_user_instagram)) : ?>
                            <li>
                                <a href="<?php echo esc_url($current_user->epm_user_instagram); ?>" class="bg-orange-600 px-3 py-3 border border-orange-500 rounded-md hover:bg-transparent hover:text-orange-500 transition-all duration-300" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
<?php
        }
    }
}
