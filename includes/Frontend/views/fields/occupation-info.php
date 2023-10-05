        <!-- occupation info section -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold pb-4"> <?php echo $epm_form_heading_occupation; ?></h2>
            <div class="flow">
                <label for="occupation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><?php echo esc_attr($labelsPlaceholders['occupation']['label']); ?></label>
                <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected><?php echo esc_attr($labelsPlaceholders['occupation']['placeholder']); ?></option>
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </select>

            </div>
        </div>
        <!-- end occupation info section -->