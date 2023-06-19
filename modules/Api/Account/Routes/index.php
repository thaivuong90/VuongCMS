<?php
use Illuminate\Support\Facades\Route;
use VuongCMS\Api\Account\Controllers\AccountController;

Route::group(['prefix' => 'account', 'as' => 'acount.'], function () {
    Route::get('/info/{id}', [AccountController::class, 'index'])->name('info');
});