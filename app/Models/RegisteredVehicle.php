<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredVehicle extends Model
{
    protected $primaryKey = 'reg_vehicle_id';

    protected $fillable = [
        'own_id', 'plate_number', 'vehicle_type', 'brand', 'model', 'color', 'registration_date'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'own_id');
    }

    public function blacklists()
    {
        return $this->hasMany(Blacklist::class, 'reg_vehicle_id');
    }
}