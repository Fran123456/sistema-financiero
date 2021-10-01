<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\BusinessRotation;

class BusinessRotationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $b =  BusinessRotation::create([
      'name' => 'Industrial',
    ]);

    $b =  BusinessRotation::create([
      'name' => 'Comercial',
    ]);
  }
}
