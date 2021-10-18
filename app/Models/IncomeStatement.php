<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeStatement extends Model
{
    use HasFactory;
    protected $table = 'income_statement';
    protected $fillable = [
        'title','is_title','is_total','is_sub_total','is_separator','data','order','catalog_id','account_id','company_id','period_id'
    ];

    public function company()
    {
       return $this->belongsTo(Company::class);
    }

    public function catalog()
    {
       return $this->belongsTo(Catalog::class);
    }

    public function account()
    {
       return $this->belongsTo(Account::class);
    }

    public function period()
    {
       return $this->belongsTo(Periods::class);
    }


   public static function separator($company_id, $year, $order){
     IncomeStatement::create([
       'title'=> '<hr>',
       'is_title'=>false,
       'is_total'=>false,
       'is_sub_total'=>false,
       'is_separator'=>true,
       'data'=>  0,
       'order'=> $order,
       'company_id'=> $company_id,
       'period_id'=> $year,
     ]);
   }



}
