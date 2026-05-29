<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'name',
        'code',
        'country',
        'city',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}