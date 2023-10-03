<div class="max-w-screen-2xl mx-auto px-8 md:px-16 lg:px-24 py-5 my-10 w-100-grid">
    <h3 class="text-white bg-teal-950 background-color: rgb(4 47 46); p-5"><?php _e('Users Listing', 'eco-profile-master'); ?></h3>
    <table id="userslist" class="display py-5" style="width:100%!important">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Biographical</th>
                <th>Profile Image</th>
                <!-- <th>Facebook</th>
                <th>Twitter</th>
                <th>Linkedin</th>
                <th>Youtube</th>
                <th>Instagram </th> -->
                <th>Joining date</th>
                <th>View User Data</th>
            </tr>
        </thead>
        <tbody>
            <?php
            get_epm_user_listings();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Nickname</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Website</th>
                <th>Biographical</th>
                <th>Profile Image</th>
                <!-- <th>Facebook</th>
                <th>Twitter</th>
                <th>Linkedin</th>
                <th>Youtube</th>
                <th>Instagram </th> -->
                <th>Joining date</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Main modal -->
<div id="userModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <h1><?php _e('User Details', 'eco-profile-master'); ?></h1>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="userModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only"><?php _e('Close modal', 'eco-profile-master'); ?></span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <ul class="list-none epm-list">
                    <div id="userDetails"></div>
                </ul>
            </div>
        </div>
    </div>
</div>