<?php

use App\Http\Controllers\cobacobacontroller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\testingController;
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

Route::get('/home', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/populasi-unit', [PopulasiUnitController::class, 'index'])->name('plant.index');
Route::get('/page', [PageController::class, 'index'])->name('page.index');
Route::get('/cobacoba', [cobacobacontroller::class, 'index'])->name('cobacoba');
Route::get('/store', [cobacobacontroller::class, 'index'])->name('cobacoba');

// Route::prefix('plant')->group(function(){
//     Route::group(['middleware' => 'auth'], function (){        
//         Route::get('/populasi-unit', [PopulasiUnitController::class, 'index'])->name('plant.index');

//     });
// });

Route::get('/coba', [testingController::class, 'index']);

require __DIR__.'/auth.php';
