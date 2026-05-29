<?php
use App\Models\Activity;

if (!function_exists('logActivity')) {

    function logActivity(
        $action,
        $description = null,
        $status = 'completed',
        $module = null,
        $memberId = null,
        $meta = []
    ) {

        Activity::create([
            'user_id' => auth()->id(),
            'member_id' => $memberId,
            'action' => $action,
            'description' => $description,
            'status' => $status,
            'module' => $module,
            'meta' => $meta,
        ]);
    }
}