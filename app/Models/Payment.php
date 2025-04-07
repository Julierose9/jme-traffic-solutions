<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    protected $fillable = ['record_id', 'payment_date', 'payment_method', 'transaction_reference'];

    public function violationRecord()
    {
        return $this->belongsTo(ViolationRecord::class, 'record_id');
    }
}