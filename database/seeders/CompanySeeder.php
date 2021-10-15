<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Catalog;

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

    //catalog
    Catalog::create([
      'catalog'=>'catalogo 1 - company 1',
      'status'=>true,
      'company_id'=> $b->id,
      'user_id'=> 1
    ]);

    $b =  Company::create([
      'company' => 'company 2',
      'business_rotation_id'=> 2
    ]);

    //catalog
    Catalog::create([
      'catalog'=>'catalogo 1 - company 2',
      'status'=>true,
      'company_id'=> $b->id,
      'user_id'=> 1
    ]);


  }
}
