<?php

namespace App\Http\Livewire\Roles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;
    public $search_role;
    public $pagination_size = 5;

    public $role_name;
    public $role_id;

    protected $queryString=['search_role' => ['except'=>'']];

    protected $rules = [
      'role_name'=>'required|unique:roles,name|alpha',
    ];

    protected $listeners=['showFlashMessage'];

    public function render()
    {
        $search=$this->search_role;

        if($this->search_role==null || $this->search_role ==""){
            $roles=DB::table('roles')
                ->select('roles.id','roles.name',DB::raw('count(model_has_roles.role_id) as conteo'))
                ->leftJoin('model_has_roles','roles.id','=','model_has_roles.role_id')
                ->groupBy('roles.id')
                ->orderBy('roles.name','ASC')
                ->paginate($this->pagination_size);
        }
        else{
            $roles=DB::table('roles')
                ->select('roles.id','roles.name',DB::raw('count(model_has_roles.role_id) as conteo'))
                ->leftJoin('model_has_roles','roles.id','=','model_has_roles.role_id')
                ->where('name','like', '%'.$this->search_role.'%')
                ->groupBy('roles.id')
                ->orderBy('roles.name','ASC')
                ->paginate($this->pagination_size);
        }
        return view('livewire.roles.roles', compact('roles','search'));
    }

    public function getRole($id){
        $role = Role::find($id);
        $this->asigned($role);
        $this->resetValidation();
     }

     public function getRoleForPermissions($id){
      $role = Role::find($id);
      $this->emit('newSelectedRole',$role->id);
   }

     private function asigned($role){
        $this->role_name = $role->name;
        $this->role_id = $role->id;
      }

      public function update(){
        $this->validate();
        Role::where('id', $this->role_id)->update([
          'name' => $this->role_name,
        ]);
        session()->flash('message-update', ':data successfully updated');
        $this->emit("update");


      }

      public function store(){
        $this->validate();
        $new_created_role = Role::create([
          'name' => $this->role_name,
          'guard_name' => 'web'
        ]);
        session()->flash('message', ':data created successfully');

        $this->clean();
        $this->emit("send");
      }

      public function destroy($id){
        $role = Role::find($id);
        Role::destroy($id);
      
        $this->emit("destroy");
      }

      public function clean(){
        $this->role_id='';
        $this->role_name='';
        $this->resetValidation();
      }

      public function showFlashMessage(){
        session()->flash('permissions-update', ':data successfully updated');
        $this->emit("close_modal");
        $this->render();
      }
}
