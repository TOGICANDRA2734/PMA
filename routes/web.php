<?php

use App\Http\Controllers\cobacobacontroller;
use App\Http\Controllers\DistribusiJamPMA2BController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\PopulasiUnitPMA2BController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\testingController;
use App\Http\Controllers\TPController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
})->name('dashboard');

Route::get('/populasi-unit-pmh', [PopulasiUnitController::class, 'index'])->name('populasi-unit-pmh.index');
Route::get('/distribusi-jam-tp', [TPController::class, 'index'])->name('distribusi-jam-tp.index');
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/populasi-unit-pma2b', [PopulasiUnitPMA2BController::class, 'index'])->name('pma2b.populasi.index');
Route::get('/distribusi-jam-pma2b', [DistribusiJamPMA2BController::class, 'index'])->name('pma2b.distribusi.index');

// File Permintaan pak Fantri untuk DB RAW
Route::get('/cobacoba', [cobacobacontroller::class, 'index'])->name('cobacoba');
Route::get('/page', [PageController::class, 'index'])->name('page.index');

// Route::prefix('plant')->group(function(){
//     Route::group(['middleware' => 'auth'], function (){        
//         Route::get('/populasi-unit', [PopulasiUnitController::class, 'index'])->name('plant.index');

//     });
// });

Route::get('/coba', [testingController::class, 'index']);

require __DIR__.'/auth.php';
