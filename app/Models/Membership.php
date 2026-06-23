<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gym_id',
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'amount',
        'status',
        'notes',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function payments()
    {
        return $this->hasMany(MembershipPayment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (SaaS safety)
    |--------------------------------------------------------------------------
    */

    public function scopeForGym($query, $gymId)
    {
        return $query->where('gym_id', $gymId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function daysRemaining(): int
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function hasExpired(): bool
    {
        return now()->greaterThan($this->end_date);
    }

    /*
    |--------------------------------------------------------------------------
    | Boot (auto SaaS safety optional)
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Auto-update expired memberships
        static::saving(function ($membership) {
            if ($membership->end_date && now()->gt($membership->end_date)) {
                $membership->status = 'expired';
            }
        });
    }
}