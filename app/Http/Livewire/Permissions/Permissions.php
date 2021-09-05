<?php

namespace App\Http\Livewire\Permissions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Symfony\Component\VarDumper\Dumper\esc;

class Permissions extends Component
{
    public $permissions;
    public $selected_role_id;
    public $selected_role;

    public $checkboxes;
    public $control = 0;

    public $new = [];

    protected $listeners = ['newSelectedRole','newSelectedPermissions'];

    public function render()
    {
        if($this->selected_role != null){
            $this->permissions = DB::table('permissions')
                                ->select('*')
                                ->get();
            foreach ($this->permissions as $key => $permission) {
                $exists = DB::table('role_has_permissions')
                            ->where('role_id','=',$this->selected_role->id)
                            ->where('permission_id','=',$permission->id)
                            ->count('role_id');
                if($exists == 1){
                    $exists = true;
                }
                else{
                    $exists = false;
                }
                $this->checkboxes[$key] = $exists;
            }
        }
        return view('livewire.permissions.permissions');
    }

    public function newSelectedRole($id){
        $role = Role::find($id);
        $this->selected_role = $role;
    }

    public function cleanCheckboxes(){
        $this->checkboxes = [];
    }    

    public function updateCheckbox(){
        if(Auth::user()->hasPermissionTo('assign_permissions')){
            $var = [];
            foreach ($this->checkboxes as $key => $checkbox) {
                $permission = Permission::find($key+1);
                if($this->selected_role->hasPermissionTo($permission->name) && $checkbox == false){
                    $this->selected_role->revokePermissionTo($permission->name);
                    array_push($var,[$permission->name => 'revocado']);
                }
                if($this->selected_role->hasPermissionTo($permission->name) == false && $checkbox == true){
                    $this->selected_role->givePermissionTo($permission->name);
                    array_push($var,[$permission->name => 'asignado']);
                }
            }
            session()->flash('message-update', ':data successfully updated');
            $this->emit("showFlashMessage");

        }
    }
    public function closingModal(){
        $this->emit("close_modal");
    }
}
