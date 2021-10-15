<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Catalog;
use App\Models\IncomeStatementConf;

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
    }
}
