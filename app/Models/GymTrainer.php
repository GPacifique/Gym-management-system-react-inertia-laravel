<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymTrainer extends Model
{
    protected $fillable = [
        'gym_id',
        'trainer_id',
        'branch_id',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}