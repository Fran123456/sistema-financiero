<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user =  User::create([
      'name' => 'Francisco Navas',
      'email' => 'navasfran98@gmail.com',
      'password' => Hash::make('paginaazul'),
    ])->assignRole('Administrador');

    $user =  User::create([
      'name' => 'Ruddy Alfredo',
      'email' => 'ruddyperez747@gmail.com',
      'password' => Hash::make('password'),
    ])->assignRole('Administrador');

    $user =  User::create([
      'name' => 'Franklin Perez',
      'email' => 'franklin9perez952012@gmail.com',
      'password' => Hash::make('purauvamami'),
    ])->assignRole('Administrador');
  }
}
