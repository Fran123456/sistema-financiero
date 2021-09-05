<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LogDB;
use App\Http\Controllers\API;

class GerencialTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gerencial:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar información';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $c =New \App\Http\Controllers\API\APIController();
      $c->getAllInformation();
      $txt = date("Y-m-d H:i:s") . " - Actualizaciones en la base de datos";
      $log= LogDB::create(['log'=> $txt]);




    }
}
