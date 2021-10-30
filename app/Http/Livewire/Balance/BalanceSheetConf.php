<?php

namespace App\Http\Livewire\Balance;

use Livewire\Component;
use App\Models\IncomeStatementConf as IncomeStatementConfDB;
use App\Models\BalanceSheetConf as BalanceSheetConfDB;
use App\Models\Catalog;
use App\Models\Account;

class BalanceSheetConf extends Component
{

    //PROPIEDADES DEL MODELO
    public $id_conf;
    public $title;
    public $account_id;
    public $catalog_id;
    public $company_id;
    public $group;
    public $accounts;

    protected $rules = [
      'account_id'=>'required|min:1',
      'catalog_id'=>'required|min:1',
      'company_id'=>'required',
      'group'=>'required|min:1'
    ];



    public function mount(){
      $this->accounts=[];
      $catalog=Catalog::where('company_id', $this->company_id)->where('status', true)->first();
      $this->catalog_id=$catalog->id;
    }

    public function render()
    {
        $catalog=Catalog::where('company_id', $this->company_id)->where('status', true)->first();
        if($catalog!=null){
          $this->accounts=Account::where('catalog_id', $catalog->id)->get();
        }
        $incomeStatementConf = BalanceSheetConfDB::where('group', null)->get();

        return view('livewire.balance.balance-sheet-conf', compact('incomeStatementConf'));
    }

    public function store(){
      if($this->account_id=='0') $this->account_id=null;
      if($this->group=='0') $this->group=null;
      $this->validate();

      $account = Account::find($this->account_id);
      BalanceSheetConfDB::create([
       'title' => trim($account->account_name),
       'account_id'=> $this->account_id,
       'catalog_id'=>$this->catalog_id,
       'group'=>$this->group,
       'company_id'=>$this->company_id,
      ]);

      session()->flash('message', 'Se ha agregado la cuenta a la configuracion correctamente ' );
      $this->clean();
      $this->emit("send");
    }


    public function clean(){
      $this->account_id=null;
      $this->group=null;
      $this->resetValidation();
    }

    public function destroy($id){
      BalanceSheetConfDB::destroy($id);
      //session()->flash('message-destroy', 'Se ha eliminado la cuenta contable correctamente');
      //$this->emit("destroy");
    }

}
