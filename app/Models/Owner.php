<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $primaryKey = 'own_id';

    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'address',
        'contact_num',
        'license_number',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registeredVehicles()
    {
        return $this->hasMany(RegisteredVehicle::class, 'own_id', 'own_id');
    }

    public function blacklists()
    {
        return $this->hasMany(Blacklist::class, 'own_id', 'own_id');
    }
}