<?php

namespace App\Http\Livewire\Company;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Company as CompanyDB;
use App\Models\BusinessRotation as Business;

class Company extends Component
{
  use WithPagination; //para utilizar paginacion en livewire
  public $search; //variable que contendra el texto de la busqueda
  public $pagination_size = 10; //numero de paginacion
  protected $queryString=['search' => ['except'=>'']];

  //PROPIEDADES DEL MODELO
  public $name;
  public $idCompany;
  public $bussinesId;


  //public $control=false;

  protected $rules = [
    'name'=>'required',
    'bussinesId'=>'required'
  ];

  public function mount(){
      $this->bussinesId= Business::first()->id;
  }

  //Metodo render, se debe llamar asi y es donde se actualiza los datos de la vista.
  public function render()
  {
    $search=$this->search;
    $business=Business::all();
    if($this->search==null || $this->search ==""){
        $companies=CompanyDB::paginate($this->pagination_size);
    }
    else{
      $companies=CompanyDB::where('company','like', '%'.$this->search.'%')->paginate($this->pagination_size);
    }
    /*if(count($business)>0 && !$this->control){
      $this->bussinesId=$business[0]->id;
    }*/
    return view('livewire.company.company' ,compact('search','companies','business'));
  }


  //metodo para obtener un registro
   public function get($id){
      // $this->control=true;
       $data = CompanyDB::find($id);
       $this->asigned($data);
       $this->resetValidation();
    }
  //metodo para obtener un registro

  //Metodo para asignar los valores a las variables
   private function asigned($data){
    //  $this->control=true;
      $this->name = $data->company;
      $this->bussinesId= $data->business_rotation_id;
      $this->idCompany = $data->id;
    }
  //Metodo para asignar los valores a las variables

  //metodo para eliminar un registro
  public function destroy($id){
    CompanyDB::destroy($id);
    session()->flash('message-destroy', 'Se ha eliminado correctamente la empresa');
    $this->emit("destroy");
  //  $this->control=false;
  }
  //metodo para eliminar un registro


  //metodo para guardar un registro
    public function store(){
       $this->validate();
       CompanyDB::create([
        'company' => $this->name,
        'business_rotation_id'=> $this->bussinesId
       ]);
      session()->flash('message', 'Se ha agregado correctamente la empresa');
      $this->clean();
      $this->emit("send");
    }
    //metodo para guardar un registro


    //Metodo para editar un registro
     public function update(){
       $this->validate();
       CompanyDB::where('id', $this->idCompany)->update([
         'company' => $this->name,
         'business_rotation_id'=> $this->bussinesId
       ]);
       session()->flash('message-update', 'Se ha actualizado la empresa correctamente');
       $this->emit("update");
     }
    //Metodo para editar un registro

  //Metodo para limpiar campos
   public function clean(){
     $this->idCompany='';
     $this->name='';
     $this->bussinesId='';
     $this->resetValidation();
    //  $this->control=false;
   }
   //Metodo para limpiar campos


}
