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
          $data=AccountDB::where('catalog_id', $catalog_id)->
          where('account_name','like', '%'.$this->search.'%')->paginate($this->pagination_size);
        }
        return view('livewire.catalog.account.account',compact('data','search'));
    }
}
