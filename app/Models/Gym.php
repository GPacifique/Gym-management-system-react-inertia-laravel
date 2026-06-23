<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'logo',
        'status',
        'subscription_plan_id',
        'subscription_expires_at',
    ];

    protected $casts = [
        'subscription_expires_at' => 'datetime',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
    public function branches()
{
    return $this->hasMany(Branch::class);
}
public function services()
{
    return $this->hasMany(Service::class);
}
public function membershipPlans()
{
    return $this->hasMany(MembershipPlan::class);
}
public function members()
{
    return $this->hasMany(Member::class);
}
public function gymTrainers()
{
    return $this->hasMany(GymTrainer::class);
}

public function trainers()
{
    return $this->belongsToMany(
        Trainer::class,
        'gym_trainers'
    )->withPivot('branch_id')
     ->withTimestamps();
}
public function trainerPayments()
{
    return $this->hasMany(TrainerPayment::class);
}
public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

public function saasPlan()
{
    return $this->belongsTo(SaasPlan::class, 'subscription_plan_id');
}
}