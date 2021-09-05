<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{

    public function __construct(){
      set_time_limit(8000000);
      ini_set('memory_limit', '1G');
    }

}
