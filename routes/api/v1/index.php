<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group(['controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('user.login');
    Route::post('/register', 'register')->name('user.register');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('profile', [ProfileController::class, 'store'])->name('user.profile.store');
        Route::get('profiles', [ProfileController::class, 'allProfile'])->name('user.profile.list');
        Route::post('/logout', 'logout')->name('user.logout');
    });
});