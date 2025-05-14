<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleRegistrationRequest extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_type',
        'brand',
        'model',
        'plate_number',
        'color',
        'notes',
        'status' // pending, approved, rejected
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 