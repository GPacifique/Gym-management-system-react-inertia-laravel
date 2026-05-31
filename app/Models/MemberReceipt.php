<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberReceipt extends Model
{
    use HasFactory;

    protected $table = 'receipts';

    protected $fillable = [
        'payment_id',
        'receipt_number',
        'issued_at',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function payment()
    {
        return $this->belongsTo(
            MemberPayment::class,
            'payment_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedNumberAttribute()
    {
        return strtoupper($this->receipt_number);
    }
}