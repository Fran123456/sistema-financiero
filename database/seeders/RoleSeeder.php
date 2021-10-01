<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $admin =  Role::create(['name' => 'Administrador']);
    $usuario =  Role::create(['name' => 'Usuario']);


    //Permiso Página de inicio
    Permission::create(['name' => 'dashboard'])->syncRoles([$usuario, $admin]);
    //Permisos para ver,crear,editar y borrar roles
    Permission::create(['name' => 'retrieve_roles'])->syncRoles([$admin]);
    Permission::create(['name' => 'create_roles'])->syncRoles([$admin]);
    Permission::create(['name' => 'edit_roles'])->syncRoles([$admin]);
    Permission::create(['name' => 'delete_roles'])->syncRoles([$admin]);

    //Permisos para ver y asignar permisos
    Permission::create(['name' => 'retrieve_permissions'])->syncRoles([$admin]);
    Permission::create(['name' => 'assign_permissions'])->syncRoles([$admin]);

    //Permisos usuarios
    Permission::create(['name' => 'retrieve_users'])->syncRoles([$admin]);
    Permission::create(['name' => 'create_users'])->syncRoles([$admin]);
    Permission::create(['name' => 'edit_users'])->syncRoles([$admin]);
    Permission::create(['name' => 'delete_users'])->syncRoles([$admin]);


  }
}
