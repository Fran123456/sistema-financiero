<?php

namespace App\Http\Livewire\Catalog;

use Livewire\Component;
use App\Models\Catalog as CatalogDB;
use App\Models\Account as AccountDB;
use Livewire\WithPagination;

class Account extends Component
{
    use WithPagination; //para utilizar paginacion en livewire
    public $search; //variable que contendra el texto de la busqueda
    public $pagination_size = 20; //numero de paginacion
    protected $queryString=['search' => ['except'=>'']];

    //PROPIEDADES DEL MODELO
    public $id_account;
    public $account;
    public $account_name;
    public $parent;
    public $catalog_id;
    public $company_id;


    protected $rules = [
      'account'=>'required',
      'account_name'=>'required',
      'parent'=>'required',
    ];

    public function render()
    {
        $search=$this->search;
        if($this->search==null || $this->search ==""){
            $data=AccountDB::where('catalog_id', $this->catalog_id)->paginate($this->pagination_size);
        }
        else{
          $data=AccountDB::where('catalog_id', $this->catalog_id)->
          where('account_name','like', '%'.$this->search.'%')->paginate($this->pagination_size);
        }
        return view('livewire.catalog.account.account',compact('data','search'));
    }

    //Metodo para limpiar campos
     public function clean(){
       $this->account='';
       $this->id_account='';
       $this->account_name='';
       $this->parent='';
       $this->resetValidation();
     }
     //Metodo para limpiar campos

     //metodo para obtener un registro
      public function get($id){
          $data = AccountDB::find($id);
          $this->asigned($data);
          $this->resetValidation();
      }
      //metodo para obtener un registro

    //Metodo para asignar los valores a las variables
     private function asigned($data){
         $this->id_account = $data->id;
         $this->account=$data->account;
         $this->parent = $data->parent;
         $this->account_name=$data->account_name;
    }
    //Metodo para asignar los valores a las variables

    //metodo para eliminar un registro
    public function destroy($id){
      $account = AccountDB::find($id);
      AccountDB::destroy($id);
      $accounts=AccountDB::where('catalog_id',$account->catalog_id)->get();
      if(count($accounts)>0){
        session()->flash('message-destroy', 'Se ha eliminado la cuenta contable correctamente');
        $this->emit("destroy");
      }else{
        session()->flash('destroy', 'Se ha eliminado la cuenta contable correctamente, ademas ha eliminado la ultima cuenta contable existente');
        return redirect(route('accounts-index',$account->catalog_id));
      }

    }
    //metodo para eliminar un registro


    //metodo para guardar un registro
      public function store(){
         $this->validate();

         if($this->parent==0)$val=1;
         else $val=count(AccountDB::where('account', $this->parent)->get());

         if($val>0){
           AccountDB::create([
            'account' => $this->account,
            'account_name'=> $this->account_name,
            'parent'=>$this->parent,
            'catalog_id'=>$this->catalog_id,
            'company_id'=>$this->company_id,
           ]);
          session()->flash('message', 'Se ha agregado al cuenta contable correctamente.');
          $this->clean();
          $this->emit("send");
        }else{
          $this->addError('parent', 'La cuenta padre ingresada no existe.');
        }
      }
      //metodo para guardar un registro


}
