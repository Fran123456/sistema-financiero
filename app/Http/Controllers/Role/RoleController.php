<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function roles(){
        if(Auth::user()->hasPermissionTo('retrieve_roles')){

            return view('role.roles');
        }
        else{
        

            abort(403,__('Unauthorized'));
        }
    }
}
