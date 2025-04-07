<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseSuspension extends Model
{
    protected $fillable = [
        'owner_id', 
        'suspension_start_date',
        'suspension_end_date',
        'suspension_reason',
        'appeal_status',
        'suspension_status',
    ];

    protected $casts = [
        'suspension_start_date' => 'date',
        'suspension_end_date' => 'date',
    ];

    public function owner() 
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'own_id');
    }
}