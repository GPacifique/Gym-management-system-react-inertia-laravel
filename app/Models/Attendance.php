<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'gym_id',
        'member_id',
        'branch_id',
        'check_in',
        'check_out',
    ];

    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Provide compatibility attribute names used across the app
    public function getCheckInTimeAttribute()
    {
        return $this->check_in;
    }

    public function getCheckOutTimeAttribute()
    {
        return $this->check_out;
    }
}