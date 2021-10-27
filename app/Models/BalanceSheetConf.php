<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceSheetConf extends Model
{
    use HasFactory;
    protected $table = 'balance_sheet_conf';
    protected $fillable = [
        'title','account_id','catalog_id','group','company_id'
    ];

    public function getBalanceSheetByCompany($company, $group, $catalog){
      return BalanceSheetConf::where('group', $group)->where('catalog_id', $catalog)->where('company_id', $company)->get();
    }

    public function account()
    {
       return $this->belongsTo(Account::class,'account_id');
    }

}
