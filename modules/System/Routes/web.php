<?php

use Illuminate\Support\Facades\Route;
use VuongCMS\System\Http\Controllers\LoginController;
use VuongCMS\System\Http\Controllers\SystemController;

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
  Route::get('/confirmation/{token?}', [SystemController::class, 'confirmation'])->name('confirmation');
  Route::match(['post', 'get'], '/resend', [SystemController::class, 'resend'])->name('resend');
  Route::post('/store', [SystemController::class, 'store'])->name('store');

  Route::group(['prefix' => '{slug}', 'middleware' => ['check.system']], function () {
    Route::match(['post', 'get'], '/login', [LoginController::class, 'login'])->name('login');
    Route::match(['post', 'get'], '/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot_password');
    Route::get('/activate', [SystemController::class, 'activate'])->name('activate');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
  });
  Route::group(['prefix' => '{slug}', 'middleware' => ['check.auth', 'check.system']], function () {
    Route::get('/dashboard', [SystemController::class, 'index'])->name('dashboard');
  });
});
