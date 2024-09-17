<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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
    return view('pages.dashboard');
});

// start auth
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// end auth

// start main route
//Route::get('/dashboard', function () {
  //  return view('pages.dashboard');
//})->name('getDashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('getDashboard');

Route::prefix('company')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('getCompany');
    Route::get('/add', [CompanyController::class, 'getAddCompany'])->name('getAddCompany');
    // Route::post('/add', [CompanyController::class, 'postAddCompany'])->name('postAddCompany');
    // Route::get('/edit', [CompanyController::class, 'getEditCompany'])->name('getEditCompany');
    // Route::post('/edit', [CompanyController::class, 'postEditCompany'])->name('postEditCompany');
});
// end main route
