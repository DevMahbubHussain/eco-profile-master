 <!-- mailing-address section -->
 <?php if ($this->getEnabledMailingAddressFields()) : ?>
     <h4 class="text-xl font-semibold mb-2"><?php echo $epm_form_heading_mailing_address; ?></h4>
     <div class="flow">
         <label for="epm_user_house" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['house']['label']); ?></label>
         <input type="text" id="epm_user_house" name="epm_user_house" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['house']['placeholder']); ?>">
     </div>
     <div class="flow">
         <label for="epm_user_road" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['road']['label']); ?></label>
         <input type="text" id="epm_user_road" name="epm_user_road" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['road']['placeholder']); ?>">
     </div>

     <div class="flow">
         <label for="epm_user_location" class="text-gray-700"><?php echo esc_attr($labelsPlaceholders['location']['label']); ?></label>
         <input type="text" id="epm_user_location" name="epm_user_location" class="input input-bordered w-full" placeholder="<?php echo esc_attr($labelsPlaceholders['location']['placeholder']); ?>">
     </div>
 <?php endif; ?>
 <!-- end of mailing-address -->