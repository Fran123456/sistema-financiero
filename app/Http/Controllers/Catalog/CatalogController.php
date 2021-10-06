<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Company;
use App\Models\Catalog;
use App\Help\Help;

class CatalogController extends Controller
{
  public function index($id){
     $company=Company::find($id);
     return view('catalog.catalog-index',compact('company'));
  }

  public function accounts($id){
    $catalog=Catalog::find($id);
    $help = new Help();
    $accounts=Account::where('catalog_id', $id)->get();
    return view('catalog.accounts.accounts',compact('catalog','accounts','help'));
  }

  public function upload(){

  }

}
