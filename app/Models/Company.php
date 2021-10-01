<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessRotation;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $fillable = [
        'company','business_rotation_id',
    ];

    public function BusinessRotation()
   {
       return $this->belongsTo(BusinessRotation::class);
   }
}
