<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('user.login');
    Route::post('/register', 'register')->name('user.register');
    Route::post('/activate-account', 'activateAccount')->name('user.activate');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('profile', [ProfileController::class, 'store'])->name('user.profile.store');
        Route::get('profiles', [ProfileController::class, 'allProfile'])->name('user.profile.list');
        Route::get('user', [UserController::class, 'show'])->name('user.show');
        Route::post('update-user', [UserController::class, 'update'])->name('user.update');
        Route::post('update-password', [UserController::class, 'updatePassword'])->name('user.update.password');
        Route::post('/logout', 'logout')->name('user.logout');
    });
});