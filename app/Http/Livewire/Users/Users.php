<?php

namespace App\Http\Livewire\Users;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Users extends Component
{
   use WithPagination;
   protected $paginationTheme = 'tailwind'; //deshabilitar si se quiere utilizar la generica
   public $name;
   public $email;
   public $password;
   public $idUser;
   public $search;
   public $role;
   public $status;
   protected $queryString=['search' => ['except'=>'']];
  // public $users;

    public function clean(){//de sistema
     $this->name= "";
     $this->email= "";
     $this->password= "";
     $this->idUser ="";
     $this->search ="";
     $this->role ="";
    }

    public function cleanCreate(){//de sistema
      $this->name= "";
      $this->email= "";
      $this->password= "";
      $this->idUser ="";
      $this->search ="";
      $this->mount();
     }


    public function mount(){
      //$this->role =  Auth::user()->roles[0]->name;
    //  $this->role = Role::where('name','=','Tactico')->get()->first()->name;
    }

    public function render()
    {
      $roles = Role::all();
      if($this->search==null|| $this->search ==""){
        $users = User::orderBy('id','desc')->paginate(5);
      }else{
        $users =User::where('name','like', '%'.$this->search.'%')->orderBy('id','desc')->paginate(5);
      }
       return view('livewire.users.users', compact('users','roles'));
    }

    public function store(){

      $this->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users,email',
        'password'=> 'required',

      ]);
       $u =User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password)
      ]);


      $u->assignRole($this->role);



      session()->flash('message', ':data created successfully');
      $this->clean();
      $this->emit("send");
    }

    public function destroy($id){
      $user = User::find($id);
      User::destroy($id);
      session()->flash('message-destroy', ':data successfully removed');



      $this->emit("destroy");
    }

    public function getUser($id){
       $user = User::find($id);
       $this->asigned($user);
    }

    public function update(){
      $this->validate([
        'name'=>'required',
        'email'=>'required',
      ]);

      $user = User::where('id', $this->idUser)->update([
        'name' => $this->name,
        'email' => $this->email,
      ]);
      $user = User::find($this->idUser);
      if($user->roles[0]->name != $this->name){
        $user->removeRole($user->roles[0]->name);
        $user->assignRole($this->role);
      }

      session()->flash('message-update', ':data successfully updated');
      $this->emit("update");
    }

    private function asigned($user){
      $this->name = $user->name;
      $this->email = $user->email;
      $this->idUser = $user->id;
      $this->role =$user->roles[0]->name;
     //  $this->password = $user->password;
    }

}
