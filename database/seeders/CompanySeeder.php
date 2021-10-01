<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company;

class CompanySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $b =  Company::create([
      'company' => 'company 1',
      'business_rotation_id'=> 1
    ]);

    $b =  Company::create([
      'company' => 'company 2',
      'business_rotation_id'=> 2
    ]);
  }
}
