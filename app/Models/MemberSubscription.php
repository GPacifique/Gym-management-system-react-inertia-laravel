<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    protected $fillable = [
        'gym_id',
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function isActive()
    {
        return $this->status === 'active'
            && $this->end_date >= now()->toDateString();
    }
}