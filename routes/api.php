<?php

use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\BloodSugarController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('api')
    ->group(base_path('routes/api/v1/index.php'));


Route::group([
    'prefix' => 'v1/{profile_id}',
    'middleware' => [
        'api',
        'auth:api',
        'profile.verified'
    ]
], function () {
    // Heart Rate Routes
    Route::apiResource('heart-rates', HeartRateController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'heart-rates', 'controller' => HeartRateController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'controller' => HydrationReminderController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

    // Blood Sugar Routes
    Route::apiResource('bs-records', BloodSugarController::class)->only(['index', 'store', 'destroy']);
    Route::get('bs-records/statistics', [BloodSugarController::class, 'getStatistics']);
    Route::post('bs-records/bulk-export', [BloodSugarController::class, 'exportToCsv']);
});

