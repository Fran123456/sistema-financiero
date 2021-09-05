<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\API\APIController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Suggestions\SuggestionsController;
use App\Http\Controllers\Training\TrainingController;
use App\Http\Controllers\ISO\ISOController;
use App\Http\Controllers\Publications\PublicationsController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\BusinessRotation\BusinessRotationController;
use App\Providers\Dashboard;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function(){
  event( new Dashboard(Auth::user()));
  return view('dashboard');
})->name('dashboard');

//user
Route::middleware(['auth:sanctum', 'verified'])->get('users', [UserController::class, 'users'])->name('users');
//print users
Route::middleware(['auth:sanctum', 'verified'])->get('users/print', [UserController::class, 'printUsers'])->name('print_users');

//Role
Route::middleware(['auth:sanctum', 'verified'])->get('/roles', [RoleController::class, 'roles'])->name('roles');

//language
Route::get('/lang/{language}', function ($language) {
  //  Session::put('language',$language);
  session()->put('locale', $language);
  return redirect()->back();
})->name('language')->middleware('translate');

//Giros empresariales
Route::middleware(['auth:sanctum', 'verified'])->get('business-rotation', [BusinessRotationController::class, 'index'])->name('bussiness-rotation-index');




//API
Route::middleware(['auth:sanctum', 'verified'])->get('api-consumption', [APIController::class, 'getAllInformation'])->name('getAllInformation');
