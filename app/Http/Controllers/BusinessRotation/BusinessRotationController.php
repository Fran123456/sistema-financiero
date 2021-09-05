<?php

namespace App\Http\Controllers\BusinessRotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessRotation;

class BusinessRotationController extends Controller
{
    public function index(){ //View all the busines rotation
       return view('business-rotation.business-rotation-index');
    }
}
