<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'email',
        'phone',
        'specialization',
        'salary',
        'hire_date',
    ];

    /*
    |---------------------------------------
    | RELATIONSHIPS
    |---------------------------------------
    */

    // Each trainer belongs to one gym
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
public function members()
{
    return $this->hasMany(Member::class);
}

}