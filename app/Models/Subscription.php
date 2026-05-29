<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_id',
        'member_id',
        'name',
        'description',
        'price',
        'duration',
        'duration_type',
        'start_date',
        'end_date',
        'payment_status',
        'payment_method',
        'transaction_id',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}