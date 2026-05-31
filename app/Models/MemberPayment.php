<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'gym_id',
        'member_id',
        'member_subscription_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'payment_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Gym
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Subscription
     */
    public function subscription()
    {
        return $this->belongsTo(
            MemberSubscription::class,
            'member_subscription_id'
        );
    }

    /**
     * Receipt
     */
    public function receipt()
    {
        return $this->hasOne(MemberReceipt::class, 'payment_id');
    }
}