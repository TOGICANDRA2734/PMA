<?php

use App\Http\Controllers\PopulasiUnitController;
use App\Http\Controllers\testingController;
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
    return view('home.index');
})->middleware(['auth'])->name('home.index');

Route::prefix('plant')->group(function(){
    Route::group(['middleware' => 'auth'], function (){        
        Route::get('/populasi-unit', [PopulasiUnitController::class, 'index'])->name('plant.index');

    });
});

Route::get('/coba', [testingController::class, 'index']);

require __DIR__.'/auth.php';
