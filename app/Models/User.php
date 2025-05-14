<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'password' => 'hashed',
    ];

    // Define constants for roles
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_OFFICER = 'officer';

    public function licenseSuspensions()
    {
        return $this->hasMany(LicenseSuspension::class, 'user_id');
    }

    public function owner()
    {
        return $this->hasOne(Owner::class);
    }

    public function officer()
    {
        return $this->hasOne(Officer::class, 'email', 'email');
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

    public function isOfficer()
    {
        return $this->role === self::ROLE_OFFICER;
    }

    public function getOfficerId()
    {
        return $this->id; // Since the user ID is the same as officer_id for officer users
    }
}