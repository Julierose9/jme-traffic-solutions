<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'payment_date',
        'payment_method',
        'transaction_reference',
        'amount_paid',
        'user_id'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount_paid' => 'decimal:2'
    ];

    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate a unique transaction reference
    public static function generateTransactionReference()
    {
        $prefix = 'TXN';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}-{$timestamp}-{$random}";
    }
}