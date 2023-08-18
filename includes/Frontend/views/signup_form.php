<form class="flow flow-vertical">
    <div class="flow space-y-4 bg-white shadow-md rounded-lg px-8 py-6">
        <h2 class="text-xl font-semibold mb-2">Name</h2>
        <div class="flow">
            <label for="epm_user_username" class="text-gray-700">Username</label>
            <input type="text" id="epm_user_username" name="epm_user_username" class="input input-bordered w-full" placeholder="Enter your username">
        </div>
        <div class="flow">
            <label for="epm_user_firstname" class="text-gray-700">First Name</label>
            <input type="text" id="epm_user_firstname" name="epm_user_firstname" class="input input-bordered w-full" placeholder="Enter your first name">
        </div>
        <div class="flow">
            <label for="epm_user_lastname" class="text-gray-700">Last Name</label>
            <input type="text" id="epm_user_lastname" name="epm_user_lastname" class="input input-bordered w-full" placeholder="Enter your last name">
        </div>
        <div class="flow">
            <label for="epm_user_nickname" class="text-gray-700">Nickname</label>
            <input type="text" id="epm_user_nickname" name="epm_user_nickname" class="input input-bordered w-full" placeholder="Enter your nickname">
        </div>
        <h2 class="text-xl font-semibold">Contact Info</h2>
        <div class="flow">
            <label for="epm_user_email" class="text-gray-700">Email</label>
            <input type="email" id="epm_user_email" name="epm_user_email" class="input input-bordered w-full" placeholder="Enter your email">
        </div>
        <div class="flow">
            <label for="epm_user_phone" class="text-gray-700">Phone</label>
            <input type="tel" id="epm_user_phone" name="epm_user_phone" class="input input-bordered w-full" placeholder="Enter your phone number">
        </div>
        <div class="flow">
            <label for="epm_user_website" class="text-gray-700">Website</label>
            <input type="url" id="epm_user_website" name="epm_user_website" class="input input-bordered w-full" placeholder="Enter your website url">
        </div>
        <h2 class="text-xl font-semibold"> About Yourself</h2>
        <div class="flow">
            <label for="message" class="text-gray-700">About Yourself</label>
            <textarea id="epm_user_bio" rows="4" name="epm_user_bio" class="input input-bordered w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="About Yourself"></textarea>
        </div>
        <div class="flow">
            <label for="epm_user_password" class="text-gray-700">Password</label>
            <input type="password" id="epm_user_password" name="epm_user_password" class="input input-bordered w-full" placeholder="Enter your password">
        </div>
        <div class="flow">
            <label for="epm_user_retype_password" class="text-gray-700">Retype Password</label>
            <input type="password" id="epm_user_retype_password" name="epm_user_password" class="input input-bordered w-full" placeholder="Retype your password">
        </div>
        <h2 class="text-xl font-semibold"> Profile Image </h2>
        <div class="flow">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="epm_user_avatar" type="file" name="epm_user_avatar">
        </div>
        <!-- Social Media Inputs -->
        <h2 class="text-xl font-semibold"> Social Links </h2>
        <div class="flow">
            <label for="epm_user_facebook" class="text-gray-700">Facebook</label>
            <input type="text" id="epm_user_facebook" name="epm_user_facebook" class="input input-bordered w-full" placeholder="Enter your Facebook URL">
        </div>
        <div class="flow">
            <label for="epm_user_twitter" class="text-gray-700">Twitter</label>
            <input type="text" id="epm_user_twitter" name="epm_user_twitter" class="input input-bordered w-full" placeholder="Enter your Twitter URL">
        </div>
        <div class="flow">
            <label for="epm_user_linkedin" class="text-gray-700">LinkedIn</label>
            <input type="text" id="epm_user_linkedin" name="epm_user_linkedin" class="input input-bordered w-full" placeholder="Enter your LinkedIn URL">
        </div>
        <div class="flow">
            <label for="epm_user_youtube" class="text-gray-700">YouTube</label>
            <input type="text" id="epm_user_youtube" name="epm_user_youtube" class="input input-bordered w-full" placeholder="Enter your YouTube URL">
        </div>
        <div class="flow">
            <label for="epm_user_instagram" class="text-gray-700">Instagram</label>
            <input type="text" id="epm_user_instagram" name="epm_user_instagram" class="input input-bordered w-full" placeholder="Enter your Instagram URL">
        </div>
        <div class="flow">
            <button type="submit" class="btn btn-primary mt-10">Submit</button>
        </div>
    </div>
</form>