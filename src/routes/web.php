<?php

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
    return view('welcome');
});


Route::middleware(["auth"])->group(function () {

    Route::get("/dashboard", [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get("/reports", [DashboardController::class, 'report'])->name('reports');

    Route::get('/change-password',[DashboardController::class, 'changePassword']);
    Route::post('/change-password',[DashboardController::class, 'storePassword']);
});


require __DIR__ . '/auth.php';
