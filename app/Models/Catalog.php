<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;
    protected $table = 'catalog';
    protected $fillable = [
        'id','catalog','company_id','user_id',
    ];

    public function user()
    {
       return $this->belongsTo(user::class);
    }

    public function company()
    {
       return $this->belongsTo(Company::class, 'company_id');
    }
}
