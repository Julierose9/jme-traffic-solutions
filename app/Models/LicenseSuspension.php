<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseSuspension extends Model
{
    protected $primaryKey = 'suspension_id';

    protected $fillable = [
        'own_id',
        'suspension_start_date',
        'suspension_end_date',
        'suspension_reason',
        'suspension_status',
        'appeal_status'
    ];

    protected $casts = [
        'suspension_start_date' => 'date',
        'suspension_end_date' => 'date'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'own_id', 'own_id');
    }
}