<?php

namespace App\Http\Livewire\BusinessRotatiton;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BusinessRotation as Business;

class BusinessRotation extends Component
{
    use WithPagination; //para utilizar paginacion en livewire
    public $search; //variable que contendra el texto de la busqueda
    public $pagination_size = 10; //numero de paginacion
    protected $queryString=['search' => ['except'=>'']];

    //PROPIEDADES DEL MODELO
    public $name;
    public $idBussineRotation;

    protected $rules = [
      'name'=>'required',
    ];

    //Metodo render, se debe llamar asi y es donde se actualiza los datos de la vista.
    public function render()
    {
          $search=$this->search;
          if($this->search==null || $this->search ==""){
            $business=Business::paginate($this->pagination_size);
          }
          else{
            $business=Business::where('name','like', '%'.$this->search.'%')->paginate($this->pagination_size);
          }
         return view('livewire.business-rotatiton.business-rotation', compact('search','business'));
    }

    //Metodo mount , se debe llamar asi. usualmente se utiliza para resetear alguna variable o asignar
    public function mount(){
        
    }

  //metodo para guardar un registro
    public function store(){
       $this->validate();
       Business::create([
        'name' => $this->name,
       ]);
      session()->flash('message', 'Se ha agregado correctamente el giro empresarial');
      $this->clean();
      $this->emit("send");
    }
    //metodo para guardar un registro

   //metodo para obtener un registro
    public function get($id){
        $data = Business::find($id);
        $this->asigned($data);
        $this->resetValidation();
     }
   //metodo para obtener un registro

   //metodo para eliminar un registro
   public function destroy($id){
     Business::destroy($id);
     session()->flash('message-destroy', 'Se ha eliminado correctamente el giro empresarial');
     $this->emit("destroy");

   }
   //metodo para eliminar un registro

  //Metodo para editar un registro
   public function update(){
     $this->validate();
     Business::where('id', $this->idBussineRotation)->update([
       'name' => $this->name,
     ]);
     session()->flash('message-update', 'Se ha actualizado el giro empresarial correctamente');
     $this->emit("update");
   }
  //Metodo para editar un registro

  //Metodo para asignar los valores a las variables
   private function asigned($data){
      $this->name = $data->name;
      $this->idBussineRotation = $data->id;
    }
  //Metodo para asignar los valores a las variables

   //Metodo para limpiar campos
    public function clean(){
      $this->idBussineRotation='';
      $this->name='';
      $this->resetValidation();
    }
    //Metodo para limpiar campos



}
