<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerMember extends Model
{
    protected $fillable = [
        'trainer_id',
        'first_name',
        'last_name',
        'phone',
        'email',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}