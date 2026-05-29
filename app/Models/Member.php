<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\Scopes\GymScope;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'status',
        'join_date',
        'expiry_date',
        'gym_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   

protected static function booted()
{
    static::addGlobalScope(new GymScope);
}
}