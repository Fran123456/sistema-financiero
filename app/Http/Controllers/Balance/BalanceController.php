<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Catalog;
use App\Models\Account;

class BalanceController extends Controller
{
    public function index($companyId){ //View all the busines rotation
       $company=Company::find($companyId);
       return view('balances.balances-menu',compact('company'));
    }

    public function IncomeStatementConf($companyId){
      $catalog=Catalog::where('company_id', $companyId)->where('status', true)->first();
      if($catalog!=null){
        $accounts=Account::where('catalog_id', $catalog->id)->get();
        if(count($accounts)>0){
          //content
          $company=Company::find($companyId);
          return view('balances.income-statement-conf', compact('company'));


          //content
        }else{
          return back()->with('error','Debe cargar cuentas contables al catalogo para configurar el estado de resultados');
        }
      }else{
        return back()->with('error','Debe existir un catalogo activo para poder configurar el estado de resultados');
      }
    }
}
