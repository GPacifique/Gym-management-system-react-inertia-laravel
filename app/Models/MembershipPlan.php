<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'gym_id',
        'name',
        'price',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
    public function subscriptions()
{
    return $this->hasMany(MemberSubscription::class);
}
}