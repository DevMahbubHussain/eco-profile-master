<?php

namespace EcoProfile\Master\Traits\Admin;

trait AdminApprovalTrait
{
    // Method to check if user requires admin approval
    public function is_user_pending_approval($user_id)
    {
        return get_user_meta($user_id, 'pending_approval', true);
    }

    // Method to mark user as pending approval
    public function mark_user_pending_approval($user_id)
    {
        update_user_meta($user_id, 'pending_approval', true);
    }
}
