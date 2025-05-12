<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationRecord extends Model
{
    protected $table = 'violation_records';
    protected $primaryKey = 'record_id';

    protected $fillable = [
        'reg_vehicle_id',
        'officer_id',
        'violation_id',
        'violation_date',
        'location',
        'remarks',
        'status',
    ];

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id', 'violation_id');
    }

    public function registeredVehicle()
    {
        return $this->belongsTo(RegisteredVehicle::class, 'reg_vehicle_id', 'reg_vehicle_id');
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_id', 'officer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'record_id', 'record_id');
    }
}