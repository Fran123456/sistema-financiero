<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Livewire\Users\Users;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function users(){
      if(Auth::user()->hasPermissionTo('retrieve_users')){
        return view('user.users');
      }
      else{

        abort(403,__('Unauthorized'));
      }

    }

    
}
