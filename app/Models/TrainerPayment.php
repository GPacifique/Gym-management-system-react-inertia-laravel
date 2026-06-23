<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerPayment extends Model
{
    protected $fillable = [
        'trainer_id',
        'member_id',
        'gym_id',
        'amount',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}