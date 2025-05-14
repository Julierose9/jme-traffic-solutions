<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violations';
    protected $primaryKey = 'violation_id';

    protected $fillable = [
        'violation_code',
        'description',
        'penalty_amount',
    ];
}