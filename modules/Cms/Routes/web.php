<?php

use Illuminate\Support\Facades\Route;
use VuongCMS\Cms\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/doRegister', [LoginController::class, 'doRegister'])->name('doRegister');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('cms::dashboard.index');
    });
});
