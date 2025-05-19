<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViolationRecord extends Model
{
    protected $table = 'violation_records';
    protected $primaryKey = 'record_id';
    public $timestamps = true;

    protected $fillable = [
        'violation_code',
        'description',
        'penalty_amount',
        'reg_vehicle_id',
        'officer_id',
        'violation_id',
        'violation_date',
        'location',
        'remarks',
        'status'
    ];

    protected $casts = [
        'violation_date' => 'date:Y-m-d',
    ];

    public function registeredVehicle()
    {
        return $this->belongsTo(RegisteredVehicle::class, 'reg_vehicle_id', 'reg_vehicle_id');
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class, 'officer_id', 'officer_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id', 'violation_id');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}