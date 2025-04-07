<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports'; // Specify the table name if it's not pluralized

    protected $fillable = [
        'violation_id',
        'officer_id',
        'reg_vehicle_id',
        'own_id',
        'report_details',
        'location',
        'report_date',
        'status',
    ];

    // Define relationships if needed
    public function violation()
    {
        return $this->belongsTo(Violation::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'reg_vehicle_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'own_id');
    }
}