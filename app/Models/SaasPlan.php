<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaasPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'max_members',
        'max_trainers',
        'max_staff',
        'max_branches',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function gyms()
    {
        return $this->hasMany(Gym::class, 'subscription_plan_id');
    }
}