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

        // Unit Routes
        Route::prefix('units')->group(function () {
            Route::get('activity-levels', [App\Http\Controllers\Api\UnitController::class, 'activityLevels']);
            Route::get('bp-units', [App\Http\Controllers\Api\UnitController::class, 'bpUnits']);
            Route::get('feeling-lists', [App\Http\Controllers\Api\UnitController::class, 'feelingLists']);
            Route::get('heart-rate-units', [App\Http\Controllers\Api\UnitController::class, 'heartRateUnits']);
            Route::get('height-units', [App\Http\Controllers\Api\UnitController::class, 'heightUnits']);
            Route::get('medicine-schedules', [App\Http\Controllers\Api\UnitController::class, 'medicineSchedules']);
            Route::get('medicine-types', [App\Http\Controllers\Api\UnitController::class, 'medicineTypes']);
            Route::get('medicine-units', [App\Http\Controllers\Api\UnitController::class, 'medicineUnits']);
            Route::get('physical-conditions', [App\Http\Controllers\Api\UnitController::class, 'physicalConditions']);
            Route::get('sugar-schedules', [App\Http\Controllers\Api\UnitController::class, 'sugarSchedules']);
            Route::get('sugar-units', [App\Http\Controllers\Api\UnitController::class, 'sugarUnits']);
            Route::get('water-units', [App\Http\Controllers\Api\UnitController::class, 'waterUnits']);
            Route::get('weight-units', [App\Http\Controllers\Api\UnitController::class, 'weightUnits']);
        });
    });
});
