<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Company;
use App\Models\Catalog;
use App\Help\Help;
use App\Imports\AccountsCollectionImport;
use Maatwebsite\Excel\Facades\Excel;


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

  public function upload(Request $request){
    $catalog=Catalog::find($request->catalogId);
    $help = new Help();
    $catalogId = $request->catalogId;
    $companyId =$request->companyId;
    $import = new AccountsCollectionImport( $companyId,$catalogId);

    if ($request->hasFile('excel')) {
     \Excel::import($import, $request->excel );
     $rows        = $import->getNumRow();
     $succesfull  = $import->getSuccesfulRow();
     $error       = $import->getNotFound();
     return view('catalog.accounts.success',compact('catalog','help','rows','succesfull','error'));
    }else{
      return 'error';
    }
  }

}
