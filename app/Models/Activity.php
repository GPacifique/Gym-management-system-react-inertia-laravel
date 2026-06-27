<?php

namespace App\Models {

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}

} // end namespace App\Models

// Define global helper in the global namespace so it's available app-wide
namespace {
    if (!function_exists('logActivity')) {
        function logActivity(
            $action,
            $description = null,
            $status = 'completed',
            $module = null,
            $memberId = null,
            $meta = []
        ) {
            \App\Models\Activity::create([
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
}