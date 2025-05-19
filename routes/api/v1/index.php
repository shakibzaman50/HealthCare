<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;


Route::group(['controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api', 'isActive']], function () {
        Route::post('/logout', 'logout')->name('user.logout');
    });
});
