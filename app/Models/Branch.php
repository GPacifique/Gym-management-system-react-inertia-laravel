<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'gym_id',
        'name',
        'address',
        'phone',
        'manager_id',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function members()
{
    return $this->hasMany(Member::class);
}
public function trainers()
{
    return $this->hasMany(Trainer::class);
}
public function gymTrainers()
{
    return $this->hasMany(GymTrainer::class);
}
}