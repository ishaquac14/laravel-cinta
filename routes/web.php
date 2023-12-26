<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AcserverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CsdatabaseController;
use App\Http\Controllers\PhysicalController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SanswitchController;   
use App\Http\Controllers\GacsirtController;
use App\Http\Controllers\FujixeroxController;
use App\Http\Controllers\MointernetController;
use App\Http\Controllers\CctvController;
use App\Http\Controllers\TapedriveController;
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
    return view('/login/index');
});

Route::get('/mointernet/persen_grafik_monitoring_internet', [MointernetController::class, 'grafik_internet'])->name('grafik_internet');

Route::resource('/physical', PhysicalController::class)->middleware('auth');
Route::get('/physical/search', 'PhysicalController@index')->middleware('auth');
// Route::post('/physical/store', [PhysicalController::class, 'store'])->name('physical.store');

Route::resource('/sanswitch', SanswitchController::class);
Route::get('/sanswitch/search', 'SanswitchController@index');

Route::resource('/csdatabase', CsdatabaseController::class)->middleware('auth');
Route::get('/csdatabase/search', 'CsdatabaseController@index');

Route::resource('/acserver', AcserverController::class)->middleware('auth');
Route::get('/acserver/search', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::resource('/dashboard', DashboardController::class)->middleware('auth');

Route::resource('/gacsirt', GacsirtController::class)->middleware('auth');
Route::get('/gacsirt/search', 'GacsirtController@index');

Route::resource('/mointernet', MointernetController::class)->middleware('auth');
Route::get('/mointernet/search', 'MointernetController@index');

Route::resource('/fujixerox', FujixeroxController::class)->middleware('auth');
Route::get('/fujixerox/search', 'FujixeroxController@index');

Route::resource('/cctv', CctvController::class)->middleware('auth');
Route::get('/cctv/search', 'CctvController@index');

Route::resource('/tapedrive', TapedriveController::class)->middleware('auth');
Route::get('/tapedrive/search', 'TapedriveController@index');

Route::get('/chart-data', [MointernetController::class, 'getChartData']);

// Route::prefix('api')->group(function () {
//     Route::get('/chart-data', [MointernetController::class, 'getChartData']);
// });

Route::resource('/cobaadmin', AdminController::class)->middleware('role');

// Route::get('/test', [AcserverController::class, 'alert'])->name('alert');
// Route::post('/csdatabase/approval/{id}', [ApprovalController::class, 'ApproveCsdatabase'])->name('approvalCsdatabase');
// Route::post('/tapedrive/approval/{id}', [ApprovalController::class, 'ApproveTapedrive'])->name('approvalTapedrive');
// Route::post('/gacsirt/approval/{id}', [ApprovalController::class, 'ApproveGacsirt'])->name('approvalGacsirt');
// Route::post('/mointernet/approval/{id}', [ApprovalController::class, 'ApproveMointernet'])->name('approvalMointernet');
// Route::post('/physical/approval/{id}', [ApprovalController::class, 'ApprovePhysical'])->name('approvalPhysical');
// Route::post('/fujixerox/approval/{id}', [ApprovalController::class, 'ApproveFujixerox'])->name('approvalFujixerox');
// Route::post('/sanswitch/approval/{id}', [ApprovalController::class, 'ApproveSanswitch'])->name('approvalSanswitch');

Route::post('/acserver/approval', [AcserverController::class, 'approval_acserver'])->name('approval_acserver');
Route::post('/csdatabase/approval', [CsdatabaseController::class, 'approval_csdatabase'])->name('approval_csdatabase');
Route::post('/tapedrive/approval', [TapedriveController::class, 'approval_tapedrive'])->name('approval_tapedrive');
Route::post('/gacsirt/approval', [GacsirtController::class, 'approval_gacsirt'])->name('approval_gacsirt');
Route::post('/mointernet/approval', [MointernetController::class, 'approval_mointernet'])->name('approval_mointernet');
Route::post('/physical/approval', [PhysicalController::class, 'approval_physical'])->name('approval_physical');
Route::post('/fujixerox/approval', [FujixeroxController::class, 'approval_fujixerox'])->name('approval_fujixerox');
Route::post('/cctv/approval', [CctvController::class, 'approval_cctv'])->name('approval_cctv');



// Route::post('approval/{id}', 'ApprovalController@approve')->name('approval.action');
