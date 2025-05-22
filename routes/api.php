<?php

use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('api')
    ->group(base_path('routes/api/v1/index.php'));


Route::group([
    'prefix'     => 'v1',
    'middleware' => [
        'api',
        'auth:api'
    ]
], function () {
    // Heart Rate Routes
    Route::apiResource('heart-rates', HeartRateController::class)->only(['store', 'destroy']);
    Route::group(['prefix' => 'heart-rates', 'controller' => HeartRateController::class], function () {
        Route::post('history', 'history');
        Route::post('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::post('history', 'history');
        Route::post('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::post('history', 'history');
        Route::post('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['store', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'controller' => HydrationReminderController::class], function () {
        Route::post('history', 'history');
        Route::post('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
});

