<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRotation extends Model
{
    use HasFactory;
    protected $table = 'business_rotations';
    protected $fillable = [
        'name',
    ];
}
