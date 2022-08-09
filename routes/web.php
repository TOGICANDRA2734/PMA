<?php

use App\Http\Controllers\cobacobacontroller;
use App\Http\Controllers\DistribusiJamPMA2BController;
use App\Http\Controllers\MAUnitController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PDFViewController;
use App\Http\Controllers\PopulasiPlantController;
use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\PopulasiUnitPMA2BController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TPController;
use App\Http\Controllers\TransaksiPlantController;
use App\Http\Controllers\TransaksiUnitController;
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
Route::get('/distribusi-jam-tp/pdf', [TPController::class, 'downloadPDF'])->name('distribusi-jam-tp.pdf');
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/populasi-unit-pma2b', [PopulasiUnitPMA2BController::class, 'index'])->name('pma2b.populasi.index');
Route::get('/distribusi-jam-pma2b', [DistribusiJamPMA2BController::class, 'index'])->name('pma2b.distribusi.index');

// Populasi Plant
Route::resource('/populasi-plant', PopulasiPlantController::class);
Route::post('/populasi-plant/showUser', [PopulasiPlantController::class, 'getUserbyid'])->name('populasi-plant.showUser');
Route::get('/transaksi-unit', [TransaksiUnitController::class, 'index'])->name('transaksi-unit.index');
Route::post('/transaksi-unit/store', [TransaksiUnitController::class, 'store'])->name('transaksi-unit.store');
Route::get('/transaksi-unit/edit/{id}', [TransaksiUnitController::class, 'edit'])->name('transaksi-unit.edit');
Route::put('/transaksi-unit/update/{id}', [TransaksiUnitController::class, 'update'])->name('transaksi-unit.update');
Route::put('/transaksi-unit/destroy/{id}', [TransaksiUnitController::class, 'destroy'])->name('transaksi-unit.destroy');


Route::get('/transaksi-plant', [TransaksiPlantController::class, 'index'])->name('transaksi-plant.index');
Route::post('/transaksi-plant/store', [TransaksiPlantController::class, 'store'])->name('transaksi-plant.post');
Route::get('/MA-unit', [MAUnitController::class, 'index'])->name('transaksi-plant.ma');

// File Permintaan pak Fantri untuk DB RAW
Route::get('/cobacoba', [cobacobacontroller::class, 'index'])->name('cobacoba');
Route::get('/page', [PageController::class, 'index'])->name('page.index');
Route::get('generate-pdf-from-view', [PDFViewController::class, 'index']);

require __DIR__.'/auth.php';
