<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'lname',
        'fname',
        'mname',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define constants for roles
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    public function licenseSuspensions()
    {
        return $this->hasMany(LicenseSuspension::class, 'user_id');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Method to check if the user is a regular user
    public function isUser ()
    {
        return $this->role === self::ROLE_USER;
    }
}