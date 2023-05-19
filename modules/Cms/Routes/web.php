<?php

use Illuminate\Support\Facades\Route;
use VuongCMS\Cms\Controllers\ForgotPasswordController;
use VuongCMS\Cms\Controllers\LoginController;
use VuongCMS\Cms\Controllers\RegisterController;

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

Route::group(['prefix' => 'cms', 'as' => 'cms.', 'middleware' => 'web'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('forgotPassword');
    Route::post('/forgot-password/store', [ForgotPasswordController::class, 'store'])->name('forgotPassword.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');

    Route::group(['middleware' => 'auth.cms'], function () {
        Route::get('/dashboard', function () {
            return view('cms::dashboard.index');
        })->name('dashboard');
    });
});
