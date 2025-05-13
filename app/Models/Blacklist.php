<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blacklist extends Model
{
    protected $primaryKey = 'blacklist_id';

    protected $fillable = [
        'reg_vehicle_id',
        'own_id',
        'reason',
        'blacklist_type',
        'date_added',
        'lifted_date',
        'status',
        'appeal_status',
    ];

    protected $casts = [
        'date_added' => 'date',
        'lifted_date' => 'datetime',
    ];

    public function registeredVehicle()
    {
        return $this->belongsTo(RegisteredVehicle::class, 'reg_vehicle_id', 'reg_vehicle_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'own_id', 'own_id');
    }
}