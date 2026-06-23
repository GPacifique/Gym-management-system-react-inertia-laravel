<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'gym_id',
        'branch_id',
        'name',
        'phone',
        'email',
        'specialization',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function gymTrainers()
{
    return $this->hasMany(GymTrainer::class);
}

public function gyms()
{
    return $this->belongsToMany(
        Gym::class,
        'gym_trainers'
    )->withPivot('branch_id')
     ->withTimestamps();
}
public function members()
{
    return $this->hasMany(TrainerMember::class);
}
public function payments()
{
    return $this->hasMany(TrainerPayment::class);
}
}