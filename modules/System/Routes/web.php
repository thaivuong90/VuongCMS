<?php

use Illuminate\Support\Facades\Route;
use VuongCMS\System\Controllers\InstallController;
use VuongCMS\System\Controllers\SystemController;

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

Route::group(['prefix' => 'system', 'as' => 'system.', 'middleware' => 'web'], function () {
    
    Route::get('/create', [SystemController::class, 'create'])->name('create');
    Route::get('/confirmation', [SystemController::class, 'confirmation'])->name('confirmation');
    Route::post('/store', [SystemController::class, 'store'])->name('store');
    Route::match(['post', 'get'], '/login', [SystemController::class, 'login'])->name('login');
    Route::get('/{system}/login', [SystemController::class, 'login'])->name('login.system');
    Route::get('/forgot-password', [SystemController::class, 'forgotPassword'])->name('forgot_password');
    Route::get('/dashboard', [SystemController::class, 'index'])->name('dashboard');
    Route::get('/logout', [SystemController::class, 'logout'])->name('logout');
    Route::group(['middleware' => 'system.auth'], function () {
        Route::get('/dashboard', [SystemController::class, 'index'])->name('dashboard');
    });
});
