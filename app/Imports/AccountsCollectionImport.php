<?php

namespace App\Imports;


use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use PhpParser\Node\Stmt\Return_;
use App\Models\Account;


class AccountsCollectionImport implements ToCollection, WithHeadingRow
{

  private $numRows=0;
  private $UserNotFound=0;
  private $succesfulRow=0;
  private $catalogId=0;
  private $companyId=0;

  public function  __construct($companyId, $catalogId)
  {
         $this->companyId = $companyId;
         $this->catalogId = $catalogId;
  }


  public function collection(Collection $collection)
  {
     foreach($collection as $row){
       ++$this->numRows;
        //get excel
         $account=         $row['cuenta'];
         $name=            $row['nombre'];
         $parent=          $row['cuenta_padre'];
         ++$this->succesfulRow;

           Account::Create([
           'account'           =>$account,
           'account_name'      => $name,
           'parent'            => $parent,
           'catalog_id'   =>$this->catalogId,
           'company_id'   =>$this->companyId,
           ]);
       }
   }

  public function getNumRow()
  {
         return $this->numRows;
  }

  public function getSuccesfulRow(){
        return $this->succesfulRow;
  }

  public function getNotFound()
  {
      return $this->UserNotFound;
  }

}








?>
