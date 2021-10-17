<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Catalog;
use App\Models\IncomeStatementConf;
use App\Models\Periods;

class IncomeStatementConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IncomeStatementConf::create([
          "title"=>"VENTAS NETAS"
        ]);
        IncomeStatementConf::create([
          "title"=>"COSTO DE VENTAS"
        ]);

        IncomeStatementConf::create([
          "title"=>"GASTOS"
        ]);

       Periods::create([
         'year'=>2021
       ]);
       Periods::create([
         'year'=>2020
       ]);

       Periods::create([
         'year'=>2019
       ]);
    }
}
