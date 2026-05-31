<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MemberSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
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

    public function plan()
    {
        return $this->belongsTo(
            MembershipPlan::class,
            'membership_plan_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(
            MemberPayment::class,
            'member_subscription_id'
        );
    }

    public function renewals()
    {
        return $this->hasMany(
            SubscriptionRenewal::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays(
            $this->end_date,
            false
        );
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::today()->gt(
            Carbon::parse($this->end_date)
        );
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active'
            && !$this->is_expired;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->whereDate(
            'end_date',
            '<=',
            now()->addDays($days)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function renew($days, $amount = null)
    {
        $oldEndDate = $this->end_date;

        $newEndDate = Carbon::parse(
            $this->end_date
        )->addDays($days);

        $this->update([
            'end_date' => $newEndDate,
            'status' => 'active',
            'payment_status' => 'paid',
        ]);

        if ($amount) {
            SubscriptionRenewal::create([
                'member_subscription_id' => $this->id,
                'renewal_date' => now(),
                'old_end_date' => $oldEndDate,
                'new_end_date' => $newEndDate,
                'amount' => $amount,
            ]);
        }

        return $this;
    }
}