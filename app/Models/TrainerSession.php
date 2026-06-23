<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'trainer_id',
        'member_id',
        'branch_id',
        'title',
        'description',
        'session_date',
        'start_time',
        'end_time',
        'location',
        'status',
        'notes',
        'calories_burned',
    ];

    protected $casts = [
        'session_date' => 'date',
        'start_time'   => 'datetime:H:i',
        'end_time'     => 'datetime:H:i',
    ];

    /**
     * Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    /**
     * Gym Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Gym
     */
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    /**
     * Branch
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Duration in minutes
     */
    public function getDurationAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return 0;
        }

        return \Carbon\Carbon::parse($this->start_time)
            ->diffInMinutes(
                \Carbon\Carbon::parse($this->end_time)
            );
    }

    /**
     * Check if completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if scheduled
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if missed
     */
    public function isMissed()
    {
        return $this->status === 'missed';
    }
}