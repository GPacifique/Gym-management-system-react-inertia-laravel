<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * Fields allowed for mass assignment
     */
    protected $fillable = [
        'user_id',
        'service',
        'date',
        'time',
        'status',
        'notes',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relationship: Booking belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope: today's bookings
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', now()->toDateString());
    }

    /**
     * Helper: check if booking belongs to a user
     */
    public function belongsToUser($userId): bool
    {
        return $this->user_id === $userId;
    }

    /**
     * Helper: check if booking is editable
     */
    public function isEditable(): bool
    {
        return in_array($this->status, ['pending']);
    }
}