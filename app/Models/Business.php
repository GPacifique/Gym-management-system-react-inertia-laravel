<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Business extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'email',
        'phone',
        'website',
        'country',
        'city',
        'address',
        'description',
        'type',
        'is_active',
        'rating',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($business) {
            if (!$business->slug) {
                $business->slug = Str::slug($business->name);
            }
        });
    }
    public function members()
{
    return $this->hasMany(Member::class);
}
public function subscriptions()
{
    return $this->hasMany(Subscription::class);
}
public function payments()
{
    return $this->hasMany(Payment::class);
}
public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}