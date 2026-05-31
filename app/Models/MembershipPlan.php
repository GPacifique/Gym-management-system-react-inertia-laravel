<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'description',
        'duration_days',
        'price',
        'allow_classes',
        'allow_personal_training',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'allow_classes' => 'boolean',
        'allow_personal_training' => 'boolean',
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(
            MemberSubscription::class,
            'membership_plan_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0);
    }

    public function getDurationTextAttribute()
    {
        if ($this->duration_days == 30) {
            return 'Monthly';
        }

        if ($this->duration_days == 90) {
            return 'Quarterly';
        }

        if ($this->duration_days == 180) {
            return 'Semi-Annual';
        }

        if ($this->duration_days == 365) {
            return 'Annual';
        }

        return $this->duration_days . ' Days';
    }
}