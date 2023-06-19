<?php
use Illuminate\Support\Facades\Route;
use VuongCMS\Api\Auth\Controllers\LoginController;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::match(['get', 'post'], '/login', [LoginController::class, 'index'])->name('login');
});