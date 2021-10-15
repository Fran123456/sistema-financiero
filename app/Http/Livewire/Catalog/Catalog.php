<?php

namespace App\Http\Livewire\Catalog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company as CompanyDB;
use App\Models\Catalog as CatalogDB;

class Catalog extends Component
{

    use WithPagination; //para utilizar paginacion en livewire
    public $search; //variable que contendra el texto de la busqueda
    public $pagination_size = 10; //numero de paginacion
    protected $queryString=['search' => ['except'=>'']];

    //PROPIEDADES DEL MODELO
    public $catalog;
    public $companyId;
    public $idCatalog;

    protected $rules = [
      'catalog'=>'required',
    ];

    //Metodo render, se debe llamar asi y es donde se actualiza los datos de la vista.
    public function render()
    {
      $search=$this->search;
      if($this->search==null || $this->search ==""){
          $catalogs=CatalogDB::where('company_id', $this->companyId)->paginate($this->pagination_size);
      }
      else{
        $catalogs=CatalogDB::where('company_id', $this->companyId)->
        where('company','like', '%'.$this->search.'%')->paginate($this->pagination_size);
      }

      return view('livewire.catalog.catalog' ,compact('search','catalogs'));
    }

    //metodo para guardar un registro
      public function store(){
         $this->validate();
         CatalogDB::where('company_id', $this->companyId)->update(['status'=>false]);
         CatalogDB::create([
          'catalog' => $this->catalog,
          'company_id'=> $this->companyId,
          'user_id'=>auth()->user()->id
         ]);

        session()->flash('message', 'Se ha agregado correctamente el catalogo, ahora puede subir las cuentas contables');
        $this->clean();
        $this->emit("send");
      }
      //metodo para guardar un registro

      //Metodo para limpiar campos
       public function clean(){
         $this->idCatalog='';
         $this->catalog='';
         $this->resetValidation();
       }
       //Metodo para limpiar campos


     //metodo para obtener un registro
      public function get($id){
          $data = CatalogDB::find($id);
          $this->asigned($data);
          $this->resetValidation();
      }
      //metodo para obtener un registro

    //Metodo para asignar los valores a las variables
    private function asigned($data){
         $this->catalog = $data->catalog;
         $this->companyId=$data->company_id;
         $this->idCatalog = $data->id;
    }
  //Metodo para asignar los valores a las variables


  //metodo para eliminar un registro
  public function destroy($id){
    CatalogDB::destroy($id);
    session()->flash('message-destroy', 'Se ha eliminado el catalogo correctamente');
    $this->emit("destroy");
    //  $this->control=false;
  }
  //metodo para eliminar un registro


  //Metodo para editar un registro
   public function update(){
     $this->validate();
     catalogDB::where('id', $this->idCatalog)->update([
       'catalog' => $this->catalog,
       'user_id'=> auth()->user()->id
     ]);
     session()->flash('message-update', 'Se ha actualizado el catalogo correctamente');
     $this->emit("update");
   }
  //Metodo para editar un registro


}
