<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'lname', 'fname', 'mname', 'address', 'contact_num', 'license_number'
    ];

    public function registeredVehicles()
    {
        return $this->hasMany(RegisteredVehicle::class, 'own_id');
    }

    public function blacklists()
    {
        return $this->hasMany(Blacklist::class, 'own_id');
    }
}