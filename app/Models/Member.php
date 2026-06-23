<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Membership;
class Member extends Model
{
    protected $fillable = [
        'gym_id',
        'branch_id',
        'member_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'status',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function subscriptions()
{
    return $this->hasMany(MemberSubscription::class);
}

public function activeSubscription()
{
    return $this->hasOne(MemberSubscription::class)
                ->where('status', 'active')
                ->latestOfMany();
}
public function trainerPayments()
{
    return $this->hasMany(TrainerPayment::class);
}
public function attendances()
{
    return $this->hasMany(Attendance::class);
}




public function memberships()
{
    return $this->hasMany(Membership::class);
}

public function activeMembership()
{
    return $this->hasOne(Membership::class)
        ->where('status', 'active')
        ->latestOfMany();
}

public function payments()
{
    return $this->hasMany(MembershipPayment::class);
}

public function attendance()
{
    return $this->hasMany(MemberAttendance::class);
}
}