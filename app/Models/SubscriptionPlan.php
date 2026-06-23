<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'price',
        'duration',
        'duration_type',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the gym that owns the subscription plan.
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Get all member subscriptions associated with this plan.
     */
    public function memberSubscriptions()
    {
        return $this->hasMany(MemberSubscription::class);
    }
}