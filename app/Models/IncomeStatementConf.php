<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeStatementConf extends Model
{
    use HasFactory;
    protected $table = 'income_statement_conf';
    protected $fillable = [
        'title','account_id','catalog_id','group','company_id'
    ];

    public function getIncomentStatementConfByCompany($company, $group, $catalog){
      return IncomeStatementConf::where('group', $group)->where('catalog_id', $catalog)->where('company_id', $company)->get();
    }

    public function account()
    {
       return $this->belongsTo(Account::class,'account_id');
    }

}
