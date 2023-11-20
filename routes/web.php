<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\PhysicalController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SanswitchController;
use App\Http\Controllers\AcserverController;
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
    return view('layouts.app');
});

Route::resource('/physical', PhysicalController::class);
Route::get('/physical/search', 'PhysicalController@index');
Route::post('/physical/store', [PhysicalController::class, 'store'])->name('physical.store');

Route::resource('/sanswitch', SanswitchController::class);
Route::get('/sanswitch/search', 'SanswitchController@index');

Route::resource('/database', DatabaseController::class);
Route::get('/database/search', 'DatabaseController@index');

Route::resource('/acserver', AcserverController::class);
Route::get('/acserver/search', 'AcserverController@index');

Route::get('/login', [LoginController::class, 'index']);
Route::get('/register', [RegisterController::class, 'index']);

