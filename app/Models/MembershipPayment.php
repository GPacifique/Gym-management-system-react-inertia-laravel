<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPayment extends Model
{
    protected $fillable = [
        'gym_id',
        'member_id',
        'membership_id',
        'amount',
        'payment_method',
        'status',
        'transaction_reference',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}