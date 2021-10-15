<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class BalanceController extends Controller
{
    public function index($companyId){ //View all the busines rotation
       $company=Company::find($companyId);
       return view('balances.balances-menu',compact('company'));
    }
}
