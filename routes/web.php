<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AcserverController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PhysicalController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SanswitchController;
/*  
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
});

Route::resource('/physical', PhysicalController::class)->middleware('auth');
Route::get('/physical/search', 'PhysicalController@index')->middleware('auth');
Route::post('/physical/store', [PhysicalController::class, 'store'])->name('physical.store');

Route::resource('/sanswitch', SanswitchController::class)->middleware('auth');
Route::get('/sanswitch/search', 'SanswitchController@index');

Route::resource('/database', DatabaseController::class)->middleware('auth');
Route::get('/database/search', 'DatabaseController@index');

Route::resource('/acserver', AcserverController::class)->middleware('auth');
Route::get('/acserver/search', 'AcserverController@index');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::resource('/dashboard', DashboardController::class);

