<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IncomeStatement;
use App\Models\BalanceSheet;

class Periods extends Model
{
    use HasFactory;
    protected $table = 'periods';
    protected $fillable = [
        'year'
    ];


    public function incomeStatementByCompany($period, $company)
    {
        return IncomeStatement::where('company_id', $company)->where('period_id', $period)->get();
    }

    public function balanceSheetByCompany($period, $company)
    {
        return BalanceSheet::where('company_id', $company)->where('period_id', $period)->get();
    }


}
