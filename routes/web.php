<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('contacts.index');
});

Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
    Route::get('/', [\App\Http\Controllers\ContactController::class, 'index'])->name('index');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/show/{id?}', [\App\Http\Controllers\ContactController::class, 'show'])->name('show');
        Route::post('/save', [\App\Http\Controllers\ContactController::class, 'save'])->name('save');
        Route::delete('/delete/{id}', [\App\Http\Controllers\ContactController::class, 'delete'])->name('delete');
    });
});

Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
    Route::middleware('auth')->get('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'guest'], function () { 
        Route::get('/', [\App\Http\Controllers\LoginController::class, 'index'])->name('index');
        Route::post('/authenticate', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('authenticate');
    });
});
