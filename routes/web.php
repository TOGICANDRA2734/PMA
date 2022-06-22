<?php

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
        Route::get('/populasi-unit', function () {
            return view('plant.index');
        })->name('plant.index');

    });
});

require __DIR__.'/auth.php';
