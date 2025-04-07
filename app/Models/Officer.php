<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $primaryKey = 'officer_id';
    protected $fillable = ['lname', 'fname', 'mname', 'rank', 'contact_num', 'email'];

    public function violationRecords()
    {
        return $this->hasMany(ViolationRecord::class, 'officer_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'officer_id');
    }
}