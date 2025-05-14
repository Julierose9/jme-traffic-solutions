<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'violation_id',
        'officer_id',
        'reg_vehicle_id',
        'own_id',
        'report_details',
        'location',
        'report_date',
        'status'
    ];

    protected $casts = [
        'report_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(RegisteredVehicle::class, 'reg_vehicle_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'own_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}