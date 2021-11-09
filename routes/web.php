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
use App\Http\Controllers\Balance\BalanceController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Providers\Dashboard;
use App\Http\Controllers\Company\CompanyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnalisisHV\AnalisisHVController;

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

//empresa
Route::middleware(['auth:sanctum', 'verified'])->get('companies', [CompanyController::class, 'index'])->name('company-index');

//catalogo
Route::middleware(['auth:sanctum', 'verified'])->get('catalog/status/{catalogId}', [CatalogController::class, 'changeStatus'])->name('catalog-change');
Route::middleware(['auth:sanctum', 'verified'])->get('catalog/{id}', [CatalogController::class, 'index'])->name('catalog-index');
Route::middleware(['auth:sanctum', 'verified'])->get('catalog/accounts/{id}', [CatalogController::class, 'accounts'])->name('accounts-index');
Route::middleware(['auth:sanctum', 'verified'])->post('catalog-accounts-upload', [CatalogController::class, 'upload'])->name('accounts-upload');

//balances conf
Route::middleware(['auth:sanctum', 'verified'])->get('balances-menu/{companyId}', [BalanceController::class, 'index'])->name('balances-menu');
Route::middleware(['auth:sanctum', 'verified'])->get('income-statement-conf/{companyId}', [BalanceController::class, 'IncomeStatementConf'])->name('incomestatement-conf');
Route::middleware(['auth:sanctum', 'verified'])->get('income-statement/{companyId}', [BalanceController::class, 'IncomeStatement'])->name('incomestatement');
Route::middleware(['auth:sanctum', 'verified'])->get('income-statement/income/save', [BalanceController::class, 'SaveIncomeStatement'])->name('incomestatement-save');
Route::middleware(['auth:sanctum', 'verified'])->get('income-statement/income/delete/{period}/{company}', [BalanceController::class, 'deleteIncomeStatement'])->name('incomestatement-delete');
//balance (general) conf
Route::middleware(['auth:sanctum', 'verified'])->get('balance-sheet-conf/{companyId}', [BalanceController::class, 'balanceSheetConf'])->name('balanceSheet-conf');
Route::middleware(['auth:sanctum', 'verified'])->get('balance-sheet/{companyId}', [BalanceController::class, 'balanceSheet'])->name('balanceSheet');
Route::middleware(['auth:sanctum', 'verified'])->get('balance-sheet/sheet/save', [BalanceController::class, 'SaveBalanceSheet'])->name('balancesheet-save');
Route::middleware(['auth:sanctum', 'verified'])->get('balance-sheet/sheet/delete/{period}/{company}', [BalanceController::class, 'deleteBalanceSheet'])->name('balancesheet-delete');

//Analisis V y H
Route::middleware(['auth:sanctum', 'verified'])->get('balances-menu/balance-analize/{company}', [AnalisisHVController::class, 'balanceAnalize'])->name('balanceAnalize');
Route::middleware(['auth:sanctum', 'verified'])->get('balances-menu/income-analize/{company}', [AnalisisHVController::class, 'incomeAnalize'])->name('incomeAnalize');

